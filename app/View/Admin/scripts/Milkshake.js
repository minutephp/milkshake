/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var TestListController = (function () {
        function TestListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.actions = function (item) {
                var gettext = _this.gettext;
                var actions = [
                    { 'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit test'), 'href': '/admin/milkshake/tests/edit/' + item.test_id },
                    { 'text': gettext('Log..'), 'icon': 'fa-search', 'hint': gettext('Test log'), 'href': '/admin/milkshake/tests/results/' + item.test_id },
                    { 'text': gettext('Run'), 'icon': 'fa-bolt', 'hint': gettext('Dry run'), 'href': '/admin/milkshake/dry-run/' + item.test_id },
                    { 'text': gettext('Clone'), 'icon': 'fa-copy', 'hint': gettext('Clone test'), 'click': 'ctrl.clone(item)' },
                    { 'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this test'), 'click': 'item.removeConfirm("Removed")' },
                ];
                _this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, _this.$scope, { item: item, ctrl: _this });
            };
            this.clone = function (test) {
                var gettext = _this.gettext;
                _this.$ui.prompt(gettext('Enter new name'), gettext('new-name')).then(function (name) {
                    test.clone().attr('name', name).save(gettext('Test duplicated'));
                });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return TestListController;
    }());
    App.TestListController = TestListController;
    angular.module('testListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('testListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', TestListController]);
})(App || (App = {}));
