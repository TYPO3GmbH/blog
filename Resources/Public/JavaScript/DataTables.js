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
                "pageLength": 10
            });
        });
    };

    DataTables.initialize();
    return DataTables;
});
