<x-template-layout>
    @slot('title') user @endslot

    @slot('css_template')
        <link href="{{ asset('template/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endslot

    @slot('js_template')
        <script src="{{ asset('template/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    @endslot

    <x-custom.card-table-v1 name="user" tableId="tbl_user" href="{{ route('user.create') }}" permission="{{ Auth::user()->is_su_admin }}">
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th class="min-w-350px">User</th>
            <th class="min-w-150px">Username</th>
            <th class="min-w-200px">Email</th>
            <th class="min-w-150px">Role</th>
            <th class="min-w-125px">Last login</th>
            <th class="min-w-50px"></th>
        </tr>
    </x-custom.card-table-v1>

    @slot('js_custom')
        <script>
            $(document).ready(function() {
                var table = customDataTable('tbl_user', {
                    responsive: true,
                    "lengthChange": false,
                    'processing': true,
                    "serverSide": true,
                    "pageLength": 10,
                    order: [[0, 'asc']],
                    dom: `<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                    'ajax': {
                        'url': "{{ route('user.datatable') }}",
                        "type": "POST",
                    },
                    'columns': [
                        { 
                            data: 'name',
                            className: "d-flex align-items-center",
                            render: function(data, raw, full) {
                                return `
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                        <a href="javascript:void(0)">
                                            <div class="symbol-label">
                                                <img src="${full.avatar_url}" alt="${data}" class="w-100" />
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0)" class="text-gray-800 text-hover-primary mb-1">${data}</a>
                                        <span>${full.email}</span>
                                    </div>
                                `;
                            }
                        },
                        { 
                            data: 'username',
                            name: 'username',
                        },
                        { 
                            data: 'email',
                            name: 'email',
                        },
                        { 
                            data: 'role_text',
                            name: 'role',
                            render: function (data){
                                return `<span class="badge badge-light-primary fs-7 m-1">${data}</span>`;
                            }
                        },
                        { 
                            data: 'last_login',
                            name: 'last_login',
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
                                        <button class="btn btn-icon btn-active-light-primary w-30px h-30px table-delete" data-link="${data.delete.link}" data-name="${full.name}">
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
                });

                // overide from public/custom/app.js
                $("#tbl_user").on( 'click', '.table-edit', function () {
                    
                });

                $("#form-search").keyup(function(){
                    table.search($(this).val()).draw();
                })
            });
        </script>
    @endslot
</x-template-layout>