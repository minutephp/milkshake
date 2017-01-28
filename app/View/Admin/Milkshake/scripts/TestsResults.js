/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var ResultListController = (function () {
        function ResultListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
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
                    { 'text': gettext('View details..'), 'icon': 'fa-search', 'hint': gettext('View details'), 'click': 'ctrl.view(item)' },
                    { 'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this result'), 'click': 'item.removeConfirm("Removed")' },
                ];
                _this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, _this.$scope, { item: item, ctrl: _this });
            };
            this.view = function (result) {
                _this.$ui.popupUrl('/result-popup.html', false, null, { ctrl: _this, result: result });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.test = $scope.tests[0];
        }
        return ResultListController;
    }());
    App.ResultListController = ResultListController;
    angular.module('resultListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('resultListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ResultListController]);
})(App || (App = {}));
