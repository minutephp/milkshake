<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 11/5/2016
 * Time: 11:04 AM
 */
namespace Minute\Todo {

    use App\Model\MTest;
    use Minute\Config\Config;
    use Minute\Event\ImportEvent;

    class MilkshakeTodo {
        /**
         * @var TodoMaker
         */
        private $todoMaker;

        /**
         * MailerTodo constructor.
         *
         * @param TodoMaker $todoMaker - This class is only called by TodoEvent (so we assume TodoMaker is be available)
         */
        public function __construct(TodoMaker $todoMaker, Config $config) {
            $this->todoMaker = $todoMaker;
        }

        public function getTodoList(ImportEvent $event) {
            $todos[] = ['name' => "Create a milkshake test", 'description' => 'Create milkshake tests for functional testing',
                        'status' => MTest::where('enabled', '=', 'true')->count() > 0 ? 'complete' : 'incomplete', 'link' => '/admin/milkshake'];

            $event->addContent(['Debug' => $todos]);
        }
    }
}