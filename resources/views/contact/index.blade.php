@if ($type == 'customer')
    @include('contact.customer')
@else
    @include('contact.supplier')
@endif
