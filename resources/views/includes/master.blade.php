@include($pages['head'])

<body class="fix-header">

    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
        </svg>
    </div>

    <div id="wrapper">

    @include($pages['navbar'])

        @include($pages['sidebar'])

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">

                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 pull-right">

                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            @if ($title != 'Dashboard')
                            <li class="active">{{$title}}</li>
                            @endif

                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                @include('includes.error')
                @include($pages['body'])


            </div>
            <!-- /.container-fluid -->
        @include($pages['footer'])

        </div>

    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    @include($pages['scripts'])
</body>

</html>
