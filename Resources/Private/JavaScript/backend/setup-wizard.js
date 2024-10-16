/**
 * Module: TYPO3/CMS/Blog/SetupWizard
 */
import Modal from "@typo3/backend/modal";
import Severity from "@typo3/backend/severity";

const SetupWizard = {
    triggerSelector: '.t3js-setup-wizard-trigger',
    modalContentSelector: '.t3js-setup-wizard-step1 .step-content'
};

SetupWizard.initialize = function() {
    const triggerSelector = document.querySelector(SetupWizard.triggerSelector);
    triggerSelector.addEventListener('click', (event) => {
        event.preventDefault();
        const element = event.target;
        var content = document.querySelector(SetupWizard.modalContentSelector).cloneNode(true);
        var buttons = [
            {
                text: element.dataset.buttonCloseText || 'Close',
                active: true,
                btnClass: 'btn-default',
                trigger: (event, modal) => {
                    if (modal !== undefined) {
                        modal.hideModal();
                    } else {
                        Modal.currentModal.trigger('modal-dismiss');
                    }
                }
            },
            {
                text: element.dataset.buttonOkText || 'OK',
                btnClass: 'btn-primary',
                trigger: (event, modal) => {
                    if (modal !== undefined) {
                        self.location.href = element.getAttribute('href')
                            .replace('@title', modal.querySelector('input[name="title"]').value)
                            .replace('@template', modal.querySelectorAll('input[name="template"]:checked').length)
                            .replace('@install', modal.querySelectorAll('input[name="install"]:checked').length)
                        modal.hideModal();
                    } else {
                        self.location.href = element.getAttribute('href')
                            .replace('%40title', Modal.currentModal.find('input[name="title"]').val())
                            .replace('%40template', Modal.currentModal.find('input[name="template"]:checked').length)
                            .replace('%40install', Modal.currentModal.find('input[name="install"]:checked').length);
                        Modal.currentModal.trigger('modal-dismiss');
                    }
                }
            }
        ];
        Modal.show('Blog Setup Wizard', content, Severity.notice, buttons);
    });
};

SetupWizard.initialize();
