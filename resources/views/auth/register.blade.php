
<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets/') }}"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Register</title>

    <meta name="description" content="" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    <!-- SweetAlert 2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <!-- SweetAlert  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Content -->


    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
          <div class="authentication-inner">
            <!-- Register Card -->
            <div class="card">
              <div class="card-body">
                <!-- Logo -->
                <div class="app-brand justify-content-center">

                </div>
                <!-- /Logo -->
                <h4 class="mb-2">Jelajahi Produk Kami 🚀</h4>
                <p class="mb-4">Silahkan register dan jelajahi produk yang kami!</p>

                <form id="formAuthentication" class="mb-3" action="{{ route('register.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                    <label for="username" class="form-label">Nama</label>
                    <input
                      type="text"
                      class="form-control"
                      id="username"
                      name="name"
                      placeholder="Isi nama anda"
                      autofocus />
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Isi email anda" />
                  </div>
                  <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-merge">
                      <input
                        type="password"
                        id="password"
                        class="form-control"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password" />
                      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary d-grid w-100">Register</button>
                </form>

                <p class="text-center">
                  <span>Sudah punya akun?</span>
                  <a href="{{ route('login') }}">
                    <span>Login</span>
                  </a>
                </p>
              </div>
            </div>
            <!-- Register Card -->
          </div>
        </div>
      </div>

      <!-- / Content -->

      @if(Session::has('error_message'))
      @push('scripts')
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ Session::get('error_message') }}",
            showConfirmButton: false,
            timer: 3000 // milliseconds
        });
        </script>
      @endpush
    @endif
    @if(Session::has('success_message_logout'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: 'success',
            title: '{{ Session::get("success_message_logout") }}'
        });
    </script>
  @endif

  @if ($errors->any())
      @foreach ($errors->all() as $error)
          <script>
              const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer);
                      toast.addEventListener('mouseleave', Swal.resumeTimer);
                  }
              });

              Toast.fire({
                  icon: 'error',
                  title: 'Error!',
                  html: '{{ $error }}'
              });
          </script>
      @endforeach
  @endif

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
