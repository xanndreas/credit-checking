'use strict';

$(function () {
    let createdRange = document.querySelector('.created-range');
    let elMinDate = $('.min-date'), elMaxDate = $('.max-date');
    let minDate, maxDate;

    if (typeof createdRange !== undefined) {
        createdRange.flatpickr({
            mode: 'range',
            enableTime: true,
            dateFormat: "Y-m-d H:i",

            onChange: function (dates, dateStr, instance) {
                if (dates.length === 2) {
                    minDate = instance.formatDate(dates[0], "Y-m-d H:i:ss");
                    maxDate = instance.formatDate(dates[1], "Y-m-d H:i:ss");

                    elMaxDate.val(maxDate);
                    elMinDate.val(minDate);

                    table.draw();
                }
            }
        });
    }

    let dtOverrideGlobals = {
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],

        ajax:
            {
                url: "/admin/credit-checks",
                data: function (d) {
                    d.minDate = minDate;
                    d.maxDate = maxDate;

                    console.log(d)
                }
            },
        columns: [
            {data: 'placeholder', name: 'placeholder'},
            {data: 'id', name: 'id'},
            {data: 'dealer_name', name: 'dealer.name'},
            {data: 'dealer_text', name: 'dealer_text', orderable: false, visible: false},
            {data: 'sales_name', name: 'sales_name'},
            {data: 'product_name', name: 'product.name'},
            {data: 'brand_name', name: 'brand.name'},
            {data: 'brand_text', name: 'brand_text', orderable: false, visible: false},
            {data: 'models', name: 'models'},
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
                        return 'Details of #' + data['id'];
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
                text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add Credit Checking</span>',
                className: 'add-new-credit btn btn-primary',
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
    let table = $('.datatable-CreditCheck').DataTable(dtOverrideGlobals);


    $('.datatable-CreditCheck tbody').on('click', 'td:not(:first-child, :last-child)', (event) => {
        let row = table.row(event.currentTarget).data();
        window.location.href = '/admin/credit-checks/' + row.id;
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

    $('.add-new-credit').on('click', function () {
        window.location.href = '/admin/credit-checks/create';
    });

});
