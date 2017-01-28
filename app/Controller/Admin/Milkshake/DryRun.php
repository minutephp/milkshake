<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin\Milkshake {

    use Minute\Milkshake\TestRunner;
    use Minute\Model\CollectionEx;
    use Minute\Routing\RouteEx;
    use Minute\View\Helper;
    use Minute\View\View;

    class DryRun {
        /**
         * @var TestRunner
         */
        private $testRunner;

        /**
         * DryRun constructor.
         *
         * @param TestRunner $testRunner
         */
        public function __construct(TestRunner $testRunner) {
            $this->testRunner = $testRunner;
        }

        public function index(CollectionEx $tests) {
            $test   = $tests->first();
            $output = $this->testRunner->run($test);

            $html = sprintf('<h3>Casper Output:</h3><pre>%s</pre><h3>Full results:</h3><p><a href="/admin/milkshake/tests/results/%d">View log</a></p>',
                json_encode($output, JSON_PRETTY_PRINT), $test->test_id);

            return $html;
        }
    }
}