@extends('layouts.appnomenu')

<head>
    <meta charset="UTF-8">
    <title>اعدادات سيستم براند الاساسية</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>

    <link rel="stylesheet" href="{{ asset('css/wizardstyle.css') }}">
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="newbox blackline">
      <h3 style="margin-top: 10px;margin-bottom: 10px;font-family: droid;">@lang('business.business_settings')

      </h3>
  </div>
    <!--PEN HEADER-->
    <header class="header">
    
        <form style="display:none" class="pick-animation my-4">
            <div class="form-row">
                <div class="col-5 m-auto">
                    <select class="pick-animation__select form-control">
                        <option value="scaleIn" selected="selected">ScaleIn</option>
                        <option value="scaleOut">ScaleOut</option>
                        <option value="slideHorz">SlideHorz</option>
                        <option value="slideVert">SlideVert</option>
                        <option value="fadeIn">FadeIn</option>
                    </select>
                </div>
            </div>
        </form>
    </header>
    <!--PEN CONTENT     -->
    <div style="direction: rtl;font-family: droid;" class="">

        <!--content inner-->
        <div style="font-family: droid;" class="">
            <div class="">
                <!--content title-->
                <h2 style="font-family: droid;" class="content__title content__title--m-sm toh">اهلاً وسهلاً بك فى نظام براند لأدارة
                    الانشطة التجارية</h2>

                <!--content title-->
                <h4 style="font-family: droid;text-align: center;font-size: 14px;" class="">بعد ان تقوم بملئ البيانات من فضلك اضغط على زرار التالى للأنتقال للخطوة
                    التالية ، او اضغط على زرار تخطي ، لتخطي تجهيز اعدادات السيستم</h4>
            </div>
            <div class=" overflow-hidden">

                <!--multisteps-form-->
                <div style="text-align: center;" class="multisteps-form">
                    <!--progress bar-->
                    <div class="row">
                        <div class="col-12 col-lg-8 ml-auto mr-auto mb-4">
                            <div class="multisteps-form__progress">
                                <button class="multisteps-form__progress-btn js-active " type="button"
                                    title="بيانات النشاط الاساسية">بيانات النشاط الاساسية</button>
                                <button class="multisteps-form__progress-btn" type="button"
                                    title=">اعدادات المنتجات">اعدادات المنتجات</button>
                                <button class="multisteps-form__progress-btn" type="button"
                                    title="اعدادات البيع">اعدادات البيع</button>
                                <button class="multisteps-form__progress-btn" type="button" title="نقطة البيع">نقطة
                                    البيع
                                </button>
                                <button class="multisteps-form__progress-btn" type="button" title="المشتريات">
                                    المشتريات
                                </button>
                                <button class="multisteps-form__progress-btn" type="button" title="اعدادات النظام">
                                  اعدادات النظام
                              </button>
                            </div>
                        </div>
                    </div>
                    <!--form panels-->
                    <div class="row">
                        <div class="col-12 col-lg-8 m-auto">
                            <form class="multisteps-form__form">
                                <!--single form panel-->
                                <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active"
                                    data-animation="scaleIn">
                                    <h3 style="font-family: droid;" class="multisteps-form__title">بيانات النشاط الاساسية</h3>
                                    <div class="multisteps-form__content">
                                        @include('business.partials.settings_business')
                                        <div class="button-row d-flex mt-4">
                                            <button style="width: 100%" class="btn btn-primary ml-auto js-btn-next"
                                                type="button" title="Next">الـــتــــالــــى</button>
                                        </div>
                                    </div>
                                </div>
                                <!--single form panel-->
                                <div class="multisteps-form__panel shadow p-4 rounded bg-white"
                                    data-animation="scaleIn">
                                    <h3 class="multisteps-form__title">Your Address</h3>
                                    <div class="multisteps-form__content">
                                        <div>
                                            @include('business.partials.settings_product')
                                        </div>

                                        <div class="button-row d-flex mt-4">
                                            <button style="width: 48%;margin-left: 50px;"
                                                class="btn btn-primary js-btn-prev" type="button"
                                                title="Prev">الــســابــق</button>
                                            <button style="width: 48%" class="btn btn-primary ml-auto js-btn-next"
                                                type="button" title="Next">الــتــالــى</button>
                                        </div>
                                    </div>
                                </div>
                                <!--single form panel-->
                                <div class="multisteps-form__panel shadow p-4 rounded bg-white"
                                    data-animation="scaleIn">
                                    <h3 class="multisteps-form__title">Your Order Info</h3>
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-4">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Item Title</h5>
                                                        <p class="card-text">Small and nice item description</p><a
                                                            class="btn btn-primary" href="#"
                                                            title="Item Link">Item Link</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-4">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Item Title</h5>
                                                        <p class="card-text">Small and nice item description</p><a
                                                            class="btn btn-primary" href="#"
                                                            title="Item Link">Item Link</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="button-row d-flex mt-4 col-12">
                                                <button class="btn btn-primary js-btn-prev" type="button"
                                                    title="Prev">Prev</button>
                                                <button class="btn btn-primary ml-auto js-btn-next" type="button"
                                                    title="Next">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--single form panel-->
                                <div class="multisteps-form__panel shadow p-4 rounded bg-white"
                                    data-animation="scaleIn">
                                    <h3 class="multisteps-form__title">Additional Comments</h3>
                                    <div class="multisteps-form__content">
                                        <div class="form-row mt-4">
                                            <textarea class="multisteps-form__textarea form-control" placeholder="Additional Comments and Requirements"></textarea>
                                        </div>
                                        <div class="button-row d-flex mt-4">
                                            <button class="btn btn-primary js-btn-prev" type="button"
                                                title="Prev">Prev</button>
                                            <button class="btn btn-success ml-auto" type="button"
                                                title="Send">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- partial -->
    <script src="{{ asset('js/wizardscript.js') }}"></script>
    @section('javascript')

    </body>
