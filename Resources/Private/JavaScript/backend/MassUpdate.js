/**
 * Module: TYPO3/CMS/Blog/MassUpdate
 */
import $ from 'jquery';

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
