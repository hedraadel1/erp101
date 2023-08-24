@inject('request', 'Illuminate\Http\Request')

@if ($request->segment(1) == 'pos' && ($request->segment(2) == 'create' || $request->segment(3) == 'edit'))
    @php
        $pos_layout = true;
    @endphp
@else
    @php
        $pos_layout = false;
        $is_mobile = isMobile();
    @endphp
@endif

@php
    $whitelist = ['127.0.0.1', '::1'];
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
    dir="{{ in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="{{ asset('js/vendor/modernizr-2.6.2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menumodal.css') }}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ Session::get('business.name') }}</title>

    @include('layouts.partials.css')

    @yield('css')
    @if (isMobile())
        <style>
            .pagination {
                background: none !important;
                padding: 0px !important;
                border-radius: none;
                /* box-shadow: none !important; */
                border: none;
                display: flex;
                list-style: none;
                justify-content: center;
                box-shadow: 0 0 9px -5px;
            }

            .pagination li a {
                font-size: 18px;
                text-align: center;
                text-decoration: none;
                color: #4D3252;
                height: auto !important;
                display: block;
                line-height: auto;
                width: auto !important;
            }

            /* div.row.margin-bottom-20.text-center>div.col-sm-7 {
                position: relative !important;
                top: -35px !important;
            }

            div.row.margin-bottom-20.text-center>div.col-sm-3 {
                position: relative !important;
                top: -40px !important;
            }

            div.row.margin-bottom-20.text-center>div.col-sm-2 {
                position: relative !important;
                top: 110px !important;
            }

            .dataTables_wrapper .buttons-collection,
            .dataTables_wrapper .buttons-print,
            .dataTables_wrapper .buttons-excel,
            .dataTables_wrapper .buttons-csv {
                border: none !important;
                color: #ffffff;
                font-weight: 700;
                margin: 5px 0px !important;
                width: 40% !important;

            } */
        </style>
    @else
        <style>
            div.row.margin-bottom-20.text-center {
                margin-bottom: 0px !important;
            }
        </style>
    @endif
    <style>
       
    </style>
    <link rel="stylesheet" href="{{ asset('css/mystyle_theme1.css') }}">

    <style>
        .context-menu {
            list-style: none;
            z-index: 999999;
            position: absolute;
            font-size: 17px;
            font-weight: 900;
        }


        .floatapp {
            position: fixed;
            width: 42px;
            height: 42px;
            bottom: 50%;
            z-index: 1;
            left: 8px;
            background-color: #1a449f;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            box-shadow: 1px 1px 5px #441717;
        }

        .my-floatapp {
            margin-top: 15px;
        }

        .rihhtbut {
            color: white !important;
            width: 230px !important;
            font-size: 11px !important;
            margin-right: 10px !important;
            height: 25px !important;
            margin-bottom: 1px !important;
        }

        .menu {
            display: flex;
            flex-direction: column;
            background: #111827;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgb(64 64 64 / 5%);
            padding: 10px 0;
            -webkit-animation: fadeIn 0.1s ease-out;
            animation: fadeIn 0.5s ease-out;
            opacity: 1.0;
            display: block;
            width: 250px;
        }

        .menu>li>a {
            font: 'droid';
            border: 0;
            font-style: 'droid';
            padding: 2px 30px 2px 15px;
            width: 100%;
            display: flex;
            align-items: center;
            position: relative;
            text-decoration: unset;
            color: #000;
            font-weight: 500;
            transition: 0.5s linear;
            -webkit-transition: 0.5s linear;
            -moz-transition: 0.5s linear;
            -ms-transition: 0.5s linear;
            -o-transition: 0.5s linear;
        }

        .menu>li>a:hover {
            background: #273d6a;
            color: #4b00ff;
        }

        .menu>li {
            display: unset;
        }

        .menu>li>a>i {
            padding-right: 10px;
        }

        .menu>li.trash>a:hover {
            color: red;
        }

        /* Animatinons */
        @-webkit-keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1.0;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1.0;
            }
        }

        @-webkit-keyframes fadeOut {
            from {
                opacity: 1.0;
            }

            to {
                opacity: 0.0;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1.0;
            }

            to {
                opacity: 0.0;
            }
        }

        .width-120 {
            width: 120px !important;
        }
    </style>
    <script>
        var IS_RTL =
            {{ in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ? true : false }};
    </script>
    <script></script>
</head>

<body
    class="@if ($pos_layout) hold-transition lockscreen @else hold-transition skin-@if (!empty(session('business.theme_color'))){{ session('business.theme_color') }}@else{{ 'blue-light' }} @endif sidebar-mini @endif">

    @if (!isMobile() && session('business.enable_view_short_menu') == 1)
        <label style="bottom: 60%;cursor:pointer" href="#" for="dialog_state" class="floatapp">
            <i class="fa fa-th my-floatapp"></i>
        </label>
        <label style="cursor:pointer" for="dialog_state_report" href="#" class="floatapp">
            <i class="fa fa-list-alt  my-floatapp"></i>
        </label>
    @endif
    @if (isMobile())
        <label style="bottom: 60%;cursor:pointer" onclick="openNav()"class="floatapp">
            <i class="fa fa-th my-floatapp"></i>
        </label>
        {{--  --}}
    @endif
    <div id="contextMenu" class="context-menu" style="display: none">
        <ul class="menu">

            <li>
                <div style="margin-right: 15px;">
                    <button
                        style="margin-right: 10px;width: 100px !important;font-size: 12px !important;height: 30px !important;"
                        type="button" class="button-header-40 btn-sm btn-flat  btn-modal"
                        data-href="{{ action('ContactController@pay', ['type' => 'cust']) }}" title="@lang('lang_v1.logs')"
                        data-container=".view_modal"> @lang('lang_v1.paycust')
                    </button>
                    <button style="width: 100px !important;font-size: 12px !important;height: 30px !important;"
                        type="button" class="button-header-40 btn-flat btn-sm btn-modal"
                        data-href="{{ action('ContactController@pay', ['type' => 'supp']) }}" title="@lang('lang_v1.logs')"
                        data-container=".view_modal">@lang('lang_v1.paysupp')
                    </button>
                    <button class="button-header-40 btn-sm btn-flat"
                        style="margin-right: 10px;width: 100px !important;font-size: 12px !important;height: 30px !important;"
                        onclick="copy()">نسخ</button>
                    <button class="button-header-40 btn-sm btn-flat"
                        style="margin-right: 10px;width: 100px !important;font-size: 12px !important;height: 30px !important;"
                        onclick="paste()">لصق</button>
                </div>
            </li>
            <li class="share"><a class="button-header-40 rihhtbut"
                    href="{{ action('HomeController@index') }}">@lang('lang_v1.Rightclick_Home') </a></li>


            @can('sell.create')
                <li>
                    <a class="button-header-40 rihhtbut" class="button-header-40 rihhtbut"
                        href="{{ action('SellController@create') }}">@lang('lang_v1.RightClick_add_sale')</a>
                </li>
            @endcan

            @can('product.create')
                <li>
                    <a class="button-header-40 rihhtbut"
                        href="{{ action('ProductController@create') }}">@lang('lang_v1.RightClick_AddProduct')</a>
                </li>
            @endcan

            @can('purchase.create')
                <li>
                    <a class="button-header-40 rihhtbut"
                        href="{{ action('PurchaseController@create') }}">@lang('lang_v1.RightClick_purchasecreate')</a>
                </li>
            @endcan

            @can('expense.add')
                <li>
                    <a class="button-header-40 rihhtbut"
                        href="{{ action('ExpenseController@create') }}">@lang('lang_v1.RightClick_add_expense')</a>
                </li>
            @endcan


            @can('customer.view')
                <li>
                    <a class="button-header-40 rihhtbut"
                        href="{{ action('ContactController@index', ['type' => 'customer']) }}">@lang('lang_v1.RightClick_ManageClient')</a>
                </li>
            @endcan

            @can('supplier.create')
                <li>
                    <a class="button-header-40 rihhtbut"
                        href="{{ action('ContactController@index', ['type' => 'supplier']) }}">@lang('lang_v1.RightClick_ManageSupplier')</a>
                </li>
            @endcan
            {{-- <li class="link"><a href="#">--------------------------------</a></li>

				<li>
					<a class="fa fa-facebook" href="#">xxxx</a>
				</li>
				<li>
					<a class="fa fa-facebook" href="#">xxxx</a>
				</li>
				<li>
					<a class="fa fa-facebook" href="#">xxxx</a>
				</li> --}}


            <li class="link"><a href="#">--------------------------------</a></li>
            @can('business_settings.access')
                <li class="copy"><a class="button-header-40 rihhtbut"
                        href="{{ action('BusinessController@getBusinessSettings') }}">@lang('lang_v1.RightClick_Setting')</a></li>
                <li class="copy"><a class="button-header-40 rihhtbut"
                        href="{{ action('BusinessController@getbasicBusinessSettings') }}">@lang('lang_v1.RightClick_BassicSetting')</a></li>
            @endcan
            <li class="paste"><a class="button-header-40 rihhtbut"
                    href="https://www.onoo.pro/support/public">@lang('lang_v1.RightClick_Support')</a></li>
            <li class="download"><a class="button-header-40 rihhtbut"
                    href="{{ action('UserController@getProfile') }}">@lang('lang_v1.RightClick_ManageProfile')</a></li>
            <li class="trash"><a class="button-header-40 rihhtbut"
                    href="{{ action('Auth\LoginController@logout') }}">@lang('lang_v1.RightClick_Logout')</a></li>



        </ul>
    </div>
    @include('layouts.mainmenumodal')

    @include('layouts.reportmenumodal')
    <div class="wrapper thetop">
        <script type="text/javascript">
            if (localStorage.getItem("upos_sidebar_collapse") == 'true') {
                var body = document.getElementsByTagName("body")[0];
                body.className += " sidebar-collapse";
            }
        </script>
        @if (!$pos_layout)

            @include('layouts.partials.header')
            @include('layouts.partials.sidebar')
        @else
            @include('layouts.partials.header-pos')
        @endif

        @if (in_array($_SERVER['REMOTE_ADDR'], $whitelist))
            <input type="hidden" id="__is_localhost" value="true">
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div id="content-wrapper" class="@if (!$pos_layout) content-wrapper main_area @endif">
            <!-- empty div for vuejs -->
            <div id="app">
                @yield('vue')
            </div>
            @include('layouts.FullscreenMenu')
            <!-- Add currency related field-->
            <input type="hidden" id="__code" value="{{ session('currency')['code'] }}">
            <input type="hidden" id="__symbol" value="{{ session('currency')['symbol'] }}">
            <input type="hidden" id="__thousand" value="{{ session('currency')['thousand_separator'] }}">
            <input type="hidden" id="__decimal" value="{{ session('currency')['decimal_separator'] }}">
            <input type="hidden" id="__symbol_placement"
                value="{{ session('business.currency_symbol_placement') }}">
            <input type="hidden" id="__precision" value="{{ session('business.currency_precision', 2) }}">
            <input type="hidden" id="__quantity_precision" value="{{ session('business.quantity_precision', 2) }}">
            <!-- End of currency related field-->
            @can('view_export_buttons')
                <input type="hidden" id="view_export_buttons">
            @endcan
            @if (isMobile())
                <input type="hidden" id="__is_mobile">
            @endif
            @if (session('status'))
                <input type="hidden" id="status_span" data-status="{{ session('status.success') }}"
                    data-msg="{{ session('status.msg') }}">
            @endif
            @php
                // dd(user_content());
                $package = package();
                $dateDiff = 0;
                if ($package) {
                    $date1 = \Carbon::now()->format('Y-m-d');
                    // End date
                    $date2 = $package->end_date->format('Y-m-d');
                    $diff = strtotime($date2) - strtotime($date1);
                    $dateDiff = abs(round($diff / 86400));
                }
                
                $content = content();
            @endphp

            <button type="button" id="open_div_expire" class=" " style="display: none" data-toggle="modal"
                data-target="#exampleModal">
            </button>
            <button type="button" id="open_div_content" class=" " style="display: none" data-toggle="modal"
                data-target="#content_model">
            </button>
            <button type="button" id="open_div_brand_store" class=" " style="display: none"
                data-toggle="modal" data-target="#brand_store_modal">
            </button>

            <!-- Modal -->
            @if ($package)
                <div class="modal modal-danger fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> تحزير.. باقي
                                    {{ $dateDiff }} من الايام علي انتهاء الاشتراك</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> تحزير.. باقي
                                    {{ $dateDiff }} من الايام علي انتهاء الاشتراك</h4>
                            </div>
                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                <a href="{{ url('/subscription') }}" class="btn btn-info">تجديد أشتراك</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="modal  fade" id="products_requried" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                النتجات المتميزة
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form
                            action="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@hideProduct') }}"
                            method="post">
                            @csrf
                            <div class="modal-body">
                                <h4 class="modal-title">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>اسم المنتج</th>
                                                <th> السعر</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (products_requried() as $item)
                                                <tr>
                                                    <input type="hidden" id="product_id_hide" name="products_ids[]"
                                                        value="{{ $item->id }}">
                                                    <th>{{ $item->name }}</th>
                                                    <th>@format_currency($item->price_after_discount)</th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </h4>
                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info">عدم الظهور مرة
                                    اخري</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        @include('layouts.partials.confirm_password')

        @yield('content')


        <div class='scrolltop no-print'>
            <div class='scroll icon'><i class="fas fa-angle-up"></i></div>
        </div>

        @if (config('constants.iraqi_selling_price_adjustment'))
            <input type="hidden" id="iraqi_selling_price_adjustment">
        @endif

        <!-- This will be printed -->
        <section class="invoice print_section" id="receipt_section">
        </section>

    </div>
    @include('home.todays_profit_modal')

    <!-- /.content-wrapper -->

    @if (!$pos_layout)
        @include('layouts.partials.footer')
        @if (isMobile())
            @include('layouts.partials.dockermobile')
        @else
            ()
            @include('layouts.partials.docker')
        @endif

        {{-- @else
                @include('layouts.partials.footer_pos') --}}
    @endif



    <audio id="success-audio">
        <source src="{{ asset('/audio/success.ogg?v=' . $asset_v) }}" type="audio/ogg">
        <source src="{{ asset('/audio/success.mp3?v=' . $asset_v) }}" type="audio/mpeg">
    </audio>
    <audio id="error-audio">
        <source src="{{ asset('/audio/error.ogg?v=' . $asset_v) }}" type="audio/ogg">
        <source src="{{ asset('/audio/error.mp3?v=' . $asset_v) }}" type="audio/mpeg">
    </audio>
    <audio id="warning-audio">
        <source src="{{ asset('/audio/warning.ogg?v=' . $asset_v) }}" type="audio/ogg">
        <source src="{{ asset('/audio/warning.mp3?v=' . $asset_v) }}" type="audio/mpeg">
    </audio>
    </div>

    @if (!empty($__additional_html))
        {!! $__additional_html !!}
    @endif

    @include('layouts.partials.javascripts')

    <div class="modal fade view_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

    @if (!empty($__additional_views) && is_array($__additional_views))
        @foreach ($__additional_views as $additional_view)
            @includeIf($additional_view)
        @endforeach
    @endif

    <script type="text/javascript">
        document.onclick = hideMenu;
        document.oncontextmenu = rightClick;

        function hideMenu() {
            document.getElementById("contextMenu")
                .style.display = "none"
            $('#contextmenu').addClass('is-fadingOut');
        }

        function rightClick(e) {
            e.preventDefault();

            if (document.getElementById("contextMenu").style.display == "block") {
                hideMenu();
            } else {
                var menu = document.getElementById("contextMenu")
                menu.style.display = 'block';
                menu.style.left = e.pageX + "px";
                menu.style.top = e.pageY + "px";
                $('#contextmenu').addClass('is-fadingIn');
            }
        }
    </script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        let text = document.getElementById('content-wrapper').innerHTML;
        const copyContent = async () => {
            try {
                await navigator.clipboard.writeText(text);
                console.log('Content copied to clipboard');
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        }

        $(function() {
            $(document).keypress(function(e) {
                cwrite(e.which, 'Keypress event');
                if (event.which === 65 && event.shiftKey) custom_dialog_toggle('Keypress x',
                    'You opened this window by pressing x');
            });
        });

        function custom_dialog_toggle(buttons) {
            $('#dialog_state').prop("checked", !$('#dialog_state').prop("checked"));
        }

        $(function() {
            $(document).keypress(function(e) {
                cwrite(e.which, 'Keypress event');
                if (event.which === 83 && event.shiftKey) custom_dialog_toggle_report('Keypress x',
                    'You opened this window by pressing x');
            });
        });

        function custom_dialog_toggle_report(buttons) {
            $('#dialog_state_report').prop("checked", !$('#dialog_state_report').prop("checked"));
        }

        function cwrite(str, title) {
            var ce = $('#console');
            var sg = "<p>";
            if (typeof title !== 'undefined') sg = sg + "<em>" + title + "</em> ";
            sg = sg + str + "</p>";
            ce.prepend(sg);
            //if(ce.children("p").length>6) ce.children("p").first().remove();
        }



        @if ($dateDiff <= '2' && is_admin())
            var is_modal_show = sessionStorage.getItem('alreadyShow');
            // alert(is_modal_show);
            if (is_modal_show != 'alredy shown') {
                $('#open_div_expire').click();
                sessionStorage.setItem('alreadyShow', 'alredy shown');
            }
            // $('#open_div_expire').attr('disabled');
        @endif
        @if (!empty(content()) && user_content() == false)
            $('#open_div_content').click();
        @endif
        $('#hide_model').on('click', function() {
            $.ajax({
                type: 'POST',
                url: '/contents/content-hide',
                dataType: 'json',
                data: {
                    content_id: $('#content_id').val()
                },
                success: function(data) {
                    $('#content_model').modal('hide');
                }
            });

        });

        //hide product unique for user dont show again
        $('#hide_products').on('click', function() {
            $.ajax({
                type: 'POST',
                url: '/products-hideProduct',
                dataType: 'json',
                data: {
                    product_ids: [$('#product_id_hide').val()]
                },
                success: function(data) {
                    $('#products_requried').modal('hide');
                }
            });

        });

        function copy() {
            // fix Firefox losing focus when button is clicked  
            document.getElementById("content-wrapper").focus();

            // catch any unforeseen errors  
            try {
                var success = document.execCommand("copy");
                // output whether or not copy was successful  
                // success ? alert("copy successful") : alert("copy unsuccessful");
            } catch (e) {
                alert("An error has occurred");
            }
        }

        function paste() {
            // document.getElementById("content-wrapper").focus();


            var e = jQuery.Event("keydown");
            e.ctrlkey = true; // control key pressed
            e.which = 86; // # v code value
            $(document).trigger(e); // trigger event on document

        }


        // insert location of user type agent
        // setInterval(() => {
        //     $.ajax({
        //         type: 'POST',
        //         url: '{{ route('agent.storeLocation') }}',
        //         dataType: 'json',

        //         success: function(data) {
        //             $('#content_model').modal('hide');
        //         }
        //     });
        // }, 120000);
    </script>

    <script>
        @if (count(products_requried()) > 0)
            $('#products_requried').modal('show');
        @endif
        @if (enable_view_brand_store())
            $('#brand_store_modal').modal('show');
        @endif
    </script>

    {{-- content-wrapper
 --}}{{-- dockpc --}}



    @include('layouts.partials.ifram_brand_store')
    <div class="modal  fade" id="content_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        محتوي جديد
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="content_id" value="{{ $content->id }}">
                    {!! $content->description !!}
                </div>
                <div class="modal-footer">

                    <div class="row">
                        <div class="col-sm-6">
                            <button type="button"
                                class="btn Btn-Brand Btn-bx btn-block btn-defualt text-black"data-dismiss="modal">{{ __('messages.close') }}</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit"
                                id="hide_model"class="btn Btn-Brand btn-block Btn-bx btn-primary">عدم الظهور
                                مرةاخري</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
