@extends('layouts.app')
@section('title', __('lang_v1.Terms_Terms'))

@php
    $pos_layout = false;
    $is_mobile = isMobile();
@endphp
<!-- Main content -->
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">

        @if (isMobile())
            <style>
                .mobilemode {
                    font-size: 15px;
                }
            </style>
        @else
            <style>
                .mobilemode {
                    font-size: 17px;
                }
            </style>
        @endif
    </head>



    <div style="margin-top:50px" class="login-form col-md-12 col-xs-12 right-col-content-register">
        <!-- Start Onoo Services -->
        <div class="HomeCardOnoo card "
            style="width:100% !important;height:45px !important;min-height:unset;text-align: center;color: mintcream;font-size: 17px;">
            <label style="text-align: center;color: mintcream;font-size: 17px;">
                @lang('lang_v1.Terms_Terms')
            </label>
        </div>



        <div class="login-form col-md-12 col-xs-12 right-col-content-register">

            <div class="HomeCardOnoo card " style="width:100% !important;height:100% !important">
                <div style="min-height: unset !important;height: 40px  !important;width:100%;margin-right: 0px !important;"
                    class="card card-SlickCarbon HomeCardOnooHeader">
                    <label style="text-align: center;color: mintcream;font-size: 17px;">
                        الدعم الفني
                    </label>
                </div>

                <div style="white-space: pre-line;line-height: 20px;padding: 10px;" class="row rowcardheader">
                    <div style="height: 55px;" class="btn-danger ">
                        1 - ما هي طرق الدعم الفني ؟
                    </div>
                    -- الواتس اّب
                    -- اللايف شات
                    -- التليفون - اونلاين سيشن
                    -- الزيارة (بداخل القاهره فقط)
                    -- تذاكر الدعم الفني


                    <div style="height: 55px;" class="btn-danger ">
                        2 - ما هي تكلفة الدعم الفني
                    </div>

                    - تختلف تكلفة الدعم الفني على حسب الطريقة والمشكلة وهى تنقسم كالتالى

                    أ - الدعم الفني عن طريق التذاكر
                    وهي طريقة مجانية بحد اقصي ثلاثة تذاكر شهرياً ، ويتم زيادتها على حسب باقات الدعم الفني

                    ب - الدعم الفني عن طريق الواتس اّب - اللايف شات
                    وهى طريقة مجانية ايضاً ولكن فى نطاق الاستفسارات فقط ،
                    مثال : كيف استطيع اضافة مستخدم جديد
                    وفى حالة ان كانت هناك مشكلة ، يتم فتح تذكرة او طلب دعم فني مدفوع

                    ج - الدعم الفني عن طريق التليفون- اونلاين سيشن
                    - وهي عبارة عن دخول احد المهندسين مع العميل عن طريق ال
                    Teamview - anydesk - etc
                    ليتم حل المشكلة

                    ويكون التكلفة 150 ج لأول ساعه و 50 ج لكل ساعه اضافية

                    د - الدعم الفني عن طريق الزيارات
                    - وهي عبارة عن زيارة من احد مهندسين الدعم الفني لحل المشكلة ، ويكون ذلك فى نطاق القاهره فقط
                    ويكون التكلفة

                    400 ج لأول ساعة و 150 ج لكل ساعة اضافية


                    <div style="height: 55px;" class="btn-danger ">
                        3 - ما هي اللوائح والقوانين الخاصة بالدعم الفني ؟
                    </div>
                    أ - مواعيد الدعم الفني

                    من الساعة 10 ص حتي 6 م
                    ماعادا حالات الطوارئ وهي ان السيستم لا يعمل
                    وفى حالة الطوارئ يتم التواصل مع رقم الشركة الرئيسي


                    ب - يتم تقديم الدعم الفني فى اطار السيستم فقط وليس المشاكل الخاصة بالهاردوير او الويندوز او غيرة


                    ج - لا يتم تقديم الدعم الفني الا عن طريق قنوات تواصل الشركة الرسمية ، والشركة غير مسؤلة عن اى دعم فني
                    يتم تقديمة خارج القنوات الرسمية
                </div>

                <br>
                <br>
                <div style="min-height: unset !important;height: 40px  !important;width:100%;margin-right: 0px !important;"
                    class="card card-SlickCarbon HomeCardOnooHeader">
                    <label style="text-align: center;color: mintcream;font-size: 17px;">
                        التدريب
                    </label>
                </div>

                <div style="white-space: pre-line;line-height: 20px;padding: 10px;" class="row rowcardheader">
                    يحق للعميل الحصول على تدريب كامل للسيستم عند التعاقد ، كما تلتزم الشركة ايضاً بتوفير المصادر اللازمة
                    للتعلم الذاتي مثل الفيديويهات ، ويتم ذلك عن طريق المركز التعليمي للسيستم
                </div>

                <br>
                <br>
                <div style="min-height: unset !important;height: 40px  !important;width:100%;margin-right: 0px !important;"
                    class="card card-SlickCarbon HomeCardOnooHeader ">
                    <label class="mobilemode" style="text-align: center;color: mintcream;">
                        سياسة الاستبدال والاسترجاع
                    </label>
                </div>

                <div style="white-space: pre-line;line-height: 20px;padding: 10px;" class="row rowcardheader">
                    لا تدعم الشركة سياسة الاستبدال والاسترجاع وذلك رجوعاً لقوانين حماية المستهلك والتى تنص علي
                    لا يجوز للمستهلك مباشرة حق الإستبدال أو الإعادة في الأحوال الآتية :

                    - الكتب والصحف والمجلات ، والبرامج المعلوماتية وما يماثلها.


                    كما يستطيع العميل تقييم السيستم او الخدمة عن طريق النسخه التجريبية بدون دفع اى اموال
                    مع الحصول على التوضيحات اللازمة من قبل فريق الدعم الفني والمبيعات
                </div>
            </div>
        </div>


    </div>
    </div>
    <!-- End Onoo Services -End -->
    </div>
@endsection
