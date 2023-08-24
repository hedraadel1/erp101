<div class="box {{ $class ?? 'box-solid' }}" @if (!empty($id)) id="{{ $id }}" @endif>
    @if (empty($header))
        @if (!empty($title) || !empty($tool))
            <div class="box-header">
                {!! $icon ?? '' !!}
                <b class="box-title" style="padding: 5px">{{ $title ?? '' }}</b>
                {!! $tool ?? '' !!}
            </div>
        @endif
    @else
        <div class="box-header">
            {!! $header !!}
        </div>
    @endif

    <div class="box-body">
        {{ $slot }}
    </div>
    <!-- /.box-body -->
</div>
