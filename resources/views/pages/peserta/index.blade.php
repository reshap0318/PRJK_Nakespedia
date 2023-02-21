<x-template-layout>
    @slot('title') peserta @endslot

    @slot('css_template')
        <link href="{{ asset('template/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endslot

    @slot('js_template')
        <script src="{{ asset('template/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    @endslot

    <div class="col-md-12">
        <div class="card rounded-3">
            <div class="card-body mt-1">
                <div class="d-flex justify-content-between">
                    <h2 class="fs-20">Participants Data</h2>
                    <h2><span class="me-2" id="data_total">0</span>Participants</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-md-5 mb-xl-10 mt-2">
        <div class="card rounded-3">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                            </svg>
                        </span>
                        <input type="text" id="form-search" class="form-control form-control-solid w-md-500px ps-15" placeholder="Search Participant" />
                        <span class="svg-icon svg-icon-1 position-absolute ms-6" style="right: 10px; cursor: pointer; z-index: 100; opacity: 0.3" id="btn-reset-form-search">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M12 10.6L14.8 7.8C15.2 7.4 15.8 7.4 16.2 7.8C16.6 8.2 16.6 8.80002 16.2 9.20002L13.4 12L12 10.6ZM10.6 12L7.8 14.8C7.4 15.2 7.4 15.8 7.8 16.2C8 16.4 8.3 16.5 8.5 16.5C8.7 16.5 8.99999 16.4 9.19999 16.2L12 13.4L10.6 12Z" fill="currentColor"/>
                                <path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM13.4 12L16.2 9.20001C16.6 8.80001 16.6 8.19999 16.2 7.79999C15.8 7.39999 15.2 7.39999 14.8 7.79999L12 10.6L9.2 7.79999C8.8 7.39999 8.2 7.39999 7.8 7.79999C7.4 8.19999 7.4 8.80001 7.8 9.20001L10.6 12L7.8 14.8C7.4 15.2 7.4 15.8 7.8 16.2C8 16.4 8.3 16.5 8.5 16.5C8.7 16.5 9 16.4 9.2 16.2L12 13.4L14.8 16.2C15 16.4 15.3 16.5 15.5 16.5C15.7 16.5 16 16.4 16.2 16.2C16.6 15.8 16.6 15.2 16.2 14.8L13.4 12Z" fill="currentColor"/>
                            </svg>                                
                        </span>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" id="form-nonselected">
                        @if (Auth::user()->is_admin)
                            <a href="{{ route('peserta.index', ['tag' => 'export']) }}" class="btn btn-light-primary me-3" id="btn-export">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor" />
                                        <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor" />
                                        <path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor" />
                                    </svg>
                                </span>
                                Export
                            </a>
                        @endif
                        @if (Auth::user()->is_user)
                            <a href="{{ route('peserta.import') }}" class="btn btn-light-primary me-3" id="btn-import">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" width="12" height="2" rx="1" transform="matrix(0 -1 -1 0 12.75 19.75)" fill="currentColor"/>
                                        <path d="M12.0573 17.8813L13.5203 16.1256C13.9121 15.6554 14.6232 15.6232 15.056 16.056C15.4457 16.4457 15.4641 17.0716 15.0979 17.4836L12.4974 20.4092C12.0996 20.8567 11.4004 20.8567 11.0026 20.4092L8.40206 17.4836C8.0359 17.0716 8.0543 16.4457 8.44401 16.056C8.87683 15.6232 9.58785 15.6554 9.9797 16.1256L11.4427 17.8813C11.6026 18.0732 11.8974 18.0732 12.0573 17.8813Z" fill="currentColor"/>
                                        <path opacity="0.3" d="M18.75 15.75H17.75C17.1977 15.75 16.75 15.3023 16.75 14.75C16.75 14.1977 17.1977 13.75 17.75 13.75C18.3023 13.75 18.75 13.3023 18.75 12.75V5.75C18.75 5.19771 18.3023 4.75 17.75 4.75L5.75 4.75C5.19772 4.75 4.75 5.19771 4.75 5.75V12.75C4.75 13.3023 5.19771 13.75 5.75 13.75C6.30229 13.75 6.75 14.1977 6.75 14.75C6.75 15.3023 6.30229 15.75 5.75 15.75H4.75C3.64543 15.75 2.75 14.8546 2.75 13.75V4.75C2.75 3.64543 3.64543 2.75 4.75 2.75L18.75 2.75C19.8546 2.75 20.75 3.64543 20.75 4.75V13.75C20.75 14.8546 19.8546 15.75 18.75 15.75Z" fill="currentColor"/>
                                    </svg>                                    
                                </span>
                                Import
                            </a>
                        @endif
                        @if (Auth::user()->is_user)
                            <a href="{{ route('peserta.create') }}" class="btn btn-primary">Add Participant</a>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end align-items-center d-none" id="form-selected">
                        <div class="fw-bold me-5">
                            <span class="me-2" id="selected_count"></span>Selected
                        </div>
                        @if (Auth::user()->is_admin)
                            <a href="{{ route('peserta.index', ['tag' => 'export']) }}" class="btn btn-primary me-3" id="btn-export-selected">
                                Export Selected
                            </a>
                            <button type="button" class="btn btn-danger" id="btn-delete">Delete Selected</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="tbl_peserta">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2" data-priority="1">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" id="select_all"/>
                                </div>
                            </th>
                            <th class="min-w-100px" data-priority="2">Registration Number</th>
                            <th class="min-w-200px" data-priority="3">Name</th>
                            <th class="min-w-175px" data-priority="4">Origin</th>
                            <th class="min-w-300px">Event Title</th>
                            <th class="min-w-75px"></th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_split_download" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Download Range</h5>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center rounded row-split">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_split_download_1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded" style="background-color: transparent !important;">
                <div class="row justify-content-center rounded">
                    
                </div>
            </div>
        </div>
    </div>

    @slot('js_custom')
        <script>
            $(document).ready(function() {
                let selectedData = [], ignoreData = [];
                var table = customDataTable('tbl_peserta', {
                    responsive: true,
                    'processing': true,
                    "serverSide": true,
                    "pageLength": 10,
                    order: [[1, 'asc']],
                    lengthMenu: [
                        [10, 25, 50, 100, 1000],
                        [10, 25, 50, 100, 1000],
                    ],
                    'ajax': {
                        'url': "{{ route('peserta.datatable') }}",
                        "type": "POST",
                    },
                    'columns': [
                        { 
                            data: 'id',
                            className: "text-md-center",
                            orderable: false, 
                            searchable: false,
                            render: function(data, raw, full, meta) {
                                return `
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="${data}" />
                                    </div>
                                `;
                            }
                        },
                        { 
                            data: 'no_reg',
                            name: 'no_reg',
                        },
                        { 
                            data: 'name',
                            name: 'name',
                        },
                        { 
                            data: 'origin',
                            name: 'origin',
                        },
                        { 
                            data: 'event_title',
                            name: 'event_title',
                        },
                        { 
                            data: 'action',
                            className: "text-md-end",
                            orderable: false, 
                            searchable: false,
                            render: function (data, meta, full) {
                                let action = ``;

                                if(data.edit.isCan) 
                                {
                                    action += `
                                        <a class="btn btn-icon btn-active-light-primary w-30px h-30px" href="${data.edit.link}">
                                            <span class="svg-icon svg-icon-3">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="currentColor" />
                                                    <path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </a>
                                    `;
                                }

                                if(data.delete.isCan) 
                                {
                                    action += `
                                        <button class="btn btn-icon btn-active-light-primary w-30px h-30px table-delete" data-link="${data.delete.link}" data-name="registration number ${full.no_reg}">
                                            <span class="svg-icon svg-icon-3">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                    `;
                                }
                                
                                return action;
                            }
                        },
                    ],
                    "drawCallback": function( settings, start, end, max, total, pre ) {
                        $('#data_total').html(this.fnSettings().fnRecordsTotal())
                    },
                });

                $("#form-search").keyup(function(){
                    table.search($(this).val()).draw();
                });

                $('#btn-reset-form-search').on('click', function(e){
                    $('#form-search').val("")
                    table.search("").draw();
                })

                $('#tbl_peserta tbody').on('click', 'input[type="checkbox"]', function(e) {
                    let val = $(this).val();
                    if(this.checked)
                    {
                        selectedData.push(val)
                        ignoreData.splice(ignoreData.findIndex(a => a == val) , 1);
                    }
                    else 
                    {
                        $('#select_all').prop('checked', false);
                        selectedData.splice(selectedData.findIndex(a => a == val) , 1);
                        ignoreData.push(val)
                    }
                    showBatchDelete();
                });

                $('#select_all').on('click', function(e) {
                    selectedData = [];
                    ignoreData = [];
                    //select all data
                    var rows = table.rows({ 'search': 'applied' }).nodes();
                    $('input[type="checkbox"]', rows).prop('checked', this.checked);
                    
                    if(this.checked){
                        selectedData = table.columns(0).data().toArray()[0] ?? []
                    }
                    showBatchDelete();
                })

                $('#btn-delete').on('click', function (e) {
                    let selected = selectedData;
                    let link = "{{ route('peserta.destroy-batch') }}";
                    let name = `${selected.length} data selected`;

                    $('#form-delete').append(`
                        <input type="hidden" value="${selected.toString()}" name="ids">
                    `);

                    formDelete(link, name, false)
                        .then((data) => {
                            location.reload();
                        });
                })

                $('#btn-export').on('click', function(e) {
                    let totalRecord = table.page.info().recordsTotal;
                    if(totalRecord > 20000)
                    {
                        e.preventDefault();
                        splitDownload(totalRecord)
                    }
                })

                let indexUrl = "{{ route('peserta.index') }}"
                function showBatchDelete()
                {
                    let selected = selectedData;
                    $('#btn-export-selected').attr('href', 'javascript:void(0)')
                    if(selected.length == 0){
                        $('#form-selected').addClass('d-none');
                        $('#form-nonselected').removeClass('d-none');
                    }
                    else {
                        $('#form-selected').removeClass('d-none');
                        $('#form-nonselected').addClass('d-none');
                        $('#selected_count').html(selected.length);
                        $('#btn-export-selected').attr('href', indexUrl+`?tag=export&ids=${selected.toString()}`)
                    }
                }

                function splitDownload(totalRecord) 
                {
                    $('#modal_split_download .row.justify-content-center').html('');
                    let lastMaxCard = 20000, lastMinCard = 0;
                    while (totalRecord > 0) {
                        let range = `${lastMinCard + 1} - ${lastMaxCard}`;
                        $('#modal_split_download .row-split').append(`
                            <div class="col-md-3 my-1">
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-primary btn-range" data-range="${range}">${range}</button>
                                </div>                        
                            </div>
                        `)
                        totalRecord -= 20000;
                        lastMinCard += lastMaxCard;
                        lastMaxCard += (totalRecord > 20000 ? lastMaxCard : totalRecord)
                    }
                    $('#modal_split_download').modal('show');

                    $('#modal_split_download .row-split').on('click', '.btn-range', function(e){
                        let range = $(this).data('range');
                        location.href = indexUrl+`?tag=export&range=`+range;
                    })
                    
                }
            });
        </script>
    @endslot
</x-template-layout>