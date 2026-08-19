/**
 * Module: TYPO3/CMS/Blog/DataTables
 */
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import '../../Scss/backend/datatables.scss'

import DataTable from 'datatables.net-bs5';

// Keeps the table horizontally scrollable inside the backend module.
DataTable.ext.classes.layout.tableRow += ' table-fit';

const datatables = document.querySelectorAll('.dataTables');
datatables.forEach((datatable) => {

    const columnConfig = JSON.parse(datatable.dataset.columns);
    new DataTable(datatable, {
        pageLength: 25,
        columns: columnConfig,
        initComplete: function () {
            this.api().columns().every(function () {
                const column = this;
                if (column.header().dataset.filter === 'true') {

                    // DataTables wraps the header text, the filter replaces
                    // that wrapper and leaves the order indicator in place.
                    const title = column.header().querySelector('.dt-column-title') ?? column.header();

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
                    defaultOption.innerText = title.innerText;
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

                    title.innerHTML = '';
                    title.append(select);

                }
            });
        }
    });
});
