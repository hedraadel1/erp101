<head>

    <style>
        .content-wrapper {
            padding-top: 0 !important;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .navsuperadmin {

            z-index: 999999999999;
            background: black;

        }

        .navsuperadmin .wrappersuperadmin {
            position: relative;
            max-width: 100%;
            padding: 0px 30px;
            height: 70px;
            line-height: 70px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .wrappersuperadmin .logo a {
            color: #f2f2f2;
            font-size: 30px;
            font-weight: 600;
            text-decoration: none;
        }

        .wrappersuperadmin .navsuperadmin-links {
            display: inline-flex;
        }

        .navsuperadmin-links li {
            list-style: none;
        }

        .navsuperadmin-links li a {
            color: #f2f2f2;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            padding: 9px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .navsuperadmin-links li a:hover {
            background: #3A3B3C;
        }

        .navsuperadmin-links .mobile-item {
            display: none;
        }

        .navsuperadmin-links .drop-menu {
            position: absolute;
            background: #242526;
            width: 250px;

            line-height: 45px;
            top: 85px;
            opacity: 0;
            visibility: hidden;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .navsuperadmin-links li:hover .drop-menu,
        .navsuperadmin-links li:hover .mega-box {
            transition: all 0.3s ease;
            top: 70px;
            opacity: 1;
            visibility: visible;
        }

        .drop-menu li a {
            width: 100%;
            display: block;
            padding: 0 0 0 15px;
            font-weight: 400;
            border-radius: 0px;
            padding: 10px;
        }

        .mega-box {
            position: absolute;
            left: 0;
            width: 100%;
            padding: 0 30px;
            top: 85px;
            opacity: 0;
            visibility: hidden;
        }

        .mega-box .content {
            background: #242526;
            padding: 25px 20px;
            display: flex;
            width: 100%;
            justify-content: space-between;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .mega-box .content .row {
            width: calc(25% - 30px);
            line-height: 45px;
        }

        .content .row img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .content .row header {
            color: #f2f2f2;
            font-size: 20px;
            font-weight: 500;
        }

        .content .row .mega-links {
            margin-left: -40px;
            border-left: 1px solid rgba(255, 255, 255, 0.09);
        }

        .row .mega-links li {
            padding: 0 20px;
        }

        .row .mega-links li a {
            padding: 0px;
            padding: 0 20px;
            color: #d9d9d9;
            font-size: 17px;
            display: block;
        }

        .row .mega-links li a:hover {
            color: #f2f2f2;
        }

        .wrappersuperadmin .btn {
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            display: none;
        }

        .wrappersuperadmin .btn.close-btn {
            position: absolute;
            right: 30px;
            top: 10px;
        }

        @media screen and (max-width: 970px) {
            .wrappersuperadmin .btn {
                display: block;
            }

            .wrappersuperadmin .navsuperadmin-links {
                position: fixed;
                height: 100vh;
                width: 100%;
                max-width: 100%;
                top: 0;
                left: -100%;
                background: #242526;
                display: block;
                padding: 50px 10px;
                line-height: 50px;
                overflow-y: auto;
                box-shadow: 0px 15px 15px rgba(0, 0, 0, 0.18);
                transition: all 0.3s ease;
            }

            /* custom scroll bar */
            ::-webkit-scrollbar {
                width: 10px;
            }

            ::-webkit-scrollbar-track {
                background: #242526;
            }

            ::-webkit-scrollbar-thumb {
                background: #3A3B3C;
            }

            #menu-btn:checked~.navsuperadmin-links {
                left: 0%;
            }

            #menu-btn:checked~.btn.menu-btn {
                display: none;
            }

            #close-btn:checked~.btn.menu-btn {
                display: block;
            }

            .navsuperadmin-links li {
                margin: 15px 10px;
            }

            .navsuperadmin-links li a {
                padding: 0 20px;
                display: block;
                font-size: 20px;
            }

            .navsuperadmin-links .drop-menu {
                position: static;
                opacity: 1;
                top: 65px;
                visibility: visible;
                padding-left: 20px;
                width: 100%;
                max-height: 0px;
                overflow: hidden;
                box-shadow: none;
                transition: all 0.3s ease;
            }

            #showDrop:checked~.drop-menu,
            #showMega:checked~.mega-box {
                max-height: 100%;
            }

            .navsuperadmin-links .desktop-item {
                display: none;
            }

            .navsuperadmin-links .mobile-item {
                display: block;
                color: #f2f2f2;
                font-size: 20px;
                font-weight: 500;
                padding-left: 20px;
                cursor: pointer;
                border-radius: 5px;
                transition: all 0.3s ease;
            }

            .navsuperadmin-links .mobile-item:hover {
                background: #3A3B3C;
            }

            .drop-menu li {
                margin: 0;
            }

            .drop-menu li a {
                border-radius: 5px;
                font-size: 18px;
            }

            .mega-box {
                position: static;
                top: 65px;
                opacity: 1;
                visibility: visible;
                padding: 0 20px;
                max-height: 0px;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .mega-box .content {
                box-shadow: none;
                flex-direction: column;
                padding: 20px 20px 0 20px;
            }

            .mega-box .content .row {
                width: 100%;
                margin-bottom: 15px;
                border-top: 1px solid rgba(255, 255, 255, 0.08);
            }

            .mega-box .content .row:nth-child(1),
            .mega-box .content .row:nth-child(2) {
                border-top: 0px;
            }

            .content .row .mega-links {
                border-left: 0px;
                padding-left: 15px;
            }

            .row .mega-links li {
                margin: 0;
            }

            .content .row header {
                font-size: 19px;
            }
        }

        nav input {
            display: none;
        }

        .body-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            text-align: center;
            padding: 0 30px;
        }

        .body-text div {
            font-size: 45px;
            font-weight: 600;
        }
    </style>
</head>

<section class="no-print">
    <nav class="navsuperadmin navbar navbar-default bg-white m-4">
        <div class="wrappersuperadmin">
            <input type="radio" name="slider" id="menu-btn" />
            <input type="radio" name="slider" id="close-btn" />
            <ul class="navsuperadmin-links">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="{{ action('\Modules\Superadmin\Http\Controllers\BusinessController@index') }}">جميع
                        الشركات</a></li>
                <li>
                    <a href="#" class="desktop-item">ادارة الاشتراكات</a>
                    <input type="checkbox" id="showDrop" />
                    <label for="showDrop" class="mobile-item">ادارة الاشتراكات</label>
                    <ul class="drop-menu">
                        <li><a
                                href="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminSubscriptionsController@index') }}">
                                ادارة الاشتراكات </a></li>
                                <li><a
                                  href="{{ action('\Modules\Superadmin\Http\Controllers\SerSuperadminSubscriptionsController@index') }}">
                                  ادارة اشتراكات السيرفر </a></li>
                        <li><a
                                href="{{ action('\Modules\Superadmin\Http\Controllers\DepositRequestController@getAllDepositRequests') }}">
                                طلبات الشحن </a></li>
                        <li><a
                                href="{{ action('\Modules\Superadmin\Http\Controllers\DepositRequestCodeController@index') }}">
                                اكواد الشحن </a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="desktop-item">الـتـواصـل</a>
                    <input type="checkbox" id="showDrop" />
                    <label for="showDrop" class="mobile-item">الـتـواصـل</label>
                    <ul class="drop-menu">
                        <li><a href="{{ action('\Modules\Superadmin\Http\Controllers\CommunicatorController@index') }}">
                                التواصل العام </a></li>
                        <li><a href="{{ action('\Modules\Superadmin\Http\Controllers\ContentController@index') }}">
                                ادارة المحتوي </a></li>
                        <li><a
                                href="{{ action('\Modules\Superadmin\Http\Controllers\WhatsappNotificationController@index') }}">
                                رسائل الواتس اّب </a></li>
                    </ul>
                </li>

                <li><a href="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@index') }}">متجر
                        براند</a></li>

                <li>
                    <a href="#" class="desktop-item">الاعدادات</a>
                    <input type="checkbox" id="showDrop" />
                    <label for="showDrop" class="mobile-item">الاعدادات</label>
                    <ul class="drop-menu">
                        <li><a
                                href="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminSettingsController@edit') }}">
                                الاعدادات العامة </a></li>
                        <li><a
                                href="{{ action('\Modules\Superadmin\Http\Controllers\BusinessCategoryController@index') }}">
                                تصنيفات الانشطة </a></li>
                        <li><a href="{{ action('\Modules\Superadmin\Http\Controllers\PackagesController@index') }}">Packages
                                الـ </a></li>
                        <li><a
                                href="{{ action('\Modules\Superadmin\Http\Controllers\SettingGoFastController@index') }}">
                                الذهاب السريع </a></li>
                        <li><a
                                href="{{ action('\Modules\Superadmin\Http\Controllers\EducationCategoryController@index') }}">
                                القسم التعليمي </a></li>
                                <li><a
                                  href="{{ action('\Modules\Superadmin\Http\Controllers\ServerTypeController@index') }}">
                                   Server Types </a></li>
                    </ul>
                </li>

            </ul>
            <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
            <div class="logo">
                <a href="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminController@index') }}">Brand</a>
            </div>
        </div>
    </nav>

</section>
