/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var TestEditController = (function () {
        function TestEditController($scope, $minute, $ui, $timeout, $http, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.$http = $http;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.editDump = function () {
                _this.$ui.popupUrl('/clone-db-popup.html', true, null, { ctrl: _this, test: _this.$scope.test }).then(function () {
                    if (!_this.$scope.test.sql_dump) {
                        _this.$scope.test.attr('test_db', false);
                    }
                });
            };
            this.importDump = function () {
                _this.$ui.popupUrl('/import-database-popup.html', false, null, { ctrl: _this, data: { loading: false, form: { with_data: true, rows: 10 } } });
            };
            this.run = function (test_id) {
                _this.$scope.test.save().then(function () { return top.location.href = '/admin/milkshake/dry-run/' + test_id; });
            };
            this.getDb = function (data, hide) {
                data.loading = true;
                _this.$http.post('/admin/milkshake/dump', data.form)
                    .then(function (obj) {
                    _this.$scope.test.attr('sql_dump', obj.data);
                    hide();
                })
                    .then(function () { return data.loading = false; });
            };
            this.editScripts = function () {
                _this.$ui.popupUrl('/scripts-popup.html', false, null, { ctrl: _this, test: _this.$scope.test });
            };
            this.save = function () {
                if (_this.$scope.test.attr('casper_script')) {
                    _this.$scope.test.save(_this.gettext('Test saved successfully'));
                }
                else {
                    _this.$ui.alert(_this.gettext('CasperJS script is missing! Please click the CasperJS script button to add it.'));
                }
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.test = $scope.tests[0] || $scope.tests.create().attr('test_db', false).attr('enabled', true);
            $scope.$watch('test.test_db', function (val) {
                if (val && !$scope.test.sql_dump) {
                    _this.editDump();
                }
            });
        }
        return TestEditController;
    }());
    App.TestEditController = TestEditController;
    angular.module('testEditApp', ['MinuteFramework', 'AdminApp', 'gettext', 'ng.jsoneditor'])
        .controller('testEditController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', TestEditController]);
})(App || (App = {}));
