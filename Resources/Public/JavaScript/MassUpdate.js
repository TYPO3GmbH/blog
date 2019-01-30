/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/**
 * Module: TYPO3/CMS/Blog/MassUpdate
 */
define(['jquery'], function ($) {
    'use strict';

    var MassUpdate = {
        checkboxTriggerSelector: '.t3js-check-multiple-selection',
        checkboxSelector: '.t3js-check-multiple-selection input[type="checkbox"]',
        actionButton: '.t3js-check-multiple-action'
    };

    MassUpdate.initialize = function () {
       $(function () {
           $(document).on('click', MassUpdate.checkboxTriggerSelector, function() {
               MassUpdate.updateButton();
           });
       });
    };

    MassUpdate.updateButton = function() {
        var active = false;
        $(MassUpdate.checkboxSelector).each(function() {
            if ($(this).prop('checked')) {
                active = true;
            }
        });
        $(MassUpdate.actionButton).prop('disabled', !active);
    };

    MassUpdate.initialize();
    return MassUpdate;
});
