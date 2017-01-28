<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MTest extends ModelEx {
        protected $table      = 'm_tests';
        protected $primaryKey = 'test_id';
    }
}