<div class="content-wrapper ng-cloak" ng-app="resultListApp" ng-controller="resultListController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1><span translate="">List of test results</span> <small>(<a ng-href="/admin/milkshake/tests/edit/{{test.test_id}}">{{test.name}}</a>)</small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li><a href="" ng-href="/admin/milkshake"><i class="fa fa-dashboard"></i> <span translate="">Milkshake</span></a></li>
                <li class="active"><i class="fa fa-result"></i> <span translate="">Test results</span></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">Recent test results</span>
                    </h3>
                </div>

                <div class="box-body">
                    <div class="list-group">
                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{pass && 'success' || 'danger'}}" ng-init="pass = result.status === 'pass'"
                             ng-repeat="result in results" ng-click-container="mainCtrl.actions(result)">
                            <div class="pull-left" ng-initz="!$index && mainCtrl.view(result)">
                                <h4 class="list-group-item-heading"><span translate="">Test #</span>{{result.test_result_id}}</h4>
                                <p class="list-group-item-text hidden-xs">
                                    <span translate="">Created:</span> {{result.created_at | timeAgo}}.
                                    <span translate="">Status:</span> <span class="label label-{{pass && 'success' || 'danger'}}">{{result.status}}</span>
                                </p>
                            </div>
                            <div class="md-actions pull-right">
                                <a class="btn btn-default btn-flat btn-sm" ng-click="mainCtrl.view(result)">
                                    <i class="fa fa-search"></i> <span translate="">View details..</span>
                                </a>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="results" no-results="{{'No results found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="results" columns="status" label="{{'Search results..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/ng-template" id="/result-popup.html">
        <div class="box {{pass && 'box-success' || 'box-danger box-lg'}}" ng-init="pass = result.status === 'pass'">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Result #{{result.test_result_id}}</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <form class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Performed:</span></label>
                        <div class="col-sm-9">
                            <p class="help-block">{{result.created_at | timeAgo}}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Status:</span></label>
                        <div class="col-sm-9">
                            <p class="help-block"><span class="label label-{{pass && 'success' || 'danger'}}">{{result.status}}</span></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Details:</span></label>
                        <div class="col-sm-9">
                            <ol class="breadcrumb">
                                <li ng-repeat="(key, value) in result.result_json"><a href="">{{key | ucfirst}}: {{value}}</a></li>
                            </ol>
                        </div>
                    </div>

                    <div ng-show="!pass">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span translate="">Screenshot:</span></label>
                            <div class="col-sm-9">
                                <p class="help-block">
                                    <a ng-href="{{result.screenshot}}"><img class="thumbnail" ng-src="{{result.screenshot}}" style="max-height: 50px;"></a>
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="capture"><span translate="">Casper log:</span></label>
                            <div class="col-sm-9">
                                <pre class="pre-scrollable">{{result.casper_log}}</pre>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="capture"><span translate="">Page source:</span></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="3" readonly title="page source">{{result.page_source}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </script>

</div>
