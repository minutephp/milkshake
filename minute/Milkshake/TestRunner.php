<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 12/19/2016
 * Time: 6:58 PM
 */
namespace Minute\Milkshake {

    use App\Model\MTest;
    use App\Model\MTestResult;
    use App\Model\User;
    use Carbon\Carbon;
    use Minute\Config\Config;
    use Minute\Database\Database;
    use Minute\Database\Dumper;
    use Minute\Error\TestRunnerError;
    use Minute\Event\Dispatcher;
    use Minute\Event\RawMailEvent;
    use Minute\Event\UserUploadEvent;
    use Minute\File\TmpDir;
    use Minute\Http\Browser;
    use Minute\Session\Session;
    use Minute\Shell\Shell;
    use Minute\Utils\PathUtils;
    use Swift_Attachment;
    use Swift_Message;

    class TestRunner {
        /**
         * @var Session
         */
        private $session;
        /**
         * @var Config
         */
        private $config;
        /**
         * @var Dumper
         */
        private $dumper;
        /**
         * @var Database
         */
        private $database;
        /**
         * @var Shell
         */
        private $shell;
        /**
         * @var TmpDir
         */
        private $tmpDir;
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var PathUtils
         */
        private $utils;
        /**
         * @var Browser
         */
        private $browser;
        /**
         * @var Swift_Message
         */
        private $message;

        /**
         * RunTest constructor.
         *
         * @param Session $session
         * @param Config $config
         * @param Dumper $dumper
         * @param Database $database
         * @param Shell $shell
         * @param TmpDir $tmpDir
         * @param Dispatcher $dispatcher
         * @param PathUtils $utils
         * @param Browser $browser
         * @param Swift_Message $message
         */
        public function __construct(Session $session, Config $config, Dumper $dumper, Database $database, Shell $shell, TmpDir $tmpDir, Dispatcher $dispatcher, PathUtils $utils,
                                    Browser $browser, Swift_Message $message) {
            set_time_limit(15 * 60);

            $this->session    = $session;
            $this->config     = $config;
            $this->dumper     = $dumper;
            $this->database   = $database;
            $this->shell      = $shell;
            $this->tmpDir     = $tmpDir;
            $this->dispatcher = $dispatcher;
            $this->utils      = $utils;
            $this->browser    = $browser;
            $this->message    = $message;
        }

        public function run(MTest $test, bool $dryRun = false) {
            $addCookie = function ($name, $value) {
                return sprintf('phantom.addCookie({"name":"%s","value":"%s","domain":".%s","path":"/"});%s', $name, $value, $this->config->getPublicVars('domain'), PHP_EOL);
            };

            $script  = $test->casper_script;
            $cookies = $addCookie('XDEBUG_SESSION', 'PHPSTORM');

            if ($run_as = $test->run_as) {
                if ($user = filter_var($run_as, FILTER_VALIDATE_EMAIL) ? User::where('email', '=', $run_as)->first() : User::find($run_as)) {
                    $jwt = $this->session->getSessionCookie($user->user_id, '+1 hour');
                    $cookies .= $addCookie(Session::COOKIE_NAME, $jwt);
                }
            }

            if ($test->test_db === 'true' && ($dump = $test->sql_dump)) {
                $dsn    = $this->database->getDsn();
                $testDb = sprintf("%s_test", $dsn['database']);

                try {
                    $this->database->getPdo()->exec("DROP DATABASE `$testDb`; CREATE DATABASE IF NOT EXISTS `$testDb`;");
                } catch (\Throwable $e) {
                }

                if ($this->dumper->mysqlImport($dump, $testDb, $dsn)) {
                    $cookies .= $addCookie('USE_TEST_DSN', getenv('USE_TEST_DSN') ?: 'sanchit123');
                } else {
                    throw new TestRunnerError("$testDb does not exists or is not accessible");
                }
            }

            $screenshot = $this->tmpDir->getTempFile('.png');
            $pageSource = $this->tmpDir->getTempFile('.html');
            $filename   = $this->tmpDir->getTempFile('.js');

            $script = preg_replace('/(casper\.start)/', "$cookies\n$1", $script, 1);
            $script .= sprintf("\n\ncasper.test.tearDown(function() { var fs = require('fs'); fs.write('%s', casper.getHTML(), 'w'); casper.capture('%s'); });", addslashes($pageSource), addslashes($screenshot));

            try {
                file_put_contents($filename, $script);

                $output = $this->shell->capture('casperjs test "%s" --web-security=no', $filename);
                $result = ['status' => 'FAIL', 'pass' => 0, 'fail' => 0, 'dubious' => 0, 'skipped' => 0];

                if (preg_match('/^(PASS|FAIL).*executed.*(\d+) passed, (\d+) failed, (\d+) dubious, (\d+) skipped/m', $output, $matches)) {
                    $result = array_combine(array_keys($result), array_slice($matches, 1));
                }

                if (!$dryRun) {
                    $ping = $test->ping ?: 'never';

                    if ($fail = $result['status'] !== 'PASS') {
                        if (is_file($screenshot)) {
                            $event = new UserUploadEvent(1, $screenshot, "test-" . basename($screenshot));
                            $this->dispatcher->fire(UserUploadEvent::USER_UPLOAD_FILE, $event);
                            $screenshotUrl = $event->getUrl();
                        }
                    }

                    if (!empty($test->ping_to) && ($ping == 'always') || ($ping == 'fail' && $result['status'] == 'FAIL')) {
                        if (filter_var($test->ping_to, FILTER_VALIDATE_EMAIL)) {
                            foreach ($result as $key => $value) {
                                $results[] = sprintf("%s:%s", ucfirst($key), $value);
                            }

                            $this->message->setFrom(sprintf('noreply@%s', $this->config->getPublicVars('domain')), 'Milkshake test result');
                            $this->message->setTo($test->ping_to);
                            $this->message->setSubject(sprintf("%s test: %s", $test->name, $result['status']));
                            $this->message->setBody(sprintf("Results for %s:%s\n\n%s\nOutput:\n-----\n%s\n\n---\nMilkshake testing framework.", $test->name, $result['status'], join("\n", $results ?? []), $output));
                            $this->message->attach(Swift_Attachment::fromPath($filename)->setFilename("$filename.txt"));

                            if (is_file($screenshot)) {
                                $this->message->attach(Swift_Attachment::fromPath($screenshot, 'image/png'));
                            }

                            if (is_file($pageSource)) {
                                $this->message->attach(Swift_Attachment::fromPath($pageSource, 'text/html'));
                            }

                            $event = new RawMailEvent($this->message);
                            $this->dispatcher->fire(RawMailEvent::MAIL_SEND_RAW, $event);
                        } elseif (filter_var($test->ping_to, FILTER_VALIDATE_URL)) {
                            $this->browser->getUrl(sprintf('%s?%s', $test->ping_to, http_build_query($result)));
                        }
                    }

                    MTestResult::unguard(true);
                    MTestResult::create(['test_id' => $test->test_id, 'created_at' => Carbon::now(), 'status' => $fail ? 'fail' : 'pass', 'result_json' => json_encode($result),
                                         'screenshot' => $screenshotUrl ?? null, 'page_source' => $fail ? @file_get_contents($pageSource) ?: null : null, 'casper_log' => $fail ? $output : null]);
                }
            } finally {
                /*@unlink($filename);
                @unlink($screenshot);
                @unlink($pageSource);*/
            }

            return array_merge($result ?? [], ['output' => $output]);
        }
    }
}