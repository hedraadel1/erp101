<form action="{{ action('\Modules\Crm\Http\Controllers\ScheduleController@posNewSchedualLead') }}" method="post">
    @csrf
    {{-- {{ dd($resource) }} --}}
    <input type="hidden" name="business_id" value="{{ $resource->business_id }}">
    <input type="hidden" name="contact_id" value="{{ $resource->id }}">
    <div class="">
        <textarea name="title" id="" class="form-control" cols="20" rows="2"></textarea>
    </div>
    <div class="">
        {!! Form::select('status', $statuses, null, [
            'class' => 'form-control select2',
            'placeholder' => 'اختار الحالة',
            'style' => 'width: 100% !important;',
            'id' => 'follow_up_create_status',
        ]) !!}
    </div>
    <div class="">
        {!! Form::select('schedule_type', $follow_up_types, null, [
            'class' => 'form-control select2',
            'placeholder' => 'اختار النوع',
            'required',
            'style' => 'width: 100%!important;',
        ]) !!}
    </div>
    <div class="">
        <button id="" class="btn Btn-Brand btn-xs Btn-Primary" style="    width: 100%;margin-top: 2px;"
            type="submit">اضافة </button>
    </div>
</form>
