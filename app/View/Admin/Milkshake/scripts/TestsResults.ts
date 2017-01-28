/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class ResultListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.test = $scope.tests[0];
        }

        actions = (item) => {
            let gettext = this.gettext;
            let actions = [
                {'text': gettext('View details..'), 'icon': 'fa-search', 'hint': gettext('View details'), 'click': 'ctrl.view(item)'},
                {'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this result'), 'click': 'item.removeConfirm("Removed")'},
            ];

            this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, this.$scope, {item: item, ctrl: this});
        };

        view = (result) => {
            this.$ui.popupUrl('/result-popup.html', false, null, {ctrl: this, result: result});
        };
    }

    angular.module('resultListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('resultListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ResultListController]);
}
