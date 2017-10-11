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

		let $downloadLink = $('.js-download-link');
		$downloadLink.on('click', () => {
			$instances.each((index, instance) => {
				if ($(instance.canvas).attr('id') === 'preview-facebook') {
					$downloadLink.attr('href', instance.fabric.toDataURL({
						format: 'png'
					}));
					$downloadLink.attr('download', 'image.png');
				}
			});
		});
	});
// })(jQuery);