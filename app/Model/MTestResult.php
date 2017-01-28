<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MTestResult extends ModelEx {
        protected $table      = 'm_test_results';
        protected $primaryKey = 'test_result_id';
    }
}