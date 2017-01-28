/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class TestListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }

        actions = (item) => {
            let gettext = this.gettext;
            let actions = [
                {'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit test'), 'href': '/admin/milkshake/tests/edit/' + item.test_id},
                {'text': gettext('Log..'), 'icon': 'fa-search', 'hint': gettext('Test log'), 'href': '/admin/milkshake/tests/results/' + item.test_id},
                {'text': gettext('Run'), 'icon': 'fa-bolt', 'hint': gettext('Dry run'), 'href': '/admin/milkshake/dry-run/' + item.test_id},
                {'text': gettext('Clone'), 'icon': 'fa-copy', 'hint': gettext('Clone test'), 'click': 'ctrl.clone(item)'},
                {'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this test'), 'click': 'item.removeConfirm("Removed")'},
            ];

            this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, this.$scope, {item: item, ctrl: this});
        };

        clone = (test) => {
            let gettext = this.gettext;
            this.$ui.prompt(gettext('Enter new name'), gettext('new-name')).then(function (name) {
                test.clone().attr('name', name).save(gettext('Test duplicated'));
            });
        };
    }

    angular.module('testListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('testListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', TestListController]);
}
