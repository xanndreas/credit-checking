'use strict';

// Datatable (jquery)
$(function () {

    let dtOverrideGlobals = {
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],

        ajax: "/admin/approvals",
        columns: [
            {data: 'placeholder', name: 'placeholder'},
            {data: 'dealer_name', name: 'dealer.name'},
            {data: 'sales_name', name: 'sales_name'},
            {data: 'product_name', name: 'product.name'},
            {data: 'otr', name: 'otr'},
            {data: 'debtor_information_debtor_name', name: 'debtor_information_debtor_name'},
            {data: 'debtor_phone', name: 'debtor_phone'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'actions', name: 'Actions', orderable: false, searchable: false},
        ],
        orderCellsTop: true,
        order: [[2, 'desc']],
        pageLength: 10,
        dom: '<"row me-2"' +
            '<"col-md-2"<"me-3"l>>' +
            '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
            '>t' +
            '<"row mx-2"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details of ' + data['name'];
                    }
                }),
                type: 'column',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                            ? '<tr data-dt-row="' +
                            col.rowIndex +
                            '" data-dt-column="' +
                            col.columnIndex +
                            '">' +
                            '<td>' +
                            col.title +
                            ':' +
                            '</td> ' +
                            '<td>' +
                            col.data +
                            '</td>' +
                            '</tr>'
                            : '';
                    }).join('');

                    return data ? $('<table class="table"/><tbody />').append(data) : false;
                }
            }
        },
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-label-secondary dropdown-toggle mx-3',
                text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="ti ti-printer me-2" ></i>Print',
                        className: 'dropdown-item',
                        customize: function (win) {
                            //customize print view for dark
                            $(win.document.body)
                                .css('color', headingColor)
                                .css('border-color', borderColor)
                                .css('background-color', bodyBg);
                            $(win.document.body)
                                .find('table')
                                .addClass('compact')
                                .css('color', 'inherit')
                                .css('border-color', 'inherit')
                                .css('background-color', 'inherit');
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="ti ti-file-text me-2" ></i>Csv',
                        className: 'dropdown-item',
                    },
                    {
                        extend: 'excel',
                        text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                        className: 'dropdown-item',
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                        className: 'dropdown-item',
                    },
                    {
                        extend: 'copy',
                        text: '<i class="ti ti-copy me-2" ></i>Copy',
                        className: 'dropdown-item',
                    }
                ]
            },
        ],
        columnDefs: [
            {
                className: 'control',
                searchable: false,
                orderable: false,
                responsivePriority: 2,
                targets: 0,
                render: function (data, type, full, meta) {
                    return '';
                }
            },
        ]

    };
    let table = $('.datatable-Approval').DataTable(dtOverrideGlobals);

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

    $('#roles').on('change', function () {
        let role_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/admin/approvals/tenant-parents',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "role_id": role_id
            },
            success: function (response) {
                let selectElement = $('#tenant_parent_id');

                selectElement.empty().trigger('change');

                let select = response.map(function (value, index) {
                    return {id: value.team.id, text: value.approval.name}
                });

                $.each(select, function(index, option) {
                    selectElement.append($('<option>', {
                        value: option.id,
                        text: option.text
                    }));
                });

                selectElement.trigger('change');
            }
        });
    });

    let tbody  = $('.datatable-Approval tbody');

    tbody.on('click', 'td:eq(7)', (event) => {
        let row = table.row(event.currentTarget).data();

        console.log(row.dealer_information_id)
        $('#dealer_information_id').val(row.dealer_information_id)
    });

    tbody.on('click', 'td:not(:first-child, :eq(7), :last-child)', (event) => {
        let row = table.row(event.currentTarget).data();

        $.ajax({
            type: 'POST',
            url: '/admin/approvals/tenant-parents',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "role_id": row.role_ids[0]
            },
            success: function (response) {
                var selectElement = $('#tenant_parent_id');
                let select = response.map(function (value, index) {
                    return {id: value.team.id, text: value.approval.name}
                });

                $.each(select, function(index, option) {
                    selectElement.append($('<option>', {
                        value: option.id,
                        text: option.text
                    }));
                });

                selectElement.trigger('change');
            }
        });

        $('#submitAddApproval').attr('data-id', row.id);
        $('input[name="name"]').val(row.name);
        $('input[name="email"]').val(row.email);

        if (row.approved.includes('checked'))
            $('input[name="approved"]').prop('checked', true);

        $('select[name="roles[]"]').val(row.role_ids).trigger('change');

        let canvasSelector = document.getElementById('offcanvasAddApproval')
        canvasSelector.addEventListener('hidden.bs.offcanvas', function () {
            $('#addNewApprovalForm').trigger("reset");

            $('select[name="roles[]"]').val('').trigger('change')
            $('#submitAddApproval').attr('data-id', null);
        });

        let bsOffCanvasAddApproval = new bootstrap.Offcanvas(canvasSelector)
        bsOffCanvasAddApproval.show();
    });

    $('#submitAddApproval').on('click', function () {
        let savedIds = $(this).attr('data-id'),
            savesForm = $(this).parent(),
            hiddenPut = $('input[name="_method"]');

        if (savedIds === '' || typeof savedIds === 'undefined') {
            hiddenPut.prop('disabled', true);
            savesForm.attr('action', "/admin/approvals").submit();
        } else {
            hiddenPut.prop('disabled', false);
            savesForm.attr('action', "/admin/approvals/" + savedIds).submit();
        }
    });
});
