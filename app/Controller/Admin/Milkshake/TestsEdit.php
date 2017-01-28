<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin\Milkshake {

    use Minute\Routing\RouteEx;
    use Minute\View\Helper;
    use Minute\View\View;

    class TestsEdit {

        public function index(RouteEx $_route) {
            return (new View())->with(new Helper('JsonEditor'));
        }
    }
}