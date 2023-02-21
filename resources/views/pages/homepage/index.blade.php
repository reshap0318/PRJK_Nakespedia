<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <title>{{ env('APP_NAME', 'nakespedia') }}</title>

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('template/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <style> 
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
            font-family: 'Montserrat';
            font-style: normal;
        }
        
        .bg {
            background-image: url("{{ asset('custom/images/background-homepage.png') }}");
            height: 100%; 
            background-position: center center;
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }

        .form-search {
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.25) !important;
            border-radius: 100px;
            height: 75px;
            font-size:20px;
            appearance: none;
        }

        .btn-search {
            right: 16px; 
            cursor: pointer; 
            z-index: 100; 
            background: #176FB4 !important; 
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.25) !important;
            color: #FFFFFF !important;
            border-radius: 100px;
            font-size:20px;
        }

        .btn-search:hover {
            background: #176FB4 !important; 
            color: #FFFFFF;
            border-radius: 100px;
        }

        .text-information {
            font-size:22px;
            text-align:left; 
            margin-left: 35px; 
            margin-right:35px
        }

        .card-result {
            margin-left: 35px !important; 
            margin-right:35px !important;
            padding-top: 22px !important;
            padding-bottom: 22px !important;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.25);
            border-radius: 25px;
            font-size:22px;
        }

        .sertifikat {
            height:807.16px;
            width:852px;
        }

        .form-spacing {
            margin-top: 100px;
        }

        .result-table {
            font-size:18px;
        }

        @media screen and (min-width: 601px) {
            .nakespedia-title {
                width: 92%;
            }
        }

        /* If the screen size is 600px wide or less, set the font-size of <div> to 30px */
        @media screen and (max-width: 600px) {
            .nakespedia-title {
                width: 340px;
            }

            .bg {
                background-image: url("{{ asset('custom/images/background-mobile-homepage.png') }}");
            }

            .text-information {
                font-size:12px;
            }

            .form-search {
                height: 60px;
                font-size: 14px;
            }

            .btn-search{
                font-size: 14px;
            }

            .sertifikat {
                height:235px;
                width:250px;
            }

            .form-spacing {
                margin-top: 30px;
            }

            .card-result {
                font-size: 14px;
                margin-left: 0px !important; 
                margin-right:0px !important;
                padding-top: 22px !important;
                padding-bottom: 22px !important;
            }

            .result-table {
                font-size:12px;
            }
        }

        .bg-danger {
            color: #FFFFFF !important;
            background-color: #D6392A!important;
            background: #D6392A;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid bg">
                        <div class="pt-7 px-10 d-none d-sm-block">
                            <img src="{{ asset('custom/images/nakespedia-blue-bg.svg') }}" alt="logo-nakespedia">
                        </div>

                        <div class="row mt-20">
                            <div class="col-md-6 col-12">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('custom/images/sertfikat.svg') }}" alt="sertifikat-nakespedia" class="sertifikat">
                                </div> 
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex justify-content-center form-spacing">
                                    <form action="#" id="form-search" class="" autocomplete="off">
                                        <div class="d-flex justify-content-center position-relative">
                                            <img src="{{ asset('custom/images/nakespedia.svg') }}" alt="logo-nakespedia" class="nakespedia-title">
                                        </div>
                                        <div class="d-flex justify-content-center mt-6 mb-3">
                                            <div class="d-flex align-items-center position-relative">
                                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                    <svg width="50px" height="50px" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <input type="text" id="input-search" class="form-control w-md-700px w-350px ps-17 form-search" name="no_reg" placeholder="Registration Number"/>
                                                <button type="submit" class="btn position-absolute btn-search px-8">Search</button>
                                            </div>
                                        </div>
                                        <div class="card d-none" style="max-width: 760px;">
                                            <div class="card-body card-result" id="card-result">
                                                <div class="d-flex justify-content-center" id="form-result">
                                                    <div class="d-flex align-items-center">
                                                        Your Data Found
                                                        <img src="{{ asset('custom/icons/verified-rounded.svg') }}" alt="nakespedia verified" width="25" class="ps-2">
                                                    </div>
                                                </div>
                                                <div class="pt-2" id="result-table"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center position-relative my-4 text-information" id="txt-information-input">
                                            Input your last 6 digit certificate registration number <br>
                                            (Tuliskan 6 digit terakhir nomor registrasi sertifikat anda)
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="button" class="btn btn-danger" id="btn_reset">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Page-->
    </div>
    
    
    <script>var hostUrl = "{{ asset('template/assets') }}";</script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('template/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('template/assets/js/scripts.bundle.js') }}"></script>

    <script>
        function wrap(s, w) {
            let arr = [];
            while (s.length > 0) {
                arr.push(s.substring(0, w));
                s = s.substring(w);
            }
            return arr
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json' 
            }
        });

        $('#form-search').on('submit', function(e){
            e.preventDefault();
            let input = $('#input-search').val();
            $('#card-result').removeClass('bg-danger').parent().removeClass('d-none');
            $('#txt-information-input').addClass('d-none');
            $('#result-table').html('');

            if(input == "")
            {
                $('#card-result').addClass('bg-danger');
                $('#form-result').html('Please Enter Registration Number!');
            }
            else {
                $('#form-result').html('Waiting...');
                let url = "{{ route('homepage.data') }}"

                let data = $(this).serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});
    
                $.ajax({
                    url : url,
                    dataType : 'json',
                    type: 'POST',
                    data: data
                })
                .done(res => {
                    let data = res.data;
                    let imgVerified = "{{ asset('custom/icons/verified-rounded.svg') }}";
                    $('#form-result').html(`
                        <div class="d-flex align-items-center">
                            Your Data Found
                            <img src="${imgVerified}" alt="nakespedia verified" width="25" class="ps-2">
                        </div>
                    `);
                    $('#result-table').html(`
                        <table class="result-table">
                            <tr>
                                <td>Registration</td>
                                <td>&ensp;:&ensp;</td>
                                <td>${data.no_reg}</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>&ensp;:&ensp;</td>
                                <td>${data.name}</td>
                            </tr>
                            <tr>
                                <td>Origin</td>
                                <td>&ensp;:&ensp;</td>
                                <td>${data.origin}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top">Event Title</td>
                                <td style="vertical-align:top">&ensp;:&ensp;</td>
                                <td style="text-align: justify;text-justify: inter-word;">
                                    ${data.event_title}
                                </td>
                            </tr>
                        </table>
                    `);

                    $('#card-result').parent().css('margin-left', '32px').css('margin-right', '32px');
                })
                .fail(xhr => {
                    $('#card-result').parent().css('margin-left', '0px').css('margin-right', '0px');
                    if (xhr.status == 404) {
                        $('#card-result').addClass('bg-danger');
                        $('#form-result').html('Your Data Not Found!');
                    }
                    else if (xhr.status == 422) {
                        $('#card-result').addClass('bg-danger');
                        $('#form-result').html('Please Enter Registration Number!');
                    }
                    else if (xhr.status == 500) {
                        $('#card-result').addClass('bg-danger');
                        $('#form-result').html('Internal Server Error!');
                    }
                    else {
                        $('#card-result').addClass('bg-danger');
                        $('#form-result').html('Please Reload The Page!');
                    }
                });
            }

        });        

        $('#btn_reset').on('click', function(e) {
            $('#result-table').html('');
            $('#input-search').val('')
            $('#card-result').removeClass('bg-danger').parent().addClass('d-none');
            $('#txt-information-input').removeClass('d-none');
        });
    </script>
</body>
</html>