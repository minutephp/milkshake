<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 1/10/2017
 * Time: 11:37 AM
 */
namespace Minute\Docker {

    use Minute\Event\DockerEvent;

    class CasperJs {
        public function docker(DockerEvent $event) {
            $event->addContent('Dockerfile', sprintf('RUN npm install -g phantomjs casperjs; exit 0'));
        }
    }
}