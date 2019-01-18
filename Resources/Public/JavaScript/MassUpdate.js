/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
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
