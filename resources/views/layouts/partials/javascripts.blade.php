<script type="text/javascript">
    base_path = "{{ url('/') }}";
    //used for push notification
    APP = {};
    APP.PUSHER_APP_KEY = '{{ config('broadcasting.connections.pusher.key') }}';
    APP.PUSHER_APP_CLUSTER = '{{ config('broadcasting.connections.pusher.options.cluster') }}';
    APP.INVOICE_SCHEME_SEPARATOR = '{{ config('constants.invoice_scheme_separator') }}';
    //variable from app service provider
    APP.PUSHER_ENABLED = '{{ $__is_pusher_enabled }}';
    @auth
    @php
        $user = Auth::user();
    @endphp
    APP.USER_ID = "{{ $user->id }}";
    @else
        APP.USER_ID = '';
    @endauth
</script>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js?v=$asset_v"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js?v=$asset_v"></script>
<![endif]-->
<script src="{{ asset('js/vendor.js?v=' . $asset_v) }}"></script>

@if (file_exists(public_path('js/lang/' . session()->get('user.language', config('app.locale')) . '.js')))
    <script src="{{ asset('js/lang/' . session()->get('user.language', config('app.locale')) . '.js?v=' . $asset_v) }}">
    </script>
@else
    <script src="{{ asset('js/lang/en.js?v=' . $asset_v) }}"></script>
@endif
@php
    $business_date_format = session('business.date_format', config('constants.default_date_format'));
    $datepicker_date_format = str_replace('d', 'dd', $business_date_format);
    $datepicker_date_format = str_replace('m', 'mm', $datepicker_date_format);
    $datepicker_date_format = str_replace('Y', 'yyyy', $datepicker_date_format);
    
    $moment_date_format = str_replace('d', 'DD', $business_date_format);
    $moment_date_format = str_replace('m', 'MM', $moment_date_format);
    $moment_date_format = str_replace('Y', 'YYYY', $moment_date_format);
    
    $business_time_format = session('business.time_format');
    $moment_time_format = 'HH:mm';
    if ($business_time_format == 12) {
        $moment_time_format = 'hh:mm A';
    }
    
    $common_settings = !empty(session('business.common_settings')) ? session('business.common_settings') : [];
    
    $default_datatable_page_entries = !empty($common_settings['default_datatable_page_entries']) ? $common_settings['default_datatable_page_entries'] : 25;
@endphp

<script>
    Dropzone.autoDiscover = false;
    moment.tz.setDefault('{{ Session::get('business.time_zone') }}');
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @if (config('app.debug') == false)
            $.fn.dataTable.ext.errMode = 'throw';
        @endif
    });

    var financial_year = {
        start: moment('{{ Session::get('financial_year.start') }}'),
        end: moment('{{ Session::get('financial_year.end') }}'),
    }
    @if (file_exists(public_path('AdminLTE/plugins/select2/lang/' . session()->get('user.language', config('app.locale')) . '.js')))
        //Default setting for select2
        $.fn.select2.defaults.set("language", "{{ session()->get('user.language', config('app.locale')) }}");
    @endif

    var datepicker_date_format = "{{ $datepicker_date_format }}";
    var moment_date_format = "{{ $moment_date_format }}";
    var moment_time_format = "{{ $moment_time_format }}";

    var app_locale = "{{ session()->get('user.language', config('app.locale')) }}";

    var non_utf8_languages = [
        @foreach (config('constants.non_utf8_languages') as $const)
            "{{ $const }}",
        @endforeach
    ];

    var __default_datatable_page_entries = "{{ $default_datatable_page_entries }}";

    var __new_notification_count_interval = "{{ config('constants.new_notification_count_interval', 60) }}000";
</script>

@if (file_exists(public_path('js/lang/' . session()->get('user.language', config('app.locale')) . '.js')))
    <script src="{{ asset('js/lang/' . session()->get('user.language', config('app.locale')) . '.js?v=' . $asset_v) }}">
    </script>
@else
    <script src="{{ asset('js/lang/en.js?v=' . $asset_v) }}"></script>
@endif

<script src="{{ asset('js/functions.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/common.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/app.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/help-tour.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/documents_and_note.js?v=' . $asset_v) }}"></script>

<!-- TODO -->
@if (file_exists(public_path('AdminLTE/plugins/select2/lang/' . session()->get('user.language', config('app.locale')) . '.js')))
    <script
        src="{{ asset('AdminLTE/plugins/select2/lang/' . session()->get('user.language', config('app.locale')) . '.js?v=' . $asset_v) }}">
    </script>
@endif
@php
    $validation_lang_file = 'messages_' . session()->get('user.language', config('app.locale')) . '.js';
@endphp
@if (file_exists(public_path() . '/js/jquery-validation-1.16.0/src/localization/' . $validation_lang_file))
    <script src="{{ asset('js/jquery-validation-1.16.0/src/localization/' . $validation_lang_file . '?v=' . $asset_v) }}">
    </script>
@endif

@if (!empty($__system_settings['additional_js']))
    {!! $__system_settings['additional_js'] !!}
@endif
@yield('javascript')

@if (Module::has('Essentials'))
    @includeIf('essentials::layouts.partials.footer_part')
@endif
<script src="{{ asset('js/feather.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var locale = "{{ session()->get('user.language', config('app.locale')) }}";
        var isRTL =
            @if (in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')))
                true;
            @else
                false;
            @endif

        $('#calendar').fullCalendar('option', {
            locale: locale,
            isRTL: isRTL
        });

        feather.replace();
    });
    $(document).ready(function() {
        $(window).on('load', function() {


            // $(".dataTables_wrapper").each(function() {

            //     // move datatable buttons
            //     $(this).find('.dataTables_filter').css('float', IS_RTL ? 'left' : 'right');
            //     $(this).find('.dataTables_filter input').removeClass('input-sm');
            //     $(this).find(".row").prepend($(this).find('.dataTables_filter'));

            //     // move select length datatble
            //     $(this).find('.dataTables_length select').css('float', IS_RTL ? 'left' :
            //         'right');
            //     $(this).find('.dataTables_length select').css('height', '35px');
            //     $(this).find('.dataTables_length select').css('width', '100%');
            //     var selectContainer = document.createElement('div');
            //     selectContainer.className = "dataTables_length_select_container";
            //     $(selectContainer).append($(this).find('.dataTables_length select'));
            //     $(this).find(".row").prepend(selectContainer);
            //     $(this).find(".row").removeClass('margin-bottom-20');

            //     // move datatable buttons
            //     $(this).find('.dataTables_length_select_container').css('float', IS_RTL ?
            //         'left' : 'right');
            //     $(this).find('.dataTables_length_select_container').addClass('col-md-2')
            //     $(this).find('.dataTables_filter').addClass('col-md-3')
            //     $(this).find('.dt-buttons').css('float', IS_RTL ? 'right' : 'left');
            //     $(this).find('.dt-buttons').css('text-align', IS_RTL ? 'right' : 'left');
            //     $(this).find('.dt-buttons').addClass('col-md-7');
            //     $(this).find('.dt-buttons a').css('margin', '5px 0px');
            //     // $(this).find('.dt-buttons').css('padding', '0px');
            //     $(this).find(".row").prepend($(this).find('.dt-buttons'));

            //     @if (isMobile())
            //         $(this).find('.dataTables_length_select_container').css('float', 'none');
            //         $(this).find('.dataTables_filter   input').css('width',
            //             '300px');
            //         $(this).find('.dataTables_filter   input').css('margin',
            //             '0px');
            //     @endif
            //     // remove old div
            //     $(this).find('.dataTables_length').remove();

            // });

            $('.box-tools .btn-primary').removeClass('btn-block');
            // $('.box .box-header').removeClass('box-header');
            // $('.dt-buttons').prepend($('.box-tools button.btn-modal'));
            // $('.dt-buttons').prepend($('.box-tools a.btn-primary'));

        });
    });



    $(document).ready(function() {
        $('#global_search').on('keyup', function(e) {
            e.preventDefault();
            var query = $(this).val();
            var search_type = $('#search_type').val();
            $.ajax({
                url: "{{ route('get.globalSearch') }}",
                type: "GET",
                data: {
                    'search': query,
                    'search_type': search_type
                },
                success: function(data) {
                    if (data && query.length > 0) {
                        $('#search_list').removeClass('hide');
                        $('#search_list').html(data);
                        $('#search_list').css('height', '450px');
                        $('#search_list').css('overflow', 'auto');
                    } else {
                        $('#search_list').addClass('hide');
                    }

                },
            });
        });
        $('#global_search2').on('keyup', function(e) {
            e.preventDefault();
            var query = $(this).val();
            var search_type = $('#search_type2').val();
            $.ajax({
                url: "{{ route('get.globalSearch') }}",
                type: "GET",
                data: {
                    'search': query,
                    'search_type': search_type
                },
                success: function(data) {
                    if (data && query.length > 0) {
                        $('#search_list2').removeClass('hide');
                        $('#search_list2').html(data);
                        $('#search_list2').css('height', '450px');
                        $('#search_list2').css('overflow', 'auto');
                    } else {
                        $('#search_list2').addClass('hide');
                    }
                },
            });
        });

        $('input.go_fast_search').on('keyup', function(e) {
            e.preventDefault();
            var query = $(this).val();
            $.ajax({
                url: "{{ route('get.goFastSearch') }}",
                type: "GET",
                data: {
                    'search': query,
                },
                success: function(data) {

                    if (data.length > 0 && query.length > 0) {
                        $('.go_fast_list').removeClass('hide');
                        $('.go_fast_list').html(data);
                        $('.go_fast_list').css('height', 'auto');
                        $('.go_fast_list').css('overflow', 'auto');
                    } else {
                        $('.go_fast_list').addClass('hide');
                    }

                },

            });
        });
    });
    $(document).on('click', '.edit_contact_button', function(e) {
        e.preventDefault();
        $('div.contact_modal_home').load($(this).attr('href'), function() {
            $(this).modal('show');
        });
    });
    $(document).on('click', 'a.view_product_modal', function(e) {
        e.preventDefault();
        // alert($(this).attr('href'))
        $.ajax({
            url: $(this).attr('href'),
            dataType: 'html',
            success: function(result) {
                $('#view_product_modal_home')
                    .html(result)
                    .modal('show');
                __currency_convert_recursively($('#view_product_modal_home'));
            },
        });
    });



    /**
     * check password confirmation or no to remove modal
     * */
    $(document).on('click', 'button#confirm_password_', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('business.confirmPasswordSetting') }}",
            dataType: 'html',
            method: 'POST',
            data: {
                'password': $(this).parents().find('#password').val(),
                'page_type': $(this).parents().find('#page_type').val(),
            },
            success: function(result) {
                // alert(result == 'true')
                if (result == 'true') {
                    $('#confirm_password').modal('hide');
                } else {
                    $('#confirm_password_setting').parents().find('div#msgErr').html('');
                    $('#confirm_password_setting').parents().find('div#msgErr').append(
                        'كلمة المرور غير صحيحة');
                }
            },
        });
    });



    // define a function to scroll to the top of the div
    const scrollToTop = (table) => {
        // get the div element by its id
        const div = document.getElementById(table);
        alert(table);
        // smooth scroll to the top of the div
        div.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }




    /**
     * close global search div
     * 
     */
    $('#close_global_search').on('click', function() {
        $('#search_list').addClass('hide');
    });


    $(document).ready(function() {
        $(window).on('load', function() {
            /***
             * send auto messages to busienss
             * */
            // setInterval(() => {
            $.ajax({
                type: 'GET',
                url: "{{ action('\Modules\Superadmin\Http\Controllers\WhatsappNotificationController@checkWhatsappMessage') }}",
                dataType: 'json',
                success: function(result) {},
                error: function(result) {
                    toastr.error(result.error);
                }
            });
            // }, 120000);
        });
    });
</script>

<script>
    // Set the date we're counting down to
    var date = $('#date_from').val();
    var countDownDate = new Date(date).getTime()
    // alert(date)

    // Update the count down every 1 second
    if (countDownDate.lenght > 0) {
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }, 1000);
    }
</script>
