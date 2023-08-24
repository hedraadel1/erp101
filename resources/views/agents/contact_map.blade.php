@php
    $api_key = env('GOOGLE_MAP_API_KEY');
@endphp


@component('components.widget', ['class' => 'box-solid'])
    <script async defer src="https://maps.googleapis.com/maps/api/js?key="></script>
    {{-- <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $api_key }}"></script> --}}



    <div id="map" style="height: 450px;"></div>
@endcomponent
