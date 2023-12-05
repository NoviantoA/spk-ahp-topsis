<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title') </title>
    @include('layouts.style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    @stack('style')
    <!-- SweetAlert 2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- /.navbar -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('pages')</h1>
                        </div><!-- /.col -->
                        {{-- <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item active"> <a href="">@yield('pages')</a></li>
                            </ol>
                        </div><!-- /.col --> --}}
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            @yield('content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        {{-- footer  --}}
        @include('layouts.footer')
        {{-- end footer  --}}
    </div>
    {{-- script  --}}
    @if (Session::has('success_message'))
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
                title: '{{ Session::get('success_message') }}'
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

    @if (Session::has('error_message_update_details'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ Session::get('error_message_update_details') }}",
                showConfirmButton: false,
                timer: 3000 // milliseconds
            });
        </script>
    @endif

    @if (Session::has('error_message_not_found'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ Session::get('error_message_not_found') }}",
                showConfirmButton: false,
                timer: 3000 // milliseconds
            });
        </script>
    @endif

    @if (Session::has('error_message_delete'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ Session::get('error_message_delete') }}",
                showConfirmButton: false,
                timer: 3000 // milliseconds
            });
        </script>
    @endif

    @if (Session::has('success_message_create'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ Session::get('success_message_create') }}",
                showConfirmButton: false,
                timer: 3000 // milliseconds
            });
        </script>
    @endif

    @if (Session::has('success_message_update'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ Session::get('success_message_update') }}",
                showConfirmButton: false,
                timer: 3000 // milliseconds
            });
        </script>
    @endif

    @if (Session::has('success_message_delete'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ Session::get('success_message_delete') }}",
                showConfirmButton: false,
                timer: 3000 // milliseconds
            });
        </script>
    @endif
    @include('layouts.script')
    @stack('script')

    {{-- end script  --}}



</body>

</html>
