
require(['jquery'], function($) {
    $(document).ready(() => {
        class CanvasInstance {
            constructor(container) {
                let $container = $(container);
                let $basePanel = $('#basePanel');
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

                let _this = this;
                $.ajax({
                    'async': false,
                    'global': false,
                    'url': $basePanel.data('sourceFilter'),
                    'dataType': 'json',
                    'success': function (data) {
                        if (data.filters.length) {
                            for (let i=0; i<data.filters.length; i++) {
                                _this.preview.filters.push(new fabric.Image.filters[data.filters[i].name](data.filters[i].options));
                            }
                        }
                    }
                });
                this.preview.applyFilters();
                this.fabric.add(this.preview);

                $.ajax({
                    'async': false,
                    'global': false,
                    'url': $basePanel.data('sourceSkin'),
                    'dataType': 'json',
                    'success': function (data) {
                        if (data.elements.length) {
                            for (let i=0; i<data.elements.length; i++) {
                                let element = data.elements[i];
                                let value = typeof element['value'] !== 'undefined' ? element['value'] : $(element['fieldSelector']).text();
                                let tmp = new fabric[element['type']](
                                    _this.parseVariables(value),
                                    _this.parseVariables(element['options'])
                                );
                                _this.fabric.add(tmp);
                                if (typeof element['export'] !== 'undefined') {
                                    _this[element['export']] = tmp;
                                }
                            }
                        }
                    }
                });

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
                    let name = CanvasInstance.slugify($('#title').text()) + '-' + identifier + '.png';
                    this.saveImage(data, name);
                });
            }

            parseVariables(data) {
                switch (typeof data) {
                    case 'string':
                        if (data.indexOf('{{') !== -1 && data.indexOf('}}') !== -1) {
                            let newString = data
                                .replace('{{canvas.width}}', this.canvas.width)
                                .replace('{{canvas.height}}', this.canvas.height);
                            return eval(newString);
                        }
                        return data;
                        break;
                    case 'object':
                        let newData = {};
                        for (let prop in data) {
                            newData[prop] = this.parseVariables(data[prop]);
                        }
                        return newData;
                        break;
                    case 'boolean':
                    case 'number':
                        return data;
                        break;
                    default:
                        console.log('unknown type: ' + typeof data);
                        break;
                }
            }

            static slugify(text) {
                return text.toString().toLowerCase().trim()
                    .replace(/[^\w\s-]/g, '') // remove non-word [a-z0-9_], non-whitespace, non-hyphen characters
                    .replace(/[\s_-]+/g, '_') // swap any length of whitespace, underscore, hyphen characters with a single _
                    .replace(/^-+|-+$/g, ''); // remove leading, trailing -
            }

            saveImage(imageContent, name) {
                let $basePanel = $('#basePanel');
                $basePanel.slideUp('slow', function() {
                    $('#waitState').show();
                });
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
                            $step1Panel.slideDown();
                            $('#waitState').hide();
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

                $('#waitState').show();
                $step1Panel.slideUp('slow');
                $.post(
                    TYPO3.settings.ajaxUrls['ext-blog-social-wizard-get-relations'],
                    {
                        table: $basePanel.data('table'),
                        uid: $basePanel.data('uid'),
                        field: fieldIdentifier,
                        file: fileUid
                    },
                    function (data) {
                        let $listOfRelations = $('.t3js-list-of-relations tbody');
                        $listOfRelations.empty();
                        if (data.length > 0) {
                            for (let i = 0; i < data.length; i++) {
                                let $tr = $('<tr>');
                                let $td = $('<td>');
                                let $img = $('<img>');
                                let $title = $('<h5>');
                                let $button1 = $('<button class="btn btn-danger t3js-image-replace">replace</button>');

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

                            $('#waitState').hide();
                            $step2Panel.slideDown();
                        } else {
                            $('#waitState').hide();
                            $step3Panel.slideDown();
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
                let $basePanel = $('#basePanel');
                let $step2Panel = $('#savePanelStep2');
                let $step3Panel = $('#savePanelStep3');

                $('#waitState').show();
                $step2Panel.slideUp('slow');
                $.post(
                    TYPO3.settings.ajaxUrls['ext-blog-social-wizard-replace-relation'],
                    {
                        table: $basePanel.data('table'),
                        uid: $basePanel.data('uid'),
                        reference: fileReferenceId,
                        field: fieldIdentifier,
                        file: fileUid
                    },
                    function () {
                        $step3Panel.slideDown();
                        $('#waitState').hide();
                    }
                );
            }

            handleInsertAfterRelation(event) {
                let $row = $(event.target).closest('tr');
                let fileReferenceId = $row.data('fileId');
                let fieldIdentifier = $row.data('fieldIdentifier');
                let fileUid = $row.data('fileUid');
                let $basePanel = $('#basePanel');
                let $step2Panel = $('#savePanelStep2');
                let $step3Panel = $('#savePanelStep3');

                $('#waitState').show();
                $step2Panel.slideUp('slow');
                $.post(
                    TYPO3.settings.ajaxUrls['ext-blog-social-wizard-insert-after-relation'],
                    {
                        table: $basePanel.data('table'),
                        uid: $basePanel.data('uid'),
                        reference: fileReferenceId,
                        field: fieldIdentifier,
                        file: fileUid
                    },
                    function () {
                        $step3Panel.slideDown();
                        $('#waitState').hide();
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
            let instance = new CanvasInstance(container);
            if (index === 0) {
                // This little hack prevents double event registration
                // @fixme: find a better solution, for now it works.
                $(document).on('click', '.js-go-back', () => {
                    $('#savePanelStep1').slideUp();
                    $('#savePanelStep2').slideUp();
                    $('#savePanelStep3').slideUp();
                    $('#basePanel').slideDown();
                });

                let $listOfRelations = $('.t3js-list-of-relations tbody');
                $listOfRelations.empty();
                $listOfRelations.on('click', '.t3js-image-replace', (event) => {
                    instance.handleReplaceRelation(event);
                });
                $listOfRelations.on('click', '.t3js-image-insert-after', (event) => {
                    instance.handleInsertAfterRelation(event);
                });
                let $listOfFields = $('.t3js-list-of-fields', '#savePanelStep1');
                $listOfFields.on('click', '.t3js-save-to-field', (event) => {
                    instance.handleFieldSelection(event);
                });
            }
            return instance;
        });
    });
});
