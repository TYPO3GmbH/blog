/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/**
 * Module: TYPO3/CMS/Blog/SetupWizard
 */
define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity'], function($, Modal, Severity) {
	'use strict';

	var SocialImageWizard = {
		triggerSelector: '.t3js-blog-social-image-wizard'
	};

	SocialImageWizard.initialize = function() {
	    var $button = $(SocialImageWizard.triggerSelector);
	    if ($button.closest('.form-group').find('.form-irre-header').length === 0) {
	        $button.attr('disabled', true).addClass('disable');
        } else {
            $(document).on('click', SocialImageWizard.triggerSelector, function(e) {
                e.preventDefault();
                var $element = $(this);
                var buttons = [
                    {
                        text: $element.data('button-close-text') || 'Close',
                        active: true,
                        btnClass: 'btn-default',
                        trigger: function() {
                            Modal.currentModal.trigger('modal-dismiss');
                        }
                    }
                ];
                Modal.advanced({
                    type: Modal.types.iframe,
                    title: 'Blog Social Image Wizard',
                    content: $element.data('wizardUrl'),
                    severity: Severity.notice,
                    buttons: buttons,
                    size: 'full'
                });
            });
        }
	};

	SocialImageWizard.initialize();
	return SocialImageWizard;
});
