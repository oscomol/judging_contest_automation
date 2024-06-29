<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JCA</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
</head>

<body>
    <div class="loading">
        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="wrapper" style="display: none;">
        <aside id="sidebar" class="expand">


            <div class="logoCont" id="mainLogoCont">
                <img src="/Image/missq.jpg" class="logo">
                <h5 style="color: black;">Administrator</h5>
            </div>

            <h5 class="d-none m-auto" id="jca">JCA</h5>

            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ url('/jca') }}" class="sidebar-link">
                        <i class="fa fa-tachometer"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('event.index') }}" class="sidebar-link">
                        <i class="fa fa-calendar"></i>
                        <span>Events</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/jca/admin') }}" class="sidebar-link">
                        <i class="fa fa-user"></i>
                        <span>Admin</span>
                    </a>
                </li>

            </ul>
            <div class="sidebar-footer">
                <a class="sidebar-link" data-bs-toggle="modal" data-bs-target="#logout">
                    <i class="lni lni-exit"></i>
                    <span>{{ session('username') }}</span>
                </a>
            </div>
        </aside>
        <div class="main">
            <div
                class="container-fluid d-flex justify-content-between align-items-center px-4 pt-3 pb-1 mb-4 header">
                <h3>
                    @yield('title')
                </h3>
                @yield('searchBar')
            </div>
            <main class="content px-3">
                @yield('content')
            </main>



            <!-- Modal -->
            <div class="modal fade" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Admin logout</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure to logout ?
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('admin.logout') }}" class="btn btn-primary">
                                Yes
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <button class="d-none" id="btnUp">
        <li class="fa fa-arrow-up"></li>
    </button>

    @yield('mainScript')
    <script>
        $(document).ready(function() {
            function handleResize() {
                const pageWidth = $(document).width();

                if (pageWidth < 900) {
                    $("#sidebar").removeClass("expand");
                    $("#mainLogoCont").removeClass().addClass('d-none');
                    $("#jca").removeClass().addClass('m-auto mt-3 text-dark');
                }else{
                    $("#sidebar").addClass("expand");
                    $("#mainLogoCont").removeClass().addClass('mainLogoCont');
                    $("#jca").removeClass().addClass('d-none');
                }
            }

            setTimeout(() => {
                $('.loading').css('display', 'none');
                $('.wrapper').css('display', 'flex');
            }, 1000);

            handleResize();

            $('.toggle-btn').click(function() {
                const pageWidth = $(document).width();
                if (pageWidth > 900) {
                    $("#sidebar").toggleClass("expand");
                }
            });

            $(window).resize(handleResize);

            $(".main").scroll(function(){
                var scrollTop = $(this).scrollTop();
                if(scrollTop > 80){
                    $("#btnUp").removeClass().addClass("btn btn-warning btn btn-lg");
                }else{
                    $("#btnUp").removeClass().addClass("d-none");
                }
            })
            $("#btnUp").click(function(){
                $('.main').scrollTop(0);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>



<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    ::after,
    ::before {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    a {
        text-decoration: none;
    }

    li {
        list-style: none;
    }

    body {
        font-family: 'Poppins', sans-serif;
        overflow-y: hidden;
    }

    .wrapper {
        display: none;
    }

    .main {
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 100%;
        overflow: hidden;
        transition: all 0.35s ease-in-out;
        background-color: #fff;
        min-width: 0;
        overflow-y: auto;
        scroll-behavior: smooth;
    }

    #sidebar {
        width: 70px;
        min-width: 70px;
        z-index: 1000;
        transition: all .25s ease-in-out;
        background-color: #C4A484;
        display: flex;
        flex-direction: column;
        height: 100vh;

    }

    #sidebar.expand {
        width: 200px;
        min-width: 200px;
    }

    .toggle-btn {
        background-color: transparent;
        cursor: pointer;
        border: 0;
        padding: 1rem 1.5rem;
    }

    .toggle-btn i {
        font-size: 1.5rem;
        color: #FFF;
    }

    .sidebar-logo {
        margin: auto 0;
    }

    .sidebar-logo a {
        color: #FFF;
        font-size: 1.15rem;
        font-weight: 600;
    }

    #sidebar:not(.expand) .sidebar-logo,
    #sidebar:not(.expand) a.sidebar-link span {
        display: none;
    }

    #sidebar.expand .sidebar-logo,
    #sidebar.expand a.sidebar-link span {
        animation: fadeIn .25s ease;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    .sidebar-nav {
        padding: 2rem 0;
        flex: 1 1 auto;
    }

    a.sidebar-link {
        padding: .625rem 1.625rem;
        color: black;
        display: block;
        font-size: 0.9rem;
        white-space: nowrap;
        border-left: 3px solid transparent;
    }

    .sidebar-link i,
    .dropdown-item i {
        font-size: 1.1rem;
        margin-right: .75rem;
    }

    a.sidebar-link:hover {
        background-color: rgba(255, 255, 255, .075);
        border-left: 3px solid #3b7ddd;
    }

    .sidebar-item {
        position: relative;
    }

    #sidebar:not(.expand) .sidebar-item .sidebar-dropdown {
        position: absolute;
        top: 0;
        left: 70px;
        background-color: #0e2238;
        padding: 0;
        min-width: 15rem;
        display: none;
    }

    #sidebar:not(.expand) .sidebar-item:hover .has-dropdown+.sidebar-dropdown {
        display: block;
        max-height: 15em;
        width: 100%;
        opacity: 1;
    }

    #sidebar.expand .sidebar-link[data-bs-toggle="collapse"]::after {
        border: solid;
        border-width: 0 .075rem .075rem 0;
        content: "";
        display: inline-block;
        padding: 2px;
        position: absolute;
        right: 1.5rem;
        top: 1.4rem;
        transform: rotate(-135deg);
        transition: all .2s ease-out;
    }

    #sidebar.expand .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
        transform: rotate(45deg);
        transition: all .2s ease-out;
    }

    .navbar {
        background-color: #f5f5f5;
        box-shadow: 0 0 2rem 0 rgba(33, 37, 41, .1);
    }

    .navbar-expand .navbar-collapse {
        min-width: 200px;
    }

    .avatar {
        height: 40px;
        width: 40px;
    }

    .loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @media (min-width: 768px) {}

    #btnUp{
        position: fixed;
        right: 10;
        bottom: 20;
        color: white
    }
    #mainLogoCont{
        margin-top: 15px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 7px;
    }
    .header{
        background: #F5F5DC;
    }
    .logo{
        width: 80px;
        height: 80px;
        border-radius: 50%;
    }
</style>
