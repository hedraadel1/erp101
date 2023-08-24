<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@include('layouts.partials.css')
<style>
    .ribbon-info {
        background: red;
    }

    .ribbon-vertical-right {
        clear: none;
        padding: 0 5px;
        height: 70px;
        width: 30px;
        line-height: 70px;
        text-align: center;
        top: -2px;
        left: auto;
        right: 20px;
        position: absolute;
    }

    .ribbon-bookmark.ribbon-vertical-right:before {
        top: 100%;
        left: 0;
        margin-top: -14px;
        border-right: 15px solid red;
        border-bottom: 10px solid transparent;
    }

    .discount:before {
        top: 100%;
        left: 0;
        margin-top: -14px;
        border-right: 15px solid red;
        border-bottom: 10px solid transparent;
    }

    .ribbon-bookmark:before {
        position: absolute;
        top: 0;
        left: 100%;
        display: block;
        width: 0;
        height: 0;
        content: "";
        border: 15px solid red;
        border-right: 10px solid transparent;
    }

    .discount:before {
        position: absolute;
        top: 14px;
        left: 100%;
        display: block;
        width: 0;
        height: 33px;
        content: "";
        border: 15px solid red;
        border-right: 10px solid transparent;
    }

    .discount:after {
        position: absolute;
        top: 0px;
        right: 100%;
        display: block;
        width: 0;
        height: 33px;
        content: "";
        border: 15px solid red;
        border-left: 10px solid transparent;
    }

    .discount {
        background: red;
    }
</style>
<section class="content">

    <div class="row">
        @foreach ($products as $item)
            <div class="col-md-3  ">
                <div class="box">
                    <div
                        style="height: 150px;background-position: center;background-repeat: no-repeat;background-size: cover;;background-image: url({{ $item->image_url }})">
                    </div>
                    @if ($item->is_distinct == '1')
                        <div class="ribbon ribbon-bookmark ribbon-vertical-right ribbon-info">
                            <i class="fas fa-star text-white"></i>

                        </div>
                    @endif
                    @if ($item->price == 0)
                        <span class="w3-tag w3-green w3-padding"
                            style="position: absolute;top: 0px;left:-2px;padding: 5px;">
                            FREE
                        </span>
                    @endif
                    @if (isset($item->get_product_discount($item->id)->discount))
                        @if ($item->get_product_discount($item->id)->is_limited_offer == 1)
                            @if (
                                $item->get_product_discount($item->id)->date_from <= date('Y-m-d') &&
                                    $item->get_product_discount($item->id)->date_to >= date('Y-m-d'))
                                <span class="w3-tag  discount"
                                    style="position: absolute;top: 117px;width: 93%;left:12px;padding: 5px;">
                                    {{-- خصم: --}}
                                    <small>
                                        @if ($item->get_product_discount($item->id)->type == 'fixed')
                                            <small> @format_currency($item->get_product_discount($item->id)->discount)</small>
                                        @else
                                            {{ round($item->get_product_discount($item->id)->discount, 0) }}%
                                        @endif
                                        | <span id="demo"></span>

                                        <input type="hidden" id="date_from"
                                            value="{{ $item->get_product_discount($item->id)->date_to }}">
                                    </small>
                                </span>
                            @endif
                        @else
                            <span
                                class="w3-tag w3-red discount"style="padding: 5px;position: absolute;top: 20px;width: 25%;left: -4px;rotate: -43deg;">
                                {{-- style="position: absolute;top: 117px;width: 93%;left:12px;padding: 5px;"> --}}
                                {{-- خصم: --}}

                                @if ($item->get_product_discount($item->id)->type == 'fixed')
                                    <small> @format_currency($item->get_product_discount($item->id)->discount)</small>
                                @else
                                    {{ round($item->get_product_discount($item->id)->discount, 0) }}%
                                @endif

                            </span>
                        @endif
                    @endif


                    <div class="box-body " style="padding: 7px">
                        <h4 style="    height: 50px;overflow:hidden">{{ $item->name }}</h4>
                        @if ($item->price > 0)
                            <span class="new ">
                                <b class="h3"> @format_currency($item->price_after_discount)</b>
                            </span>
                            @if (isset($item->get_product_discount($item->id)->discount))
                                <span class="old">
                                    <s> @format_currency($item->price)</s>
                                </span>
                            @endif
                        @endif
                    </div>
                    <div class="box-footer">
                        <a href="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@productDetails', $item->id) }}"
                            class="btn Btn-Brand Btn-bx btn-info btn-block">التفاصيل</a>
                        {{-- <a href="" class="btn Btn-Brand Btn-bx btn-primary width-120">شراء</a> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade superadmin_products_show" id="products_show" tabindex="-1" role="dialog"
        aria-labelledby="gridSystemModalLabel"></div>
</section>

@include('layouts.partials.javascripts')

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    // Set the date we're counting down to
    var date = $('#date_from').val();
    var countDownDate = new Date(date).getTime()

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
