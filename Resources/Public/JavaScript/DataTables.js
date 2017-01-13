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
 * Module: TYPO3/CMS/Blog/DataTables
 */
define(['jquery', 'datatables', 'datatables_bootstrap'], function ($) {
    'use strict';

    var DataTables = {
       listSelector: '.dataTables'
    };

    DataTables.initialize = function () {
       $(function () {
            $(DataTables.listSelector).DataTable({
                "columns": function() {
                    return $(this).data('columns')
                },
                "pageLength": 10,
                "initComplete": function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if ($(column.header()).data('filter') === true) {
                            var select = $('<select><option value="">' + $(column.header()).text() + '</option></select>')
                                .appendTo( $(column.header()).empty() )
                                .on('click', function(e) {
                                    e.stopPropagation();
                                })
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    column
                                        .search( val ? val : '', true, false )
                                        .draw();
                                } );
                            var values = [];
                            column.data().each(function(d, j) {
                                var $object = $(d);
                                if ($object.find('li').length > 0) {
                                    $object.find('li').each(function() {
                                        var str = $(this).text().trim();
                                        if (str !== '') {
                                            values.push(str);
                                        }
                                    });
                                } else {
                                    if (d !== '') {
                                        values.push(d);
                                    }
                                }
                            });
                            $($.unique(values).sort()).each(function() {
                                var value = this;
                                select.append( '<option value="'+value+'">'+value+'</option>' )
                            } );
                        }
                    } );
                }
            });
        });
    };

    DataTables.initialize();
    return DataTables;
});
