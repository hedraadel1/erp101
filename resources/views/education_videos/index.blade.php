@extends('layouts.guest')
<style>
    .rowdisplay {
        display: inline-block;
    }

    @media only screen and (min-width: 768px) {
        .rowdisplay {
            display: flex;
        }
    }

    .textborder {
        border-top-right-radius: 10px !important;
        border-top-left-radius: 10px !important;
        border-bottom-left-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
        border-color: #a3a4a5 !important;
    }

    .button-gotovideos-BR {
        font-weight: 900 !important;
        margin-bottom: 15px !important;
        height: 30px !important;
        background-color: #07657a !important;
        letter-spacing: 13px !important;
        box-shadow: rgba(45, 35, 66, 0.4) 0 7px 7px, rgba(45, 35, 66, 0.3) 0 7px 13px -1px, #07657a 0 -3px 0 inset !important;
        WIDTH: 100% !important;
    }

    .btn-videos {
        background: #0a9fc0;
        color: white !important;
        border-color: #000000;
        font-family: 'droid';
    }

    .box-videos {
        position: relative;
        background: #f5f7f8;
        border-top: 10px groove #00a3c7 !important;
        border-bottom-right-radius: 9px !important;
        border-bottom-left-radius: 9px !important;
        border-top-left-radius: 9px;
        border-top-right-radius: 9px;
        border-bottom: 3px solid #259dcf;
        border-right: 3px solid #259dcf;
        border-left: 3px solid #259dcf;
        width: 100%;
        transform: translate3d(0, 0, 0);
    }

    @import url(//fonts.googleapis.com/css?family=Lato:300:400);

    body {
        margin: 0;
    }

    .header {
        position: relative;
        text-align: center;
        background: linear-gradient(60deg, rgba(84, 58, 183, 1) 0%, rgba(0, 172, 193, 1) 100%);
        color: white;
    }

    .logo {
        width: 50px;
        fill: white;
        padding-right: 15px;
        display: inline-block;
        vertical-align: middle;
    }

    .inner-header {
        height: 12vh;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .flex {
        /*Flexbox for containers*/
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .waves {
        position: relative;
        width: 100%;
        height: 15vh;
        margin-bottom: -7px;
        /*Fix for safari gap*/
        min-height: 100px;
        max-height: 150px;
    }

    .content {
        position: relative;
        height: 20vh;
        text-align: center;
        background-color: white;
    }

    /* Animation */

    .parallax>use {
        animation: move-forever 25s cubic-bezier(.55, .5, .45, .5) infinite;
    }

    .parallax>use:nth-child(1) {
        animation-delay: -2s;
        animation-duration: 7s;
    }

    .parallax>use:nth-child(2) {
        animation-delay: -3s;
        animation-duration: 10s;
    }

    .parallax>use:nth-child(3) {
        animation-delay: -4s;
        animation-duration: 13s;
    }

    .parallax>use:nth-child(4) {
        animation-delay: -5s;
        animation-duration: 20s;
    }

    @keyframes move-forever {
        0% {
            transform: translate3d(-90px, 0, 0);
        }

        100% {
            transform: translate3d(85px, 0, 0);
        }
    }

    /*Shrinking for mobile*/
    @media (max-width: 768px) {
        .waves {
            height: 40px;
            min-height: 40px;
        }

        .content {
            height: 30vh;
        }

        h1 {
            font-size: 24px;
        }
    }

    .blackline {
        border-top: 3px solid #000;
        border-bottom: 3px solid #000;
    }

    .newbox {
        border-radius: 5px;
        newbox-shadow: 0px 30px 40px -20px var(--grayishBlue);
        padding: 3px;
        justify-content: center;
        display: flex;
        place-items: center;
        background: white;
    }

    .filter {
        border-radius: 5px;
        newbox-shadow: 0px 30px 40px -20px var(--grayishBlue);
        padding: 10px;
        background: white;
    }

    .content_ {
        background-color: #ffffff;
        padding: 15px 15px 0 15px;
    }
</style>
<!--Hey! This is the original version
of Simple CSS Waves-->

<div style="margin-top:60px" class="header">

    <!--Content before waves-->
    <div style="padding: unset !important;
    width: 100%;" class="inner-header flex">
        <section style="width: 90%;padding:unset !important" class="content-header text-center" id="top">
            <div class="newbox blackline">
                <h3 style="margin-top: 10px;margin-bottom: 10px;font-size: 14px;font-family: 'droid';color: #0a9ec0;">
                    المركز التعليمي
                    لبراند</h3>

            </div>
        </section>
    </div>
    <section style="width: 90%;padding:unset !important;display:inline-block;" class="content-header text-center"
        id="top">
        <div style="height: 70px;background: #d3dce2;font-family: 'droid';display:contents" class="newbox blackline">
            <h5 style="margin-top: 10px;margin-bottom: 10px;font-family: 'droid';line-height: 25px;color: #ffffff;">
                أهلاً وسهلاً بك فى
                مركز براند التعليمي ، تستطيع من خلال ذلك القسم مشاهدة وتعلم كل ما يخص براند ، فى حالة وجود اى مشاكل او
                اى استفسارات من فضلك تواصل معنا </h5>

        </div>
    </section>
    <!--Waves Container-->
    <div>
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="#f5f8fa" />
            </g>
        </svg>
    </div>
    <!--Waves end-->

</div>
<!--Header ends-->

<!--Content ends-->
@section('title', 'الشروحات')
@section('content')
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <div class="content_">

        <section style="padding: 15px 15px 0 15px;">

            <section class="filter text-{{ isRtl() ? 'right' : 'left' }}">
                <div class="form-group">
                    <form action="{{ action('EducationVideoController@index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <a href="{{ action('HomeController@index') }}" type="submit"
                                    style="margin-top: 4px;border-radius: 10px;background: #0a9fc0;border-color: #bcdbec;color: fff;font-family: 'droid';  padding: 6px 3px !important;font-size: 12px;height: 40px;padding-top: 11px !important;width:100%;"
                                    class="btn"><i class="fa fa-window-restorer"></i> سيستم براند</a>
                            </div>

                            <div class="col-md-4">
                                <a style="margin-top: 4px;border-radius: 10px;font-family: 'droid';  padding: 6px 3px !important;font-size: 12px;height: 40px;padding-top: 11px !important;width:100%;    border-color: #0a9fc0 !important;
                                border: dashed 2px;
                                border-style: groove;border-radius: 13px;"
                                    href="{{ action('EducationVideoController@index') }}" class="btn bg-gray">المركز
                                    التعليمي</a>
                            </div>

                            <div class="col-md-4">
                                <a href="{{ action('\Modules\Cms\Http\Controllers\CmsController@index') }}" type="submit"
                                    style="margin-top: 4px;border-radius: 10px;background: #0a9fc0;border-color: #bcdbec;color: fff;font-family: 'droid';  padding: 6px 3px !important;font-size: 12px;height: 40px;padding-top: 11px !important;width:100%;"
                                    class="btn">الصفحة الرئيسية</a>
                            </div>
                        </div>
                        <div class="row rowdisplay">
                            <div style="margin-top: 7px;    padding-top: 5px;    border-color: #0a9fc0 !important;
                            border: dashed 2px;
                            border-style: groove;
                            text-align: center;
                            display: block;
                            background: #d2d6de;
                            border-radius: 13px;padding-bottom: 0px;"
                                class="col-sm-5">
                                {!! Form::label('vedio_category', 'الاقسام ') !!}
                                {!! Form::select('category_id', $categories, request()->category_id, [
                                    'class' => 'form-control select2 textborder',
                                    'placeholder' => 'اختر القسم المراد البحث بداخلة او اتركة فارغاً',
                                ]) !!}
                            </div>
                            <div class="col-sm-2">

                            </div>
                            <div style="margin-top: 7px;    padding-top: 5px;    border-color: #0a9fc0 !important;
                            border: dashed 2px;
                            border-style: groove;
                            text-align: center;
                            display: block;
                            background: #d2d6de;
                            border-radius: 13px;padding-bottom: 0px;"
                                class="col-sm-5">
                                {!! Form::label('vedio_category', 'بحث ') !!}
                                {!! Form::text('search', request()->search, [
                                    'class' => 'form-control textborder',
                                    'placeholder' => 'قم هنا بكتابة اسم الشرح المطلوب',
                                ]) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit"
                                    style="background: #0a9fc0;border-color: #010101;color: #fff;font-family: 'droid';  padding: 6px 3px !important;font-size: 12px;height: 40px;padding-top: 11px !important;width:100%;margin-top: 10px;border-radius: 10px;"
                                    class="btn"><i class="fa fa-filter"></i> بحث</button>
                            </div>

                        </div>

                    </form>
                </div>
            </section>

            <section>
                @foreach ($category_videos as $cat)
                    <div style="    border: 5px #2d9db5;
                    border-style: groove;
                    border-radius: 19px;
                    padding: 0px 0px 10px 0px;"
                        class="row  text-{{ isRtl() ? 'right' : 'left' }}">
                        <div style="height: 50px;padding-top: 0px;border-radius: 10px 10px 0px 0px;"
                            class="col-sm-12 btn btn-block button-43">
                            <b style="font-family: 'droid';font-size: 16px;color: white;" class="h2">
                                {{ $cat->name }}
                            </b>
                        </div>
                        @foreach ($cat->videos->take(4) as $item)
                            <div class="col-lg-3 col-md-4 col-sm-12  "
                                style="padding-top: 15px ;float:{{ isRtl() ? 'right' : 'left' }}">
                                <div class="box-videos">
                                    @if ($item->video)
                                        <video width="100%" height="180px" class="demo cursor"
                                            style="border: 1px solid #fafafa;" controls>
                                            <source src="{{ asset($item->video) }}" type="video/mp4">
                                        </video>
                                    @else
                                        <iframe width="100%" height="180px"
                                            src="//www.youtube.com/embed/{{ $item->video_id }}" frameborder="0"
                                            allowfullscreen></iframe>
                                        {{-- <iframe src="{{ $item->video_url }}" frameborder="0"></iframe> --}}
                                    @endif

                                    <a role="button" class=" btn-modal"
                                        data-href="{{ action('EducationVideoController@show', [$item->id]) }}"
                                        data-container=".education_category_modal">
                                        <div class="box-body" style="padding: 10px;">
                                            <h3
                                                style="color:#0e94b1;height: 50px;overflow: hidden;text-align: center;
                                                font-family: 'droid';font-size: 15px;font-family: 'droid';">
                                                {{ $item->name }}</h3>

                                            <p class="description"
                                                style="color:gray;height: 100px;overflow: hidden;text-align: center;
                                            font-family: 'droid'; font-size: 11px;line-height: 18px;">
                                                {{ $item->description }}
                                            </p>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        @endforeach
                        <div class="buttons text-center">
                            <a style="font-weight: 900;margin-bottom: -15px;margin-top: 15px;  border-radius: 0px 0px 15px 15px !important;"
                                href="{{ route('education_videos.showCategoryVideos', $cat->id) }}"
                                class="button-gotovideos">اضغط هنا لعرض جميع فيديوهات {{ $cat->name }}</a>
                        </div>
                    </div>


                    <div style="margin-top: 15px;" class="row">
                        <div class=" col-sm-2 ">

                        </div>
                        <div class=" col-sm-8 ">
                            <a class="button-gotovideos-br button-gotovideos"> BRAND - ERP </a>
                        </div>
                        <div class=" col-sm-2 ">

                        </div>
                    </div>
                @endforeach
                {{ $category_videos->appends(request()->query())->render() }}
            </section>

        </section>

    </div>

    <div class="modal fade education_category_modal" id="education_category_modal" tabindex="-1" role="dialog"
        aria-labelledby="gridSystemModalLabel"></div>
@endsection

@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>

    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        $(document).on('click', '.btn-modal', function(e) {
            e.preventDefault();
            var container = $(this).data('container');
            // alert(container);
            $.ajax({
                url: $(this).data('href'),
                dataType: 'html',
                success: function(result) {
                    $(container)
                        .html(result)
                        .modal('show');
                },
            });
        });
    </script>
@endsection
