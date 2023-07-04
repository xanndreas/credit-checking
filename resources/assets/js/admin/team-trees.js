$(async function () {
    'use strict';

    let teamData, teamTable = $('.datatable-TeamTree');
    if (teamTable.length > 0) teamData = $.get(window.location.href, function (data, status) {
        return status ? data : null;
    });

    teamTable.treeTable({
        "data": await teamData,
        "columns": [
            {"data": "name"},
            {"data": "email"},
            {"data": "email_verified_at"},
            {"data": "status"},
            {"data": "roles"},
        ]
    });
})
