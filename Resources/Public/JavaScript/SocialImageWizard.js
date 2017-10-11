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
 * Module: TYPO3/CMS/Blog/SetupWizard
 */
define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity'], function($, Modal, Severity) {
	'use strict';

	var SocialImageWizard = {
		triggerSelector: '.t3js-blog-social-image-wizard'
	};

	SocialImageWizard.initialize = function() {
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
	};

	SocialImageWizard.initialize();
	return SocialImageWizard;
});
