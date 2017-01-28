<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin\Milkshake {

    use Minute\Database\Dumper;
    use Minute\Routing\RouteEx;
    use Minute\View\Helper;
    use Minute\View\View;

    class Dump {
        /**
         * @var Dumper
         */
        private $dumper;

        /**
         * Dump constructor.
         *
         * @param Dumper $dumper
         */
        public function __construct(Dumper $dumper) {
            $this->dumper = $dumper;
        }

        public function index(bool $with_data, int $rows) {
            return $this->dumper->mysqlDump(true, $with_data, $rows);
        }
    }
}