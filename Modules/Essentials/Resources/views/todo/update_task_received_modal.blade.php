<div class="modal fade" id="update_task_received_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">تغيير حالة الاستلام :<span id="task_name"></span></h4>
            </div>
            <div class="modal-body">
                <form action="{{ action('\Modules\Essentials\Http\Controllers\ToDoController@changeReceived') }}"
                    method="post">
                    @csrf
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="received_task"> استلام التاسك</button>

                        <input type="hidden" name="is_received" value="1">
                        {!! Form::hidden('task_id', null, ['id' => 'task_id']) !!}
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
