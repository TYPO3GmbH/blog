/**
 * Module: TYPO3/CMS/Blog/MassUpdate
 */
const MassUpdate = {
    checkboxSelector: '.t3js-blog-massupdate-checkbox',
    actionButton: '.t3js-blog-massupdate-action'
};

MassUpdate.initialize = function () {
    const checkboxes = document.querySelectorAll(MassUpdate.checkboxSelector);
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', MassUpdate.updateButton);
    });
};

MassUpdate.updateButton = function() {
    const checkboxes = document.querySelectorAll(MassUpdate.checkboxSelector);
    const buttons = document.querySelectorAll(MassUpdate.actionButton);

    let active = false;
    checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            active = true;
        }
    });
    buttons.forEach((button) => {
        button.disabled = !active;
    });
};

MassUpdate.initialize();
