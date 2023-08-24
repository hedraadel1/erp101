<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <a href="{{ route('home') }}" class="logo">
            <span class="logo-lg">{{ Session::get('business.name') }}</span>

        </a>
        <div class="text-center  containerbtn" style="">
            <a style="width: 200px !important;margin-top: 3px;" class="buttonBlue"> <span
                    class="dock-containerspan">{{ 'الراتب  : ' .auth()->user()->get_salary() }}</span></a>
        </div>


        <!-- Sidebar Menu -->
        {!! Menu::render('admin-sidebar-menu', 'adminltecustom') !!}

        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
