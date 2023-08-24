@if (isMobile())
    @include('home.mobilehome')
    @else
    @include('home.pchome')
@endif

