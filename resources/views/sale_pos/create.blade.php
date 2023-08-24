@if (isMobile())
    @include('sale_pos.CreateForMobile')
@else
    @include('sale_pos.CreateForPc')
@endif


