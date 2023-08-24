<head>
    <style>
        .boxfilter {
            position: relative;
            background: #fff;
            border-top: 3px solid #d2d6de;
            border-left: 3px solid #d2d6de;
            border-bottom: 3px solid #d2d6de;
            border-right: 3px solid #d2d6de;
            border-radius: 10px;
            margin-bottom: 20px;
            width: 100%;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            transform: translate3d(0, 0, 0);
        }

        .button-header-401 {
            width: 100%;
            font-size: 15px;
            height: 52px;
            font-family: 'droid';
            /*             margin-bottom: 5px; */
            background-color: #111827;
            border: 1px solid transparent;
            border-radius: .75rem;
            box-sizing: border-box;
            color: #FFFFFF;
            cursor: pointer;
            flex: 0 0 auto;
            font-weight: 600;
            line-height: 1.5rem;
            padding: .75rem 1.2rem;
            text-align: center;
            text-decoration: none #6B7280 solid;
            text-decoration-thickness: auto;
            transition-duration: .2s;
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(.4, 0, 0.2, 1);
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;

        }

        .button-header-401:hover {
            background-color: #374151;
        }

        .button-header-401:focus {
            box-shadow: none;
            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        @media (min-width: 768px) {
            .button-header-401 {
                padding: .75rem 1.5rem;
            }
        }
    </style>
</head>


<div class="boxfilter @if (!empty($class)) {{ $class }} @else box-solid @endif" id="accordion">
    <div class="box-header with-border button-header-401" style="cursor: pointer;">
        <h3 style="color:white;margin-top: 8px;" class="box-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
                @if (!empty($icon))
                    {!! $icon !!}
                @else
                    <i class="fa fa-filter" aria-hidden="true"></i>
                @endif {{ $title ?? '' }}
            </a>
        </h3>
    </div>
    @php
        if (isMobile()) {
            $closed = true;
        }
    @endphp
    <div id="collapseFilter" class="panel-collapse active collapse @if (empty($closed)) in @endif"
        aria-expanded="true">
        <div class="box-body">
            {{ $slot }}
        </div>
    </div>
</div>
