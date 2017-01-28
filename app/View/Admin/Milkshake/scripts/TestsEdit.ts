/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class TestEditController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService, public $http: ng.IHttpService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.test = $scope.tests[0] || $scope.tests.create().attr('test_db', false).attr('enabled', true);

            $scope.$watch('test.test_db', (val) => {
                if (val && !$scope.test.sql_dump) {
                    this.editDump();
                }
            });
        }

        editDump = () => {
            this.$ui.popupUrl('/clone-db-popup.html', true, null, {ctrl: this, test: this.$scope.test}).then(() => {
                if (!this.$scope.test.sql_dump) {
                    this.$scope.test.attr('test_db', false);
                }
            });
        };

        importDump = () => {
            this.$ui.popupUrl('/import-database-popup.html', false, null, {ctrl: this, data: {loading: false, form: {with_data: true, rows: 10}}});
        };

        run = (test_id) => {
            this.$scope.test.save().then(() => top.location.href = '/admin/milkshake/dry-run/' + test_id);
        };

        getDb = (data, hide) => {
            data.loading = true;

            this.$http.post('/admin/milkshake/dump', data.form)
                .then((obj) => {
                    this.$scope.test.attr('sql_dump', obj.data);
                    hide();
                })
                .then(() => data.loading = false);
        };

        editScripts = () => {
            this.$ui.popupUrl('/scripts-popup.html', false, null, {ctrl: this, test: this.$scope.test});
        };

        save = () => {
            if (this.$scope.test.attr('casper_script')) {
                this.$scope.test.save(this.gettext('Test saved successfully'));
            } else {
                this.$ui.alert(this.gettext('CasperJS script is missing! Please click the CasperJS script button to add it.'));
            }
        };
    }

    angular.module('testEditApp', ['MinuteFramework', 'AdminApp', 'gettext', 'ng.jsoneditor'])
        .controller('testEditController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', TestEditController]);
}
