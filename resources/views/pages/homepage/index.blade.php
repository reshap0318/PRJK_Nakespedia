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
        
        .nakespedia-title {
            width: 92%;
        }

        @media screen and (min-width: 601px) and (max-width: 1024px) {

            .nakespedia-title {
                width: 92%;
            }

            .sertifikat {
                height:507.16px;
                width:552px;
                margin-top: 30px;
            }

            .text-information {
                font-size:16px;
                text-align:left; 
                margin-left: 10px; 
                margin-right:10px;
            }

            .form-search {
                height: 60px;
                width: 90%;
                font-size: 16px;
            }

            .btn-search{
                font-size: 14px;
            }

            .form-spacing {
                margin-right: 30px;
            }

            .card-result {
                font-size: 18px;
                margin-left: 0px !important; 
                margin-right:0px !important;
                padding-top: 16px !important;
                padding-bottom: 16px !important;
            }

            .result-table {
                font-size:16px;
                width: 100%;
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
                                                <input type="text" id="input-search" class="form-control w-xl-700px w-md-500px w-350px ps-17 form-search" name="no_reg" placeholder="Registration Number" value="{{ $no_reg ?? null }}"/>
                                                <button type="submit" class="btn position-absolute btn-search px-8">Search</button>
                                            </div>
                                        </div>
                                        <div id="card-result">
                                            @if ($data)
                                                <div class="card" style="max-width: 760px;">
                                                    <div class="card-body card-result">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="d-flex justify-content-center" id="form-result">
                                                                    <div class="d-flex align-items-center">
                                                                        Your Data Found
                                                                        <img src="{{ asset('custom/icons/verified-rounded.svg') }}" alt="nakespedia verified" width="25" class="ps-2">
                                                                    </div>
                                                                </div>
                                                                <div class="pt-2" id="result-table">
                                                                    <table class="result-table">
                                                                        <tr>
                                                                            <td>Registration</td>
                                                                            <td>&ensp;:&ensp;</td>
                                                                            <td>{{ $data->no_reg }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Name</td>
                                                                            <td>&ensp;:&ensp;</td>
                                                                            <td>{{ $data->name }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Origin</td>
                                                                            <td>&ensp;:&ensp;</td>
                                                                            <td>{{ $data->origin }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="vertical-align:top">Event Title</td>
                                                                            <td style="vertical-align:top">&ensp;:&ensp;</td>
                                                                            <td style="text-align: justify;text-justify: inter-word;">
                                                                                {{ $data->event_title }}
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif (Session::has('error'))
                                                <div class="card" style="max-width: 760px;">
                                                    <div class="card-body card-result bg-danger">
                                                        <div class="row">
                                                            <div class="col-12 text-center">
                                                                {{ Session::get('error') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center position-relative my-4 text-information">
                                                    Input your last 6 digit certificate registration number <br>
                                                    (Tuliskan 6 digit terakhir nomor registrasi sertifikat??anda)
                                                </div>
                                            @endif
                                        </div>

                                        <div class="card d-none" style="max-width: 760px;">
                                            <div class="card-body card-result bg-danger" id="card-result-error">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        Please Enter Registration Number!
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="{{ route('homepage.index') }}" class="btn btn-danger" id="btn_reset">Reset</a>
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

        $('#form-search').on('submit', function(e){
            e.preventDefault();
            let input = $('#input-search').val();

            let urlSearch = "{{ route('homepage.data', 'xxxxxxxxxx') }}"
            if(input == "")
            {
                $('#card-result').addClass('d-none')
                $('#card-result-error').addClass('bg-danger').parent().removeClass('d-none');
            }
            else {
                location.href = urlSearch.replace('xxxxxxxxxx', input)
            }

        });
    </script>
</body>
</html>