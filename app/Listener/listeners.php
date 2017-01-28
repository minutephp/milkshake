<?php

/** @var Binding $binding */
use Minute\Docker\CasperJs;
use Minute\Event\AdminEvent;
use Minute\Event\Binding;
use Minute\Event\DockerEvent;
use Minute\Event\TodoEvent;
use Minute\Menu\MilkshakeMenu;
use Minute\Todo\MilkshakeTodo;

$binding->addMultiple([
    //debug
    ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [MilkshakeMenu::class, 'adminLinks']],

    //tasks
    ['event' => TodoEvent::IMPORT_TODO_ADMIN, 'handler' => [MilkshakeTodo::class, 'getTodoList']],

    //docker
    ['event' => DockerEvent::DOCKER_INCLUDE_FILES, 'handler' => [CasperJs::class, 'docker'], 'priority' => 2],
]);