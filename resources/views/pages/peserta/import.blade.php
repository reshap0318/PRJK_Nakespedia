<x-template-layout>
    @slot('title') Participant import @endslot

    @slot('css_template')
        <link href="{{ asset('template/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endslot

    @slot('js_template')
        <script src="{{ asset('template/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    @endslot
    
    {{ Form::open(['method' => 'POST', 'url' => route('peserta.import-save', ['is_preview' => 0]), 'files' => true, 'id' => 'form-import']) }}
        <div class="card card-flush h-lg-100" id="">
            <div class="card-header pt-7" id="">
                <div class="card-title">
                    <span class="svg-icon svg-icon-2 me-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                        </svg>
                    </span>
                    <h2>Import Participant</h2>
                </div>
            </div>
            <div class="card-body pt-5">
                <div class="fv-row mb-7">
                    <input type="file" name="file" id="form_file" class="form-control form-control-solid" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <x-validation-error name="file"></x-validation-error>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('peserta.import', ['tag' => 'template']) }}" type="reset" class="btn btn-primary me-3">Download Template</a>
                    <div class="text-end">
                        <a href="{{ route('peserta.index') }}" type="reset" class="btn btn-light me-md-3 d-inline-block">Cancel</a>
                        <button type="button" class="btn btn-primary d-inline-block" id="btn-preview">
                            <span class="indicator-label">Preview</span>
                            <span class="indicator-progress">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card card-flush h-lg-100 mt-8 d-none" id="view_error">
            <div class="card-body pt-6">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="tbl_error">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">Row</th>
                            <th class="min-w-100px" data-priority="2">Registration Number</th>
                            <th class="min-w-200px" data-priority="3">Name</th>
                            <th class="min-w-175px" data-priority="4">Origin</th>
                            <th class="min-w-300px">Event Title</th>
                            <th class="min-w-150px">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600"></tbody>
                </table>
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary" id="btn-save">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">
                            Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div> 
        </div>
    {{ Form::close() }}

    @slot('js_custom')
        <script>
            $(document).ready(function() {
                var table = $('#tbl_error').DataTable({
                    "lengthChange": false,
                    'processing': true,
                    "data": [],
                    'columns': [
                        { 
                            data: 'row',
                            className: "text-md-center"
                        },
                        { 
                            data: 'no_reg',
                        },
                        { 
                            data: 'name',
                        },
                        { 
                            data: 'origin',
                        },
                        { 
                            data: 'event_title',
                        },
                        { 
                            data: 'errors',
                            render: function(data, raw, full, meta) {
                                let result = ``;
                                data.filter((elm, idx)=> idx < 1).forEach((elm, idx) => {
                                    result += `<span class="badge badge-light-danger fs-7 m-1">${elm}</span>`;
                                });
                                
                                if(data.length > 1) result += ` <span class="badge badge-light-danger fs-7 m-1">${data.length-1} more</span>`;
                                return result;
                            }
                        }
                    ],
                    "language": {
                        "emptyTable": "No Data Error"
                    }
                });

                function preview(){
                    $('#view_error').addClass('d-none');
                    var file_data = $('#form_file').prop('files')[0];
                    var form = new FormData();                  
                    form.append('file', file_data);

                    $('#error_file').html('');

                    $('#btn-preview').attr('data-kt-indicator', 'on');
                    $('#btn-preview').prop('disabled', true);

                    $.ajax({
                        url : "{{ route('peserta.import-save', ['is_preview' => 1]) }}",
                        type: 'POST',
                        dataType : 'json',
                        data: form,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(result){
                            $('#view_error').removeClass('d-none');
                            $('#btn-save').show();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR);
                            if(jqXHR.status == 422){
                                if('file' in jqXHR.responseJSON.errors){
                                    let error = jqXHR.responseJSON.errors.file.at(-1);
                                    $('#error_file').html(error);
                                }
                            }else if(jqXHR.status == 500){
                                if(jqXHR.responseJSON.code == 'xls'){
                                    let error = jqXHR.responseJSON.message;

                                    table.clear().draw();
                                    table.rows.add(error).draw();

                                    if(error.filter(elm => elm.errors.length > 0).length > 0)
                                    {
                                        $('#btn-save').hide();
                                    }
                                    else
                                    {
                                        $('#btn-save').show();
                                    }
                                    $('#view_error').removeClass('d-none');
                                }
                                else {
                                    let error = jqXHR.responseJSON.message;
                                    $('#error_file').html(error);
                                }
                            }
                            else {
                                let error = jqXHR.responseJSON.message;
                                $('#error_file').html(error);
                            }
                        },
                        complete: function (data) {
                            $('#btn-preview').removeAttr('data-kt-indicator');
                            $('#btn-preview').prop('disabled', false);
                        }
                    });
                }

                $('#btn-preview').on('click', function(e) {
                    e.preventDefault()
                    preview()
                });

                $('#form_file').click(function(){
                    $(this).val("");
                    table.clear().draw();
                    $('#view_error').addClass('d-none');
                });

                $('#form-import').on('submit', function(e) {
                    $('#btn-save').attr('data-kt-indicator', 'on');
                    $('#btn-save').prop('disabled', true);
                })
            });
        </script>
    @endslot

</x-template-layout>