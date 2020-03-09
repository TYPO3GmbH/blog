/**
 * Module: TYPO3/CMS/Blog/DataTables
 */
import 'datatables.net-bs/css/dataTables.bootstrap.min.css';

import $ from 'jquery';
import 'datatables.net';
import 'datatables.net-bs';

$('.dataTables').DataTable({
    "columns": function () {
        return $(this).data('columns')
    },
    "pageLength": 25,
    "initComplete": function () {
        this.api().columns().every(function () {
            var column = this;
            if ($(column.header()).data('filter') === true) {
                var select = $('<select><option value="">' + $(column.header()).text() + '</option></select>')
                    .appendTo($(column.header()).empty())
                    .on('click', function (e) {
                        e.stopPropagation();
                    })
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search(val ? val : '', true, false).draw();
                    });

                var values = [];
                column.nodes().each(function (content) {
                    var filter = $(content).data('filter');
                    if (typeof filter !== "undefined") {
                        var entries = filter.split(',');
                        entries.forEach(function (entry) {
                            if (entry.trim() !== '') values.push(entry.trim());
                        });
                    }
                });
                values = values.filter(function (value, index, self) {
                    return self.indexOf(value) === index;
                });
                $(values).sort().each(function () {
                    var value = this;
                    select.append('<option value="' + value + '">' + value + '</option>')
                });
            }
        });
    }
});
