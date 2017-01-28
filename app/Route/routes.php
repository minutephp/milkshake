<?php

/** @var Router $router */
use Minute\Model\Permission;
use Minute\Routing\Router;

$router->get('/admin/milkshake', null, 'admin', 'm_tests[5] as tests', 'm_test_results[tests.test_id] as result order by test_result_id DESC')
       ->setReadPermission('tests', 'admin')->setDefault('tests', '*');
$router->post('/admin/milkshake', null, 'admin', 'm_tests as tests')
       ->setAllPermissions('tests', 'admin');

$router->get('/admin/milkshake/tests/edit/{test_id}', 'Admin/Milkshake/TestsEdit', 'admin', 'm_tests[test_id] as tests')
       ->setReadPermission('tests', 'admin')->setDefault('test_id', '0');
$router->post('/admin/milkshake/tests/edit/{test_id}', null, 'admin', 'm_tests as tests')
       ->setAllPermissions('tests', 'admin')->setDefault('test_id', '0');

$router->post('/admin/milkshake/dump', 'Admin/Milkshake/Dump', 'admin');

$router->get('/admin/milkshake/dry-run/{test_id}', 'Admin/Milkshake/DryRun', 'admin', 'm_tests[test_id] as tests')
       ->setReadPermission('tests', 'admin')->setDefault('_noView', true);

$router->get('/admin/milkshake/tests/results/{test_id}', null, 'admin', 'm_test_results[test_id][5] as results ORDER BY test_result_id DESC', 'm_tests[test_id][1] as tests')
       ->setReadPermission('results', 'admin')->setReadPermission('tests', 'admin');
$router->post('/admin/milkshake/tests/results/{test_id}', null, 'admin', 'm_test_results as test_results')
       ->setAllPermissions('test_results', 'admin');