<div class="modal-dialog" role="document">
    <div class="modal-content">

        <form id="education_video_form"
            action="{{ $video->id ? action('\Modules\Superadmin\Http\Controllers\EducationVideoController@update', [$video->id]) : action('\Modules\Superadmin\Http\Controllers\EducationVideoController@store') }}"
            method="post" enctype="multipart/form-data">
            @csrf

            {{-- @if ($video->id)
                @method('PUT')
            @endif --}}
            <input type="hidden" id="method" value="{{ $video->id ? 'PUT' : 'POST' }}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    @if ($video->id)
                        @lang('superadmin::lang.edit_video')
                    @else
                        @lang('superadmin::lang.add_video')
                    @endif
                </h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('video', __('superadmin::lang.video')) !!}
                    <input type="file" name="file" id="file" class="form-control">
                    <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('video_url', __('superadmin::lang.video_url')) !!}
                    {!! Form::text('video_url', old('video_url', $video->video_url), [
                        'class' => 'form-control',
                        'required',
                        'id' => 'video_url',
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('name', __('superadmin::lang.name') . ':*') !!}
                    {!! Form::text('name', old('name', $video->name), ['class' => 'form-control', 'required', 'id' => 'video_name']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('video_category', __('superadmin::lang.video_category') . ':*') !!}
                    {!! Form::select('category_id', $categories, $video->category_id, [
                        'class' => 'select2 select-bs form-control',
                        'placeholder' => 'حدد القسم',
                        'id' => 'video_category',
                        'required',
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description', __('superadmin::lang.video_description')) !!}
                    {!! Form::textarea('description', $video->description, [
                        'class' => 'form-control',
                        'id' => 'video_description',
                        'placeholder' => __('superadmin::lang.video_description'),
                    ]) !!}
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
            </div>

        </form>


    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
