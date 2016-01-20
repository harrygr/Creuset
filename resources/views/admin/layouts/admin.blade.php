<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title') | Creuset</title>

    <!-- Bootstrap -->
    {{--<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="{{ elixir('css/admin.all.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body class="hold-transition skin-blue sidebar-mini">

            <div id="admin" class="wrapper">
                @include('admin.layouts.header')

                <!-- Sidebar -->
                @include('admin.layouts.sidebar') 

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                      <h1>@yield('heading')</h1>
                        @yield('breadcrumbs')
                </section>


                <!-- Main content -->
                <section class="content">

                    @include('partials.alert')
                    @yield("admin.content")

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->        


        </div>
        <!-- /#admin -->


    @include('admin.layouts.footer')

    {{-- Browserify --}}
    {!! HTML::script(elixir('js/admin.js')) !!}
    {!! HTML::script('js/admin-lte.js') !!}

    @yield('admin.scripts')
</body>

</html>