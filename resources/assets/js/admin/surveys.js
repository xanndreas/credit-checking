'use strict';

// Datatable (jquery)
$(function () {

    let dtOverrideGlobals = {
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],

        ajax: "/admin/surveys",
        columns: [
            {data: 'placeholder', name: 'placeholder'},
            {data: 'id', name: 'id'},
            {data: 'domicile_address', name: 'domicile_address'},
            {data: 'office_address', name: 'office_address'},
            {data: 'requester_name', name: 'requester_name', orderable: false, searchable: false},
            {data: 'office_surveyors', name: 'office_surveyors.name', orderable: false, searchable: false},
            {data: 'domicile_surveyors', name: 'domicile_surveyors.name', orderable: false, searchable: false},
            {data: 'guarantor_surveyors', name: 'guarantor_surveyors.name', orderable: false, searchable: false},
            {data: 'report_actions', name: 'reportsActions', orderable: false, searchable: false},
            {data: 'actions', name: 'Actions', orderable: false, searchable: false}
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
                        return 'Details';
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
            {
                text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add New Survey</span>',
                className: 'add-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'offcanvas',
                    'data-bs-target': '#offcanvasAddSurvey'
                }
            }
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
    let table = $('.datatable-Survey').DataTable(dtOverrideGlobals);

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

    $('.datatable-Survey tbody').on('click', 'td:not(:first-child, :nth-child(9n), :last-child)', (event) => {
        let row = table.row(event.currentTarget).data();

        $('#submitAddSurvey').attr('data-id', row.id);
        $('input[name="requester_id"]').val(row.requester_id);
        $('textarea[name="office_address"]').text(row.office_address);
        $('textarea[name="guarantor_address"]').text(row.guarantor_address);
        $('textarea[name="domicile_address"]').text(row.domicile_address);

        $('select[name="office_surveyors[]"]').val(row.office_surveyor_ids).trigger('change');
        $('select[name="domicile_surveyors[]"]').val(row.domicile_surveyor_ids).trigger('change');
        $('select[name="guarantor_surveyors[]"]').val(row.guarantor_surveyor_ids).trigger('change');
        $('select[name="approval_id"]').val(row.approval_id).trigger('change');

        let canvasSelector = document.getElementById('offcanvasAddSurvey')
        canvasSelector.addEventListener('hidden.bs.offcanvas', function () {
            $('#addNewSurveyForm').trigger("reset");

            $('select[name="office_surveyors[]"]').val('').trigger('change')
            $('select[name="domicile_surveyors[]"]').val('').trigger('change')
            $('select[name="guarantor_surveyors[]"]').val('').trigger('change')
            $('select[name="approval_id"]').val('').trigger('change')
            $('#submitAddSurvey').attr('data-id', null);
        });

        let bsOffCanvasAddSurvey = new bootstrap.Offcanvas(canvasSelector)
        bsOffCanvasAddSurvey.show();
    });

    $('#submitAddSurvey').on('click', function () {
        let savedIds = $(this).attr('data-id'),
            savesForm = $(this).parent(),
            hiddenPut = $('input[name="_method"]');

        if (savedIds === '' || typeof savedIds === 'undefined') {
            hiddenPut.prop('disabled', true);
            savesForm.attr('action', "/admin/surveys").submit();
        } else {
            hiddenPut.prop('disabled', false);
            savesForm.attr('action', "/admin/surveys/" + savedIds).submit();
        }
    });
});
