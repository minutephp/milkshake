<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 12/19/2016
 * Time: 7:15 PM
 */
namespace App\Controller\Cron {

    use App\Model\MTest;
    use Minute\Config\Config;
    use Minute\Event\Dispatcher;
    use Minute\Event\RawMailEvent;
    use Minute\Http\Browser;
    use Minute\Milkshake\TestRunner;
    use Swift_Message;

    class RunTest {
        /**
         * @var TestRunner
         */
        private $testRunner;
        /**
         * @var Browser
         */
        private $browser;
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var Swift_Message
         */
        private $message;
        /**
         * @var Config
         */
        private $config;

        /**
         * RunTest constructor.
         *
         * @param Config $config
         * @param TestRunner $testRunner
         * @param Browser $browser
         * @param Dispatcher $dispatcher
         * @param Swift_Message $message
         */
        public function __construct(Config $config, TestRunner $testRunner, Browser $browser, Dispatcher $dispatcher, Swift_Message $message) {
            $this->config     = $config;
            $this->testRunner = $testRunner;
            $this->browser    = $browser;
            $this->dispatcher = $dispatcher;
            $this->message    = $message;
        }

        public function runTests() {
            $tests = MTest::where('enabled', '=', 'true')->get();

            foreach ($tests as $test) {
                $this->testRunner->run($test);
            }
        }
    }
}