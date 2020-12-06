<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Datatables bootstrap css -->
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <!-- Datatables jquery css -->
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <!-- fancybox css -->
    <link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet">

    <!-- SELECT 2 css -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">

    <!-- Jquery js -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    
    <!-- Datatables jquery js -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    
    <!-- bootstrap js -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Datatables bootstrap js -->
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- fancybox js -->
    <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
    
    <!-- Sweet alert js -->
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    
    <!-- Moment js -->
    <script src="{{ asset('js/moment.js') }}"></script>
    
    <!-- SELECT 2 js -->
    <script src="{{ asset('js/select2.min.js') }}"></script>
    
    <!-- Chart Bundle js -->
    <script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
    
    <!-- Chart js -->
    <script src="{{ asset('js/Chart.min.js') }}"></script>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="container-with-sidebar">
        <nav class="navbar navbar-expand-md navbar-light bg-indigo shadow-sm">
            <div class="container">
                <a class="navbar-brand navbar_center_logo text-white" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item text-white">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a style="padding-right: 20px" id="notificationDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <span data-feather="bell"></span><span class="caret"></span><span class="badge badge-danger badge-here"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" id="notification-main-div" aria-labelledby="navbarDropdown"></div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->fname." ". Auth::user()->lname }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->user_role === 99)
                                        <a class="dropdown-item" href="{{ route('area.index') }}">
                                            {{ __('Manage Area') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('ads.index') }}">
                                            {{ __('Manage Ads') }}
                                        </a>
                                        <hr/>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <nav class="col-md-2 d-none d-md-block bg-light sidebar" style="padding-top: 0">
            <div class="sidebar-sticky">
                @if(Auth::user())
                    @if(Auth::user()->user_role == 99)
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('home') }}">
                                <span data-feather="home"></span>
                                Dashboard <span class="sr-only"></span>
                            </a>
                        </li>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Manage</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('staff.index') }}">
                                <span data-feather="user"></span>
                                Staff
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.index') }}">
                                <span data-feather="users"></span>
                                Client
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('product.index') }}">
                                <span data-feather="clipboard"></span>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('fridge.index') }}">
                                <span data-feather="book"></span>
                                Fridge
                            </a>
                        </li>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Submit Order to Customer</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('shop') }}">
                                <span data-feather="shopping-bag"></span>
                                Shop
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <span data-feather="shopping-cart"></span>
                                Cart
                            </a>
                        </li>


                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Reports</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('order.index') }}">
                                <span data-feather="align-justify"></span>
                                Orders
                            </a>
                            <a class="nav-link" href="{{ route('sales.index') }}">
                                <span data-feather="pie-chart"></span>
                                Sales Report
                            </a>
                            <a class="nav-link" href="{{ route('loss.index') }}">
                                <span data-feather="bar-chart-2"></span>
                                Loss Report
                            </a>
                            <a class="nav-link" href="{{ route('quota.index') }}">
                                <span data-feather="pie-chart"></span>
                                Quota
                            </a>
                        </li>


                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Emergency</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('emergency.index') }}">
                                <span data-feather="message-circle"></span>
                                Failed Delivery
                            </a>
                        </li>

                        
                    </ul>
                    @endif

                    @if(Auth::user()->user_role == 2)
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('home') }}">
                                <span data-feather="home"></span>
                                Dashboard <span class="sr-only"></span>
                            </a>
                        </li>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Transactions</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('shop') }}">
                                <span data-feather="shopping-bag"></span>
                                Shop Now
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <span data-feather="shopping-cart"></span>
                                Cart
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('store.index') }}">
                                <span data-feather="archive"></span>
                                Stores
                            </a>
                        </li>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Reports</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('transaction_history.index') }}">
                                <span data-feather="bar-chart-2"></span>
                                Transactions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('file_replacement.index') }}">
                                <span data-feather="file-text"></span>
                                File Replacement
                            </a>
                        </li>
                    </ul>
                    @endif

                    @if(Auth::user()->user_role == 1)
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('main.index') }}">
                                <span data-feather="home"></span>
                                Dashboard <span class="sr-only"></span>
                            </a>
                        </li>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Reports</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('product_list.index') }}">
                                <span data-feather="clipboard"></span>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('main.index') }}">
                                <span data-feather="bar-chart-2"></span>
                                Transactions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client_list.index') }}">
                                <span data-feather="users"></span>
                                Clients
                            </a>
                        </li>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Issues</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('file_replacement.index') }}">
                                <span data-feather="file"></span>
                                File Replacement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('file_damage.index') }}">
                                <span data-feather="file-minus"></span>
                                File Damage
                            </a>
                        </li>
                    </ul>
                    @endif
                @endif
            </div>
        </nav>

        <main class="py-4 container-with-sidebar">
            @yield('content')
        </main>

        <script>
            function onlyNumbers(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }

            function onlyLetters(evt)
            {
                var keyCode = (evt.which) ? evt.which : evt.keyCode
                if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
                
                return false;
                    return true;
            }

            // function onlyLetters(evt) {
            //     evt = (evt) ? evt : event;
            //     var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
            //         ((evt.which) ? evt.which : 0));
            //     if (charCode > 31 && (charCode < 65 || charCode > 90) &&
            //         (charCode < 97 || charCode > 122)) {
            //         // alert("Enter letters only.");
            //         return false;
            //     }
            //     return true;
            // }
        </script>
    </div>


    <!-- Icons -->
    <script src="{{ asset('js/feather.min.js') }}"></script>

    <script>
      feather.replace()
    </script>

    <script type="text/javascript">
        $(function () {
            //ajax setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //declare counter
            var notificationCount = 0;
            var currentCount = 0;

            //when notificationDropdown is clicked
            $("#notificationDropdown").click(function(){
                //remove the badge
                $(".badge-here").html('');
            });

            //call the function for displaying the notifications
            displayNotifications();

            //create a function that will display the notifications
            function displayNotifications(){
                $.ajax({
                    type: "GET",
                    url: "{{ url('notification') }}",
                    success: function (data) {
                        notificationCount = data.length;

                        //check if the count has been added
                        if(currentCount != 0 && notificationCount > currentCount){
                            $(".badge-here").html(notificationCount - currentCount);
                        }

                        let output = '';
                        if(data.length > 0){
                            for (var i=0; i < data.length; i++){
                                output += `<a class="dropdown-item notifications notif_wrapper" href="#">
                                        ${data[i].note_description}
                                    </a>`
                            }
                        }else{
                        output += `<a class="dropdown-item notifications" href="#">No notifications found.</a>`
                        }

                        //return the output
                        $('#notification-main-div').html(output);

                        //refresh every 5 seconds
                        setTimeout(displayNotifications, 2000);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });

                //update the current count
                currentCount = notificationCount;
            }

        });
    </script>

</body>
</html>
