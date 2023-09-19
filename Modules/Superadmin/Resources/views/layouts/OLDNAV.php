<head>

  <style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  nav {
    position: fixed;
    z-index: 999999999;
    width: 100%;

    background: #242526;
  }

  nav .wrapper {
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

  .wrapper .logo a {
    color: #f2f2f2;
    font-size: 30px;
    font-weight: 600;
    text-decoration: none;
  }

  .wrapper .nav-links {
    display: inline-flex;
  }

  .nav-links li {
    list-style: none;
  }

  .nav-links li a {
    color: #f2f2f2;
    text-decoration: none;
    font-size: 18px;
    font-weight: 500;
    padding: 9px 15px;
    border-radius: 5px;
    transition: all 0.3s ease;
  }

  .nav-links li a:hover {
    background: #3A3B3C;
  }

  .nav-links .mobile-item {
    display: none;
  }

  .nav-links .drop-menu {
    position: absolute;
    background: #242526;
    width: 180px;
    line-height: 45px;
    top: 85px;
    opacity: 0;
    visibility: hidden;
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
  }

  .nav-links li:hover .drop-menu,
  .nav-links li:hover .mega-box {
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

  .wrapper .btn {
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    display: none;
  }

  .wrapper .btn.close-btn {
    position: absolute;
    right: 30px;
    top: 10px;
  }

  @media screen and (max-width: 970px) {
    .wrapper .btn {
      display: block;
    }

    .wrapper .nav-links {
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

    #menu-btn:checked~.nav-links {
      left: 0%;
    }

    #menu-btn:checked~.btn.menu-btn {
      display: none;
    }

    #close-btn:checked~.btn.menu-btn {
      display: block;
    }

    .nav-links li {
      margin: 15px 10px;
    }

    .nav-links li a {
      padding: 0 20px;
      display: block;
      font-size: 20px;
    }

    .nav-links .drop-menu {
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

    .nav-links .desktop-item {
      display: none;
    }

    .nav-links .mobile-item {
      display: block;
      color: #f2f2f2;
      font-size: 20px;
      font-weight: 500;
      padding-left: 20px;
      cursor: pointer;
      border-radius: 5px;
      transition: all 0.3s ease;
    }

    .nav-links .mobile-item:hover {
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
  <nav class="navbar navbar-default bg-white m-4">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
          data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand"
          href="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminController@index') }}"><i
            class="fa fas fa-users-cog"></i> {{ __('superadmin::lang.superadmin') }}</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'business') class="active"
            @endif><a
              href="{{ action('\Modules\Superadmin\Http\Controllers\BusinessController@index') }}">@lang('superadmin::lang.all_business')</a>
          </li>
          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'categories') class="active"
            @endif><a href="">@lang('superadmin::lang.categories')</a>
          </li>

          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'superadmin-subscription')
            class="active" @endif><a href="">@lang('superadmin::lang.subscription')</a>
          </li>

          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'packages') class="active"
            @endif><a href="">@lang('superadmin::lang.subscription_packages')</a>
          </li>

          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'settings') class="active"
            @endif><a href="">@lang('superadmin::lang.super_admin_settings')</a>
          </li>

          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'communicator') class="active"
            @endif><a href="">@lang('superadmin::lang.communicator')</a>
          </li>

          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'contents') class="active"
            @endif><a href="">@lang('superadmin::lang.contents')</a>
          </li>
          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'products') class="active"
            @endif><a href="">@lang('superadmin::lang.brand_store')</a>
          </li>
          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'education-learn') class="active"
            @endif><a href="">@lang('superadmin::lang.education_learn')</a>
          </li>
          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'settings/go-fast') class="active"
            @endif><a href="">@lang('superadmin::lang.setting_gofast')</a>
          </li>

          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'settings/whatsapp-notification')
            class="active" @endif><a href="">@lang('superadmin::lang.whatsapp_notification')</a>
          </li>

          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'superadmin/deposit_requests')
            class="active" @endif><a href="">طلبات
              شحن المحفظة</a>
          </li>
          <li @if (request()->segment(1) == 'superadmin' && request()->segment(2) == 'superadmin/deposit_requests_code')
            class="active" @endif><a href="">
              اكواد الشحن</a>
          </li>
        </ul>

      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</section>