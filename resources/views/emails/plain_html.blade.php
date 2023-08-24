@if (isset($content))
    {!! $content !!}
@endif
@if (isset($name))
    {{ $name }}
@endif
@if (isset($url))
    <a href="{{ $url }}" class="btn btn-info">التفاصيل</a>
@endif
