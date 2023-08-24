<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => action('CustomerGroupController@update', [$customer_group->id]),
            'method' => 'PUT',
            'id' => 'customer_group_edit_form',
        ]) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('lang_v1.edit_customer_group')</h4>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __('lang_v1.customer_group_name') . ':*') !!}
                {!! Form::text('name', $customer_group->name, [
                    'class' => 'form-control',
                    'required',
                    'placeholder' => __('lang_v1.customer_group_name'),
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('price_calculation_type', __('lang_v1.price_calculation_type') . ':') !!}
                {!! Form::select(
                    'price_calculation_type',
                    ['percentage' => __('lang_v1.percentage'), 'selling_price_group' => __('lang_v1.selling_price_group')],
                    $customer_group->price_calculation_type,
                    ['class' => 'form-control'],
                ) !!}
            </div>
            <div class="form-group percentage-field @if ($customer_group->price_calculation_type != 'percentage') hide @endif">
                {!! Form::label('amount', __('lang_v1.calculation_percentage') . ':') !!}
                @show_tooltip(__('lang_v1.tooltip_calculation_percentage'))
                {!! Form::text('amount', @num_format($customer_group->amount), [
                    'class' => 'form-control input_number',
                    'placeholder' => __('lang_v1.calculation_percentage'),
                ]) !!}
            </div>

            <div class="form-group selling_price_group-field @if ($customer_group->price_calculation_type != 'selling_price_group') hide @endif">
                {!! Form::label('selling_price_group_id', __('lang_v1.selling_price_group') . ':') !!}
                {!! Form::select('selling_price_group_id', $price_groups, $customer_group->selling_price_group_id, [
                    'class' => 'form-control',
                ]) !!}
            </div>

            <div class="form-group">
                {!! Form::label('user_group_id', __('business.users') . ':') !!} @show_tooltip(__('lang_v1.users'))

                {!! Form::select('user_group_id[]', $users, $user_group_ids, [
                    'class' => 'form-control select2',
                    'multiple',
                    'style' => 'width:100%',
                ]) !!}
            </div>
            <div class="form-group col-sm-6">
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('define_base_unit', 1, !empty($customer_group->commission_customer_group), [
                                'class' => 'toggler',
                                'data-toggle_id' => 'commission_customer_group',
                            ]) !!} (%) عمولة بناء علي مجموعة العملاء
                        </label> @show_tooltip(__('lang_v1.multi_unit_help'))
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-12 @if (empty($customer_group->commission_customer_group)) hide @endif "
                id="commission_customer_group">
                {!! Form::text('commission_customer_group', $customer_group->commission_customer_group, [
                    'class' => 'form-control input_number',
                    'placeholder' => ' (%) أدخل نسبة العموله',
                ]) !!}</td>
            </div>

        </div>

        <div class="modal-footer">
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn button-29">@lang('messages.update')</button>

                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-default button-30"
                        data-dismiss="modal">@lang('messages.close')</button>

                </div>
            </div>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
