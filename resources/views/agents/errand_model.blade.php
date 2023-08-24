<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">تصريح خروج خارج النطاق المحدد</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('agent.postErrands') }}" method="post">
            @csrf
            <div class="modal-body">
                {!! Form::hidden('user_id', $agent->user_id) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('date_time_from', 'تاريخ  البداية : *') !!}
                            {!! Form::datetimelocal('date_time_from', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('date_time_to', 'تاريخ الانتهاء : *') !!}
                            {!! Form::datetimelocal('date_time_to', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('notes', 'ملاحظات ') !!}
                            {!! Form::textarea('notes', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
            </div>
        </form>
    </div>
</div>
