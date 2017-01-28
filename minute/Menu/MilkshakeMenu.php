<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Menu {

    use Minute\Event\ImportEvent;

    class MilkshakeMenu {
        public function adminLinks(ImportEvent $event) {
            $links = [
                'milkshake' => ['title' => 'Milkshake tests', 'icon' => 'fa-beer', 'priority' => 50, 'href' => '/admin/milkshake']
            ];

            $event->addContent($links);
        }
    }
}