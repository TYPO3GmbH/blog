// (($) => {
	$(document).ready(() => {
		class CanvasInstance {
			constructor(canvas, mainCanvasWidth, mainCanvasHeight) {
				this.canvas = canvas;
				this.fabric = new fabric.Canvas(canvas, {
					preserveObjectStacking: true
				});
				let zoomFactor = (canvas.offsetWidth) / mainCanvasWidth;
				this.fabric.setZoom(zoomFactor);

				// Add Youtube Cover Image
				this.preview = new fabric.Image(document.getElementById('posterImage'), {
					top: 0,
					left: 0,
					scaleX: 0.5,
					scaleY: 0.5,
					crossOrigin: 'use-credentials'
				});
				this.preview.filters.push(new fabric.Image.filters.Sepia());
				this.preview.filters.push(new fabric.Image.filters.Contrast({contrast: -0.6}));
				this.preview.filters.push(new fabric.Image.filters.Brightness({brightness: -0.2}));
				this.preview.applyFilters();
				this.fabric.add(this.preview);

				// Add Author
				this.fabric.add(CanvasInstance._addAuthorText());
				// Add TagLine
				this.fabric.add(CanvasInstance._addTYPO3TagLine());
				this.fabric.add(CanvasInstance._addLine());
				// Add TextBox
				this.text = CanvasInstance._addTextBox(mainCanvasWidth);
				this.fabric.add(this.text);

				this.fabric.on({
					'object:modified': updatePreviewImagePosition
				});
			}

			static _addAuthorText() {
				let authorText = new fabric.Text(
					$('#author').html(),
					{
						left: 30,
						top: 120,
						fontSize: 20,
						fontFamily: 'Source Sans Pro',
						fill: 'white'
					}
				);
				return authorText;
			}

			static _addTYPO3TagLine() {
				let tagLine = new fabric.Text(
					'TYPO3',
					{
						left: 30,
						top: 200,
						fontSize: 20,
						fontFamily: 'Source Sans Pro',
						fill: '#FF8700'
					}
				);
				return tagLine;
			}

			static _addLine() {
				let line = new fabric.Line(
					[
						500, 100, 100, 100
					],
					{
						left: 30,
						top: 200,
						stroke: '#FF8700'
					}
				);
				return line;
			}

			static _addTextBox(mainCanvasWidth) {
				let textBox = new fabric.Textbox(
					$('#title').html(),
					{
						left: 30,
						top: 30,
						fontSize: 40,
						fontFamily: 'Source Sans Pro',
						fontWeight: '300',
						textAlign: 'left',
						fill: 'white',
						fixedWidth: Math.floor(mainCanvasWidth / 1.5),
						width: Math.floor(mainCanvasWidth / 1.5),
						// strokeWidth: 1,
						// stroke: 'black',
						lockMovementX: true,
						lockMovementY: true,
						selectable: false
					}
				);
				return textBox;
			}

			updateText(value) {
				this.text.setText(value);
				this.render();
			}

			showOverlay(overlay) {
				console.log(overlay);
			}

			adjustPreviewImagePosition(previewImage) {
				this.preview.set({
					top: previewImage.top,
					left: previewImage.left,
					scaleY: previewImage.scaleY,
					scaleX: previewImage.scaleX
				});
				this.render();
			}

			render() {
				this.fabric.renderAll();
			}

			download() {
				this.canvas.toDataURL('png');
			}
		}

		let mainCanvasWidth = parseInt(document.getElementById('preview-facebook').getAttribute('width'));
		let mainCanvasHeight = parseInt(document.getElementById('preview-facebook').getAttribute('height'));

		let $instances = $('canvas').map((index, canvas) => {
			return new CanvasInstance(canvas, mainCanvasWidth, mainCanvasHeight);
		});

		function updatePreviewImagePosition(movedObject) {
			$instances.each((index, instance) => {
				instance.adjustPreviewImagePosition(movedObject.target);
			});
		}

		let $input = $('.watch');
		$input.on('input', () => {
			let value = $input.val();
			$instances.each((index, instance) => {
				instance.updateText(value);
			});
		});

		let $overlayRadio = $('.overlay-watch');
		$overlayRadio.on('change', () => {
			let value = $('.overlay-watch:checked').val();
			$instances.each((index, instance) => {
				instance.showOverlay(value);
			});
		});

		let $downloadLinkFacebook = $('.js-download-link-facebook');
        $downloadLinkFacebook.on('click', () => {
			$instances.each((index, instance) => {
				if ($(instance.canvas).attr('id') === 'preview-facebook') {
                    $downloadLinkFacebook.attr('href', instance.fabric.toDataURL({
						format: 'png'
					}));
                    $downloadLinkFacebook.attr('download', 'image-facebook.png');
				}
			});
		});

		let $downloadLinkLinkedIn = $('.js-download-link-linkedin');
        $downloadLinkLinkedIn.on('click', () => {
			$instances.each((index, instance) => {
				if ($(instance.canvas).attr('id') === 'preview-linkedin') {
                    $downloadLinkLinkedIn.attr('href', instance.fabric.toDataURL({
						format: 'png'
					}));
                    $downloadLinkLinkedIn.attr('download', 'image-linkedin.png');
				}
			});
		});

        $(document).on('click', '.t3js-save-to-field', function() {
            let $link = $(this);
            alert('connect image ' + $link.data('file') + ' to: ' + $link.data('id'));
        });

        function slugify(text) {
            return text.toString().toLowerCase().trim()
                .replace(/[^\w\s-]/g, '') // remove non-word [a-z0-9_], non-whitespace, non-hyphen characters
                .replace(/[\s_-]+/g, '_') // swap any length of whitespace, underscore, hyphen characters with a single _
                .replace(/^-+|-+$/g, ''); // remove leading, trailing -
        }

        function saveImage(imageContent, name) {
            $.post(
                TYPO3.settings.ajaxUrls['ext-blog-social-wizard-save-image'],
                {
                    name: name,
                    data: imageContent
                },
                function(data) {
                    if (data.status === 'ok') {
                        let $step1Panel = $('#savePanelStep1');
                        $('#basePanel').slideUp('slow', function() {
                            $step1Panel.find('.t3js-file-link').attr('href', '/' + data.file);
                            $step1Panel.find('.t3js-filepath').text(data.file);
                            let $listOfFields = $step1Panel.find('.t3js-list-of-fields');
                            if (data.fields && data.fields.length) {
                                for (let i=0; i<data.fields.length; i++) {
                                    $listOfFields.append('<li><a href="#" class="t3js-save-to-field" data-file="' + data.file + '" data-id="' + data.fields[i].identifier + '">' + data.fields[i].label + '</a></li>');
                                }
                            } else {
                                $listOfFields.append('<li>Sorry, no image fields found in this record.</li>');
                            }
                            $step1Panel.slideDown();
                        });
                    }
                },
                'json'
            )
        }

        let $saveLinkFacebook = $('.js-save-link-facebook');
        $saveLinkFacebook.on('click', () => {
            $instances.each((index, instance) => {
                if ($(instance.canvas).attr('id') === 'preview-facebook') {
                    let data = instance.fabric.toDataURL({
                        format: 'png'
                    });
                    let name = slugify($('#title').text()) + '-facebook.png';
                    saveImage(data, name);
                }
            });
        });

        let $saveLinkLinkedIn = $('.js-save-link-linkedin');
        $saveLinkLinkedIn.on('click', () => {
            $instances.each((index, instance) => {
                if ($(instance.canvas).attr('id') === 'preview-linkedin') {
                    let data = instance.fabric.toDataURL({
                        format: 'png'
                    });
                    let name = slugify($('#title').text()) + '-linkedin.png';
                    saveImage(data, name);
                }
            });
        });
	});
// })(jQuery);
