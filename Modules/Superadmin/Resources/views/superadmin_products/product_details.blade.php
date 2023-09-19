@extends('layouts.app')
@section('title', $product->name)
@section('css')
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        img {
            vertical-align: middle;
        }

        /* Position the image container (needed to position the left and right arrows) */
        .container {
            position: relative;
        }

        /* Hide the images by default */
        .mySlides {
            display: none;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #000;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* Six columns side by side */
        .column {
            /* float: left; */
            width: 16.66%;
        }

        /* Add a transparency effect for thumnbail images */
        .demo {
            opacity: 0.6;
        }

        .row_image:after {
            content: "";
            display: table;
            clear: both;
        }

        .active,
        .demo:hover {
            opacity: 1;
        }
    </style>

@endsection
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">{{ $product->name }}</h3>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="box" style="padding: 10px">
                    <b class="h3 mb-5">معرض الصور :</b>
                    <div class="row">
                        <div class="media col-md-12 ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="      height: 300px;  border: 1px dashed;padding: 10px;text-align: center;">
                                        @foreach ($product->getAllImagesAttribute() as $key => $get)
                                            @php
                                                $type = explode('.', $get);
                                            @endphp
                                            <div class="mySlides">
                                                <div class="numbertext">{{ $loop->iteration }} /
                                                    {{ count($product->getAllImagesAttribute()) }}</div>
                                                @if ($type['1'] == 'mp4')
                                                    <video width="100%" height="280px" style="border: 1px solid #fafafa;"
                                                        controls>
                                                        <source src="{{ asset($get) }}" type="video/mp4">
                                                    </video>
                                                @else
                                                    <img src="{{ asset($get) }}" style="width:auto;height: 280px;">
                                                @endif
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="row_image" style="display: flex;overflow:auto">
                                        @foreach ($product->getAllImagesAttribute() as $key => $get)
                                            @php
                                                $type = explode('.', $get);
                                            @endphp
                                            <div class="column">
                                                @if ($type['1'] == 'mp4')
                                                    <video onclick="currentSlide({{ $loop->iteration }})" width="100%"
                                                        height="120px" class="demo cursor"
                                                        style="border: 1px solid #fafafa;" controls>
                                                        <source src="{{ asset($get) }}" type="video/mp4">
                                                    </video>
                                                @else
                                                    <img width="120" height="120" class="demo cursor"
                                                        src="{{ asset($get) }}"
                                                        onclick="currentSlide({{ $loop->iteration }})" alt="The Woods">
                                                @endif

                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box" style="padding: 10px">
                    <div class="row">

                        <div class="desc p-2 col-md-12">
                            <br>
                            <label for="">{{ __('lang_v1.description') }} :</label>
                            {!! $product->description !!}
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="" style="padding: 10px">
                    <div class="buttons ">
                        <div class="row">

                            @if (empty($business_product) &&
                                    optional($business_product)->paid_type != 'day' &&
                                    !in_array($product->code, $product_cods))
                                <div class="col-md-6">
                                    <a role="button" id="used_to_day" data-code="{{ $product->code }}"
                                        data-amount="{{ $product->price_after_discount }}" data-id="{{ $product->id }}"
                                        class="btn Btn-Brand Btn-bx btn-info btn-block">تجربة لمدة يوم</a>
                                </div>
                            @endif
                       
                            <div
                                class="{{ (empty($business_product) && optional($business_product)->paid_type != 'day') &&  !in_array($product->code, $product_cods) ? 'col-md-6' : 'col-md-12' }}">
                                <a role="button" id="used_ultimate" data-code="{{ $product->code }}"
                                    data-amount="{{ $product->price_after_discount }}" data-id="{{ $product->id }}"
                                    class="btn Btn-Brand Btn-bx btn-success btn-block">شراء دائم</a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- /.content -->
@stop
@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.3.2/swiper-bundle.min.js"
        integrity="sha512-+z66PuMP/eeemN2MgRhPvI3G15FOBbsp5NcCJBojg6dZBEFL0Zoi0PEGkhjubEcQF7N1EpTX15LZvfuw+Ej95Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>

    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        // Set the date we're counting down to
        var date = $('#date_from').val();
        var countDownDate = new Date(date).getTime()
        // alert(date)

        // // Update the count down every 1 second
        // var x = setInterval(function() {

        //     // Get today's date and time
        //     var now = new Date().getTime();

        //     // Find the distance between now and the count down date
        //     var distance = countDownDate - now;

        //     // Time calculations for days, hours, minutes and seconds
        //     var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        //     var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        //     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        //     var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        //     // Output the result in an element with id="demo"
        //     document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
        //         minutes + "m " + seconds + "s ";

        //     // If the count down is over, write some text 
        //     if (distance < 0) {
        //         clearInterval(x);
        //         document.getElementById("demo").innerHTML = "EXPIRED";
        //     }
        // }, 1000);
    </script>

    <script>
        $('#used_to_day').on('click', function() {

            var id = $(this).data('id');
            var code = $(this).data('code');
            var amount = $(this).data('amount');
            $.ajax({
                url: "{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@storeProduct') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    'product_id': id,
                    'product_code': code,
                    'amount': amount,
                    'type': 'to_day'
                },
                success: function(res) {
                    toastr.success(res.msg);
                    $('#used_to_day').attr('disabled', 'true');
                },
            });
        });
        $('#used_monthly').on('click', function() {
            var id = $(this).data('id');
            var code = $(this).data('code');
            var amount = $(this).data('amount');
            $.ajax({
                url: "{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@payProduct') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    'product_id': id,
                    'product_code': code,
                    'amount': amount,
                    'type': 'monthly'
                },
                success: function(res) {
                    window.location.reload();
                },
            });
        });
        $('#used_ultimate').on('click', function() {
            var id = $(this).data('id');
            var code = $(this).data('code');
            var amount = $(this).data('amount');
            $.ajax({
                url: "{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@payProduct') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    'product_id': id,
                    'product_code': code,
                    'amount': amount,
                    'type': 'ultimate'
                },
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.msg);
                    } else {
                        toastr.error(res.msg);
                    }
                },
                error: function(res) {
                    toastr.error(res.msg);
                },
            });
        });

        let slideIndex = 1;
        showSlides(slideIndex);

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("demo");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>
@endsection
