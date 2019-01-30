/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
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
                                        var str = $('<span>').text(d).text().trim();
                                        if (str !== '') {
                                            values.push(str);
                                        }
                                    }
                                }
                            });
                            values = values.filter(function (value, index, self) {
                                return self.indexOf(value) === index;
                            });
                            $(values).sort().each(function() {
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
