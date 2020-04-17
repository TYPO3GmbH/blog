/**
 * Module: TYPO3/CMS/Blog/SetupWizard
 */
import $ from "jquery";
import Modal from "TYPO3/CMS/Backend/Modal";
import Severity from "TYPO3/CMS/Backend/Severity";

var SetupWizard = {
    triggerSelector: '.t3js-setup-wizard-trigger',
    modalContentSelector: '.t3js-setup-wizard-step1 .step-content'
};

SetupWizard.initialize = function() {
    $(document).on('click', SetupWizard.triggerSelector, function(e) {
        e.preventDefault();
        var $element = $(this);
        var $content = $(SetupWizard.modalContentSelector).clone();
        var buttons = [
            {
                text: $element.data('button-close-text') || 'Close',
                active: true,
                btnClass: 'btn-default',
                trigger: function() {
                    Modal.currentModal.trigger('modal-dismiss');
                }
            },
            {
                text: $element.data('button-ok-text') || 'OK',
                btnClass: 'btn-primary',
                trigger: function(evt) {
                    Modal.currentModal.trigger('modal-dismiss');
                    self.location.href = $element.attr('href')
                        .replace('%40title', Modal.currentModal.find('input[name="title"]').val())
                        .replace('%40template', Modal.currentModal.find('input[name="template"]:checked').length)
                        .replace('%40install', Modal.currentModal.find('input[name="install"]:checked').length);
                }
            }
        ];
        Modal.show('Blog Setup Wizard', $content, Severity.notice, buttons);
    });
};

SetupWizard.initialize();
