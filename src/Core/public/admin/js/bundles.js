$(document).ready(function () {
    var ZentlixAdminBundlesInstance = new ZentlixAdminBundles();
    ZentlixAdminBundlesInstance.bindEvents();
});

ZentlixAdminBundles = function () {
    var self = this;

    self.bindEvents = function () {
        $('.require-bundle-btn').on('click', function () {
            self.requireBundle($(this).attr('data-package'));
        });

        $('body').on('click', '.delete-bundle-btn', function () {
            $('.delete-bundle-confirm').attr('data-package', $(this).attr('data-package'));
        });
        $('.delete-bundle-confirm').on('click', function () {
            $('#delete-bundle-confirm').modal('hide');
            $('#delete-bundle-process').modal('show');

            self.removeBundle($(this).attr('data-package'));
        });

        $('.bundle-modal-close').on('click', function () {
            document.location.reload();
        });
    };

    self.requireBundle = function (package) {
        $.post('/backend/settings/bundles/composer/require', {package: package}, function (result) {
            if(result['success']) {
                self.completeInstallOrRemoveAction();
                $('.process-migrations').removeClass('d-none');

                $.post('/backend/settings/bundles/migrations', {}, function (result) {
                    if(result['success']) {
                        self.completeMigrationAction();
                        $('.process-app-data').removeClass('d-none');

                        $.post('/backend/settings/bundles/install', {package: package}, function (result) {
                            if(result['success']) {
                                self.completeAppDataAction();
                                $('.process-finished').removeClass('d-none');
                                $('.bundle-modal-close').prop('disabled', false);
                            } else {
                                self.showError(result['message']);
                            }
                        });
                    } else {
                        self.showError(result['message']);
                    }
                });
            } else {
                self.showError(result['message']);
            }
        });
    };

    self.removeBundle = function (package) {
        $.post('/backend/settings/bundles/remove', {package: package}, function (result) {
            if(result['success']) {
                self.completeAppDataAction();
                $('.process-install').removeClass('d-none');

                $.post('/backend/settings/bundles/composer/remove', {package: package}, function (result) {
                    if(result['success']) {
                        self.completeInstallOrRemoveAction();
                        $('.process-migrations').removeClass('d-none');

                        $.post('/backend/settings/bundles/migrations', {}, function (result) {
                            if(result['success']) {
                                self.completeMigrationAction();
                                $('.process-finished').removeClass('d-none');
                                $('.bundle-modal-close').prop('disabled', false);
                            } else {
                                self.showError(result['message']);
                            }
                        });
                    } else {
                        self.showError(result['message']);
                    }
                });
            } else {
                self.showError(result['message']);
            }
        });
    };

    self.completeInstallOrRemoveAction = function () {
        $('.process-install')
            .addClass('list-group-item-success')
            .find('.sk-circle-fade')
            .addClass('d-none');
    };
    self.completeAppDataAction = function () {
        $('.process-app-data')
            .addClass('list-group-item-success')
            .find('.sk-circle-fade')
            .addClass('d-none');
    };
    self.completeMigrationAction = function () {
        $('.process-migrations')
            .addClass('list-group-item-success')
            .find('.sk-circle-fade')
            .addClass('d-none');
    };

    self.showError = function (error) {
        $('.process-finished').removeClass('list-group-item-success').addClass('list-group-item-danger').html(error).removeClass('d-none');
        $('.bundle-modal-close').prop('disabled', false);
        $('.modal-content .sk-circle-fade').each(function (index, element) {
            $(element).addClass('d-none');
        });
    };
};