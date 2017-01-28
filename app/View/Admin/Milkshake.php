<div class="content-wrapper ng-cloak" ng-app="testListApp" ng-controller="testListController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1><span translate="">List of tests</span> <small><span translate="">(milkshake testing framework)</span></small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li class="active"><i class="fa fa-test"></i> <span translate="">Test list</span></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">All tests</span>
                    </h3>

                    <div class="box-tools">
                        <a class="btn btn-sm btn-primary btn-flat" ng-href="/admin/milkshake/tests/edit">
                            <i class="fa fa-plus-circle"></i> <span translate="">Create new test</span>
                        </a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="list-group">
                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{pass && 'success' || 'danger'}}" ng-init="pass = test.result.status === 'pass'"
                             ng-repeat="test in tests" ng-click-container="mainCtrl.actions(test)">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading">{{test.name | ucfirst}}</h4>
                                <p class="list-group-item-text hidden-xs">
                                    <span translate="">Created:</span> {{test.created_at | timeAgo}}.
                                    <span translate="">Description:</span> {{test.description}}.
                                </p>
                                <p class="list-group-item-text" ng-show="!!test.result.status">
                                    <span class="hidden-xs" translate="">Last Result:</span> <span class="label label-{{pass && 'success' || 'danger'}}">{{test.result.status}}</span>
                                </p>
                            </div>
                            <div class="md-actions pull-right" ng-switch on="!!test.result.status">
                                <a class="btn btn-default btn-flat btn-sm" ng-href="/admin/milkshake/tests/results/{{test.test_id}}" ng-switch-when="true">
                                    <i class="fa fa-search"></i> <span translate="">Log..</span>
                                </a>
                                <a class="btn btn-default btn-flat btn-sm" ng-href="/admin/milkshake/tests/edit/{{test.test_id}}" ng-switch-when="false">
                                    <i class="fa fa-pencil-square-o"></i> <span translate="">Edit..</span>
                                </a>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="tests" no-results="{{'No tests found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="tests" columns="name, description, url" label="{{'Search tests..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
