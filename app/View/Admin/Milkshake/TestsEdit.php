<div class="content-wrapper ng-cloak" ng-app="testEditApp" ng-controller="testEditController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1>
                <span translate="" ng-show="!test.test_id">Create new</span>
                <span translate="" ng-show="!!test.test_id">Edit</span>
                <span translate="">test</span>
            </h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li><a href="" ng-href="/admin/milkshake"><i class="fa fa-test"></i> <span translate="">Tests</span></a></li>
                <li class="active"><i class="fa fa-edit"></i> <span translate="">Edit test</span></li>
            </ol>
        </section>

        <section class="content">
            <form class="form-horizontal" name="testForm" ng-submit="mainCtrl.save()">
                <div class="box box-{{testForm.$valid && 'success' || 'danger'}}">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span translate="" ng-show="!test.test_id">New test</span>
                            <span ng-show="!!test.test_id"><span translate="">Edit</span> {{test.name}}</span>
                        </h3>
                        <div class="box-tools" ng-show="!!test.test_id">
                            <button type="button" class="btn btn-flat btn-default btn-sm" ng-click="mainCtrl.run(test.test_id)">
                                <i class="fa fa-bolt"></i> <span translate="">Run test</span>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="name"><span translate="">Name:</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" placeholder="Enter test name" ng-model="test.name" ng-required="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="description"><span translate="">Description:</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" placeholder="Enter test description" ng-model="test.description" ng-required="false">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="run_as"><span translate="">Run as user:</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="run_as" placeholder="User ID or Email" ng-model="test.run_as" ng-required="false">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span translate="">CasperJS script:</span></label>
                            <div class="col-sm-9">
                                <p class="help-block">
                                    <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="mainCtrl.editScripts()">
                                        <i class="fa fa-code"></i> <span translate="">Paste script..</span>
                                    </button>
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span translate="">Database mode:</span></label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" ng-model="test.test_db" ng-value="true"> <span translate="">Use Test database (recommended)</span>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" ng-model="test.test_db" ng-value="false"> <span translate="">Run on actual database (may change site data)</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group" ng-show="!!test.test_db">
                            <label class="col-sm-3 control-label"><span translate="">SQL dump:</span></label>
                            <div class="col-sm-9">
                                <p class="help-block">
                                    <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="mainCtrl.editDump()">
                                        <i class="fa fa-edit"></i> <span translate="">Edit SQL Dump..</span>
                                    </button>
                                </p>
                            </div>
                        </div>

                        <div class="form-group" ng-init="test.ping = test.ping || 'never'">
                            <label class="col-sm-3 control-label"><span translate="">Ping:</span></label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" ng-model="test.ping" ng-value="'never'"> <span translate="">Never</span>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" ng-model="test.ping" ng-value="'fail'"> <span translate="">Only if test fails</span>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" ng-model="test.ping" ng-value="'always'"> <span translate="">Always after test is run</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group" ng-if="test.ping && test.ping != 'never'">
                            <label class="col-sm-3 control-label" for="ping_to"><span translate="">Ping address:</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="ping_to" placeholder="Enter URL or Email address to ping with results" ng-model="test.ping_to" ng-required="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span translate="">Enabled:</span></label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" ng-model="test.enabled" ng-value="true"> <span translate="">Yes</span>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" ng-model="test.enabled" ng-value="false"> <span translate="">No</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-flat btn-primary">
                                    <span translate="" ng-show="!test.test_id">Create</span>
                                    <span translate="" ng-show="!!test.test_id">Update</span>
                                    <span translate="">test</span>
                                    <i class="fa fa-fw fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>

    <script type="text/ng-template" id="/clone-db-popup.html">
        <div class="box box-md">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Clone database</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <form class="form-horizontal" ng-submit="hide()">
                <div class="box-body">
                    <p class="help-block"><span translate="">Instead of running tests on your live database, you can create a test database named {{data.settings.dbName || '[dbname]'}}_test with
                            the same username and password as your main database.</span></p>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Test Db Name:</span></label>
                        <div class="col-sm-9">
                            <p class="help-block">{{data.settings.dbName || '[dbname]'}}_test</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="dump">
                            <span translate="">Sql dump:</span>
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="5" placeholder="Enter Sql dump" ng-model="test.sql_dump" ng-required="false"></textarea>
                            <p class="help-block"><span translate="">Your test database will be initialized with this SQL dump before running the test</span></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Import dump:</span></label>
                        <div class="col-sm-9">
                            <p class="help-block">
                                <button type="button" class="btn btn-flat btn-default btn-sm" ng-click="ctrl.importDump()">
                                    <i class="fa fa-download"></i> <span translate="">Get SQL dump from current database..</span>
                                </button>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="box-footer with-border">
                    <button type="submit" class="btn btn-flat btn-primary pull-right">
                        <i class="fa fa-check-circle"></i> <span translate>Save</span>
                    </button>
                </div>
            </form>
        </div>
    </script>

    <script type="text/ng-template" id="/scripts-popup.html">
        <div class="box box-md">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Paste your CasperJS script</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <form ng-submit="hide()">
                <div class="box-body">
                    <p class="help-block">
                        <span translate="">This CasperJS script will be run via PhantomJS. You can also use ResurrectIO's chrome plugin to record CasperJS scripts.</span>
                    </p>

                    <div class="form-group">
                        <p class="help-block">{{script.help}}</p>
                        <textarea class="form-control" rows="10" placeholder="Paste your CasperJS script here" ng-model="test.casper_script" ng-required="false"></textarea>
                    </div>
                </div>

                <div class="box-footer with-border">
                    <button type="submit" class="btn btn-flat btn-primary pull-right">
                        <i class="fa fa-check-circle"></i> <span translate>Save script</span>
                    </button>
                </div>
            </form>
        </div>
    </script>

    <script type="text/ng-template" id="/import-database-popup.html">
        <div class="box">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Import current database</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <form class="form-horizontal" ng-submit="ctrl.getDb(data, hide);">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Dump type:</span></label>
                        <div class="col-sm-9">
                            <label class="radio-inline">
                                <input type="radio" ng-model="data.form.with_data" ng-value="true"> <span translate="">Structure + Data</span>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" ng-model="data.form.with_data" ng-value="false"> <span translate="">Structure only</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="rows"><span translate="">Dump rows:</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="number" class="form-control" id="rows" placeholder="Enter Number of rows" ng-model="data.form.rows" ng-required="true" ng-disabled="!data.form.with_data">
                                <div class="input-group-addon">rows per table</div>
                            </div>

                            <p class="help-block"><span translate="">Number of rows to dump from each table, Enter "0" to dump entire database (not recommended)</span></p>
                        </div>
                    </div>

                </div>

                <div class="box-footer with-border">
                    <button type="submit" class="btn btn-flat btn-primary pull-right" ng-disabled="!!data.loading">
                        <i class="fa fa-check-circle"></i> <span translate>Get dump</span>
                    </button>
                </div>
            </form>
        </div>
    </script>
</div>
