/**
 * Module: TYPO3/CMS/Blog/DataTables
 */
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import '../../Scss/backend/datatables.scss'

import $ from 'jquery';
import DataTable from 'datatables.net-bs5';

const datatables = document.querySelectorAll('.dataTables');
datatables.forEach((datatable) => {

    const columnConfig = JSON.parse(datatable.dataset.columns);
    new DataTable(datatable, {
        dom:
            "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'table-fit'tr>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        pageLength: 25,
        columns: columnConfig,
        initComplete: function () {
            this.api().columns().every(function () {
                const column = this;
                if (column.header().dataset.filter === 'true') {

                    const select = document.createElement('select');
                    select.classList.add('form-select', 'form-select-sm');
                    select.addEventListener('click', (event) => {
                        event.stopPropagation();
                    });
                    select.addEventListener('change', (event) => {
                        const element = event.target;
                        const value = element.value;
                        column.search(value ? value : '', true, false).draw();
                    });

                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.innerText = column.header().innerText;
                    select.appendChild(defaultOption);

                    let values = [];
                    column.nodes().each((content) => {
                        const filter = content.dataset.filter;
                        if (typeof filter !== "undefined") {
                            var entries = filter.split(',');
                            entries.forEach((entry) => {
                                if (entry.trim() !== '') values.push(entry.trim());
                            });
                        }
                    });
                    values = values.filter((value, index, array) => array.indexOf(value) === index);
                    values.sort().forEach((value) => {
                        const option = document.createElement('option');
                        option.value = value;
                        option.innerText = value;
                        select.append(option);
                    });

                    column.header().innerHTML = '';
                    column.header().append(select);

                }
            });
        }
    });
});
