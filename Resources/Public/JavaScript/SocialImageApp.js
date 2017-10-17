
$(document).ready(() => {
    class CanvasInstance {
        constructor(container) {
            let $container = $(container);
            let identifier = $container.data('identifier');
            let canvas = $container.find('canvas').get(0);
            this.canvas = canvas;
            this.fabric = new fabric.Canvas(canvas, {
                preserveObjectStacking: true
            });
            this.preview = new fabric.Image(document.getElementById('posterImage'), {
                top: 0,
                left: 0,
                scaleX: 0.5,
                scaleY: 0.5,
                crossOrigin: 'use-credentials'
            });
            // @TODO: Move this code into skin files
            this.preview.filters.push(new fabric.Image.filters.Sepia());
            this.preview.filters.push(new fabric.Image.filters.Contrast({contrast: -0.6}));
            this.preview.filters.push(new fabric.Image.filters.Brightness({brightness: -0.2}));
            // ^^^^^^^^^ @TODO: Move this code into skin files

            this.preview.applyFilters();
            this.fabric.add(this.preview);

            // @TODO: Move this code into theme files
            // Add Author
            this.fabric.add(this._addAuthorText());
            // Add TagLine
            this.fabric.add(this._addTYPO3TagLine());
            this.fabric.add(this._addLine());
            // Add TextBox
            this.text = this._addTextBox();
            this.fabric.add(this.text);
            //  ^^^^^^^^^ @TODO: Move this code into theme files

            $('.watch').on('input', (event) => {
                let value = $(event.target).val();
                this.updateText(value);
            });

            $('.t3js-font-size', $container).on('input', (event) => {
                let fontSize = $(event.target).val();
                this.setFontSize(fontSize);
                this.render();
            });

            $('.t3js-image-scale', $container).on('input', (event) => {
                let scale = $(event.target).val();
                this.scaleImage(scale);
                this.render();
            });

            $('.js-download-link', $container).on('click', (event) => {
                let $link = $(event.target);
                $link.attr('href', this.fabric.toDataURL({
                    format: 'png'
                }));
                $link.attr('download', 'image-' + identifier + '.png');
            });

            $('.js-save-link', $container).on('click', () => {
                let data = this.fabric.toDataURL({
                    format: 'png'
                });
                let name = this.slugify($('#title').text()) + '-' + identifier + '.png';
                this.saveImage(data, name);
            });

            $(document).on('click', '.js-go-back', (event) => {
                $('#savePanelStep1').slideUp();
                $('#savePanelStep2').slideUp();
                $('#savePanelStep3').slideUp();
                $('#basePanel').slideDown();
            });

        }

        _addAuthorText() {
            return new fabric.Text(
                $('#author').html(),
                {
                    left: 30,
                    top: (this.canvas.height) - 51,
                    fontSize: 15,
                    fontFamily: 'Source Sans Pro',
                    fontWeight: '600',
                    fill: 'white'
                }
            );
        }

        _addTYPO3TagLine() {
            return new fabric.Text(
                'TYPO3',
                {
                    left: 30,
                    top: (this.canvas.height) - 25,
                    fontSize: 15,
                    fontFamily: 'Source Sans Pro',
                    fontWeight: '600',
                    fill: '#FF8700'
                }
            );
        }

        _addLine() {
            return new fabric.Line(
                [
                    30, // X1
                    30,// Y1
                    this.canvas.width - 30, // X2
                    30 // Y2
                ],
                {
                    left: 30,
                    top: this.canvas.height - 30,
                    stroke: '#FF8700'
                }
            );
        }

        _addTextBox() {
            return new fabric.Textbox(
                $('#title').html(),
                {
                    left: 30,
                    top: 30,
                    fontSize: 40,
                    fontFamily: 'Source Sans Pro',
                    fontWeight: '300',
                    textAlign: 'left',
                    fill: 'white',
                    fixedWidth: (this.canvas.width) - 40,
                    width: (this.canvas.width) - 40,
                    // strokeWidth: 1,
                    // stroke: 'black',
                    lockMovementX: true,
                    lockMovementY: true,
                    selectable: false
                }
            );
        }

        slugify(text) {
            return text.toString().toLowerCase().trim()
                .replace(/[^\w\s-]/g, '') // remove non-word [a-z0-9_], non-whitespace, non-hyphen characters
                .replace(/[\s_-]+/g, '_') // swap any length of whitespace, underscore, hyphen characters with a single _
                .replace(/^-+|-+$/g, ''); // remove leading, trailing -
        }

        showWaitState() {
            $('#waitState').show();
        }

        hideWaitState() {
            $('#waitState').hide();
        }

        saveImage(imageContent, name) {
            let $basePanel = $('#basePanel');
            let _this = this;
            this.showWaitState();
            $basePanel.slideUp('slow');
            $.post(
                TYPO3.settings.ajaxUrls['ext-blog-social-wizard-save-image'],
                {
                    name: name,
                    data: imageContent,
                    table: $basePanel.data('table'),
                    uid: $basePanel.data('uid')
                },
                function (data) {
                    if (data.status === 'ok') {
                        let $step1Panel = $('#savePanelStep1');
                        $step1Panel.find('.t3js-file-link').attr('href', '/' + data.file);
                        $step1Panel.find('.t3js-filepath').text(data.file);
                        let $listOfFields = $step1Panel.find('.t3js-list-of-fields');
                        $listOfFields.empty();
                        if (data.fields && data.fields.length) {
                            for (let i = 0; i < data.fields.length; i++) {
                                let $anchor = $('<a href="#" class="t3js-save-to-field">');
                                $anchor.data('file', data.file);
                                $anchor.data('fileUid', data.fileUid);
                                $anchor.data('field', data.fields[i].identifier);
                                $anchor.text(data.fields[i].label);
                                let $li = $('<li>');
                                $li.append($anchor);
                                $listOfFields.append($li);
                            }
                        } else {
                            $listOfFields.append('<li>Sorry, no image fields found in this record.</li>');
                        }
                        $listOfFields.on('click', '.t3js-save-to-field', (event) => {
                            _this.handleFieldSelection(event);
                        });

                        $step1Panel.slideDown();
                        _this.hideWaitState();
                    }
                },
                'json'
            )
        }

        handleFieldSelection(event) {
            let $link = $(event.target);
            let fieldIdentifier = $link.data('field');
            let fileIdentifier = $link.data('file');
            let fileUid = $link.data('fileUid');
            let $basePanel = $('#basePanel');
            let $step1Panel = $('#savePanelStep1');
            let $step2Panel = $('#savePanelStep2');
            let $step3Panel = $('#savePanelStep3');
            this.showWaitState();
            $step1Panel.slideUp('slow');
            let _this = this;
            $.post(
                TYPO3.settings.ajaxUrls['ext-blog-social-wizard-get-relations'],
                {
                    table: $basePanel.data('table'),
                    uid: $basePanel.data('uid'),
                    field: fieldIdentifier
                },
                function (data) {
                    if (data.length > 0) {
                        let $listOfRelations = $('.t3js-list-of-relations tbody');
                        $listOfRelations.empty();


                        for (let i = 0; i < data.length; i++) {
                            let $tr = $('<tr>');
                            let $td = $('<td>');
                            let $img = $('<img>');
                            let $title = $('<h5>');
                            let $button1 = $('<button class="btn btn-danger t3js-image-replace">replace</button>');
//                            let $button2 = $('<button class="btn btn-default t3js-image-insert-after">insert after</button>');
//                            let $button3 = $('<button class="btn btn-default t3js-image-insert-before">insert before</button>');

                            $tr.data('fileId', data[i]['referenceId']);
                            $tr.data('fieldIdentifier', fieldIdentifier);
                            $tr.data('fileIdentifier', fileIdentifier);
                            $tr.data('fileUid', fileUid);
                            $img.attr('src', data[i]['thumb']).attr('width', 100);
                            $title.text(data[i]['title']);

                            let $div = $('<div>');
                            $div.append($title);
                            let $buttonContainer = $('<div class="btn-group">');
                            $buttonContainer.append($button1);
//                            $buttonContainer.append($button2);
//                            $buttonContainer.append($button3);
                            $div.append($buttonContainer);

                            $tr.append($td.clone().append($img));
                            $tr.append($td.clone().append($div));
                            $listOfRelations.append($tr);
                        }
                        let $tr = $('<tr>');
                        $tr.data('fieldIdentifier', fieldIdentifier);
                        $tr.data('fileIdentifier', fileIdentifier);
                        $tr.data('fileUid', fileUid);
                        $tr.append($('<td colspan="2">').append('<button class="btn btn-default t3js-image-insert-after">append</button>'));
                        $listOfRelations.append($tr);

                        $listOfRelations.on('click', '.t3js-image-replace', (event) => {
                            _this.handleReplaceRelation(event);
                        });
                        $listOfRelations.on('click', '.t3js-image-insert-after', (event) => {
                            _this.handleInsertAfterRelation(event);
                        });
                        // $listOfRelations.on('click', '.t3js-image-insert-before', (event) => {
                        //     _this.handleInsertBeforeRelation(event);
                        // });

                        $step2Panel.slideDown();
                        _this.hideWaitState();
                    } else {
                        $step3Panel.slideDown();
                        _this.hideWaitState();
                    }
                },
                'json'
            );
        }

        handleReplaceRelation(event) {
            let $row = $(event.target).closest('tr');
            let fileReferenceId = $row.data('fileId');
            let fieldIdentifier = $row.data('fieldIdentifier');
            let fileUid = $row.data('fileUid');
            this.showWaitState();
            let $basePanel = $('#basePanel');
            let $step2Panel = $('#savePanelStep2');
            let $step3Panel = $('#savePanelStep3');

            $step2Panel.slideUp('slow');
            let _this = this;
            $.post(
                TYPO3.settings.ajaxUrls['ext-blog-social-wizard-replace-relation'],
                {
                    table: $basePanel.data('table'),
                    uid: $basePanel.data('uid'),
                    reference: fileReferenceId,
                    field: fieldIdentifier,
                    file: fileUid
                },
                function (data) {
                    $step3Panel.slideDown();
                    _this.hideWaitState();
                }
            );
        }

        handleInsertAfterRelation(event) {
            let $row = $(event.target).closest('tr');
            let fileReferenceId = $row.data('fileId');
            let fieldIdentifier = $row.data('fieldIdentifier');
            let fileUid = $row.data('fileUid');
            this.showWaitState();
            let $basePanel = $('#basePanel');
            let $step2Panel = $('#savePanelStep2');
            let $step3Panel = $('#savePanelStep3');

            $step2Panel.slideUp('slow');
            let _this = this;
            $.post(
                TYPO3.settings.ajaxUrls['ext-blog-social-wizard-insert-after-relation'],
                {
                    table: $basePanel.data('table'),
                    uid: $basePanel.data('uid'),
                    reference: fileReferenceId,
                    field: fieldIdentifier,
                    file: fileUid
                },
                function (data) {
                    $step3Panel.slideDown();
                    _this.hideWaitState();
                }
            );
        }

        setFontSize(fontSize) {
            this.text.set({
                fontSize: fontSize
            });
        }

        scaleImage(scaleFactor) {
            this.preview.set({
                scaleY: scaleFactor,
                scaleX: scaleFactor
            });
        }

        updateText(value) {
            this.text.setText(value);
            this.render();
        }

        render() {
            this.fabric.renderAll();
        }

        download() {
            this.canvas.toDataURL('png');
        }
    }

    $('.t3js-canvas-container').map((index, container) => {
        return new CanvasInstance(container);
    });
});
