<div class="modal-dialog" role="document">
    <div class="modal-content">
        {!! Form::open([
            'url' => action('ZoneController@postAssignUsers'),
            'method' => 'post',
            'id' => 'add_user_zone_form',
        ]) !!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                @lang('essentials::lang.assign_users')

            </h4>
        </div>
        <div class="modal-body">
            {!! Form::hidden('zone_id', $zone->id) !!}
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>@lang('report.user')</th>
                        {{-- <th>@lang('business.start_date')</th>
                        <th>@lang('essentials::lang.end_date')</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $value)
                        {{-- @if (!$zone->userHaszone($key)) --}}
                        <tr>
                            <td>{!! Form::checkbox('user_zone[' . $key . '][is_added]', 1, array_key_exists($key, $user_zones), [
                                'id' => 'user_check_' . $key,
                            ]) !!}</td>
                            <td>{{ $value }}</td>
                            {{-- <td>
                                <div class="input-group date">
                                    {!! Form::text(
                                        'user_zone[' . $key . '][start_date]',
                                        !empty($user_zones[$key]['start_date']) ? $user_zones[$key]['start_date'] : null,
                                        [
                                            'class' => 'form-control date_picker',
                                            'placeholder' => __('business.start_date'),
                                            'readonly',
                                            'id' => 'user_zone[' . $key . '][start_date]',
                                        ],
                                    ) !!}
                                    <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group date">
                                    {!! Form::text(
                                        'user_zone[' . $key . '][end_date]',
                                        !empty($user_zones[$key]['end_date']) ? $user_zones[$key]['end_date'] : null,
                                        ['class' => 'form-control date_picker', 'placeholder' => __('essentials::lang.end_date'), 'readonly'],
                                    ) !!}
                                    <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                                </div>
                            </td> --}}
                        </tr>
                        {{-- @endif --}}
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn button-29">@lang('messages.submit')</button>

                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-default button-30"
                        data-dismiss="modal">@lang('messages.close')</button>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#add_user_zone_form').validate({
            rules: {
                @foreach ($users as $key => $value)
                    'user_zone[{{ $key }}][start_date]': {
                        required: function(element) {
                            return $('#user_check_{{ $key }}').is(":checked");
                        }
                    },
                @endforeach
            }
        });
    });
</script>
