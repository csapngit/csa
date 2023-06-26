<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
  <base href="../../../../">
  <meta charset="utf-8" />
  <title>{{ config('app.name') }} | @yield('title', $page_title ?? '')</title>
  <meta name="description" content="Singin page example" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="canonical" href="https://keenthemes.com/metronic" />

  <!--begin::Fonts-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
  <!--end::Fonts-->

  @foreach(config('layout.resources.login-css') as $style)
  <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}" rel="stylesheet"
    type="text/css" />
  @endforeach


  <link rel="shortcut icon" href="{{ asset('media/logos/csa.ico') }}" />

</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body"
  class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

  <!--begin::Main-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
      <!--begin::Aside-->
      <div class="login-aside d-flex flex-column flex-row-auto">
        <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
        </div>

        <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-x-center"
          style="background-position-y: calc(100% + 5rem); background-image: url(media/svg/illustrations/login-csa.png)">
        </div>
      </div>

      <div class="login-content flex-row-fluid d-flex flex-column p-10">
        <div class="d-flex flex-row-fluid flex-center">
          <div class="login-form">
            {!! Form::open(['route' => ['login'], 'id' => 'kt_login_singin_form']) !!}

            @if ($errors->any())
            <div class="text-danger mb-2">
              {{ __('message.error_login') }}
            </div>
            @endif

            <div class="pb-5 pb-lg-15">
              <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Login CSAPNG</h3>
            </div>

            <div class="form-group">
              <label class="font-size-h6 font-weight-bolder text-dark">Username / Email</label>
              <input class="form-control h-auto py-7 px-6 rounded-lg border-0" type="text" name="login"
                autocomplete="off" value="{{ old('login') }}" />
            </div>

            <div class="form-group">
              <div class="d-flex justify-content-between mt-n5">
                <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
              </div>

              <input class="form-control h-auto py-7 px-6 rounded-lg border-0" type="password" name="password"
                autocomplete="off" />
            </div>
            <div class="pb-lg-0 pb-5">
              <button type="submit" id="kt_login_singin_form_submit_button"
                class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Masuk</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>


  <script>
    var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";

  </script>
  <!--begin::Global Config(global config for global JS scripts)-->
  <script>
    var KTAppSettings = {
      "breakpoints": {
        "sm": 576,
        "md": 768,
        "lg": 992,
        "xl": 1200,
        "xxl": 1400
      },
      "colors": {
        "theme": {
          "base": {
            "white": "#ffffff",
            "primary": "#3699FF",
            "secondary": "#E5EAEE",
            "success": "#1BC5BD",
            "info": "#8950FC",
            "warning": "#FFA800",
            "danger": "#F64E60",
            "light": "#E4E6EF",
            "dark": "#181C32"
          },
          "light": {
            "white": "#ffffff",
            "primary": "#E1F0FF",
            "secondary": "#EBEDF3",
            "success": "#C9F7F5",
            "info": "#EEE5FF",
            "warning": "#FFF4DE",
            "danger": "#FFE2E5",
            "light": "#F3F6F9",
            "dark": "#D6D6E0"
          },
          "inverse": {
            "white": "#ffffff",
            "primary": "#ffffff",
            "secondary": "#3F4254",
            "success": "#ffffff",
            "info": "#ffffff",
            "warning": "#ffffff",
            "danger": "#ffffff",
            "light": "#464E5F",
            "dark": "#ffffff"
          }
        },
        "gray": {
          "gray-100": "#F3F6F9",
          "gray-200": "#EBEDF3",
          "gray-300": "#E4E6EF",
          "gray-400": "#D1D3E0",
          "gray-500": "#B5B5C3",
          "gray-600": "#7E8299",
          "gray-700": "#5E6278",
          "gray-800": "#3F4254",
          "gray-900": "#181C32"
        }
      },
      "font-family": "Poppins"
    };

  </script>
  <!--end::Global Config-->
  @foreach(config('layout.resources.login-js') as $script)
  {{--<script src="{{ asset($script) }}" type="text/javascript"></script>--}}
  @endforeach

</body>
<!--end::Body-->

</html>
