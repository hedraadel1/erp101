@component('components.widget', ['title' => __('essentials::lang.hrm_details')])
    <div class="row">
        <div class="col-md-4">
            {!! Form::label('location_id', __('lang_v1.primary_work_location') . ':') !!}
            {!! Form::select('location_id', $locations, !empty($user->location_id) ? $user->location_id : null, [
                'class' => 'form-control select2',
                'placeholder' => __('messages.please_select'),
            ]) !!}
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('essentials_department_id', __('essentials::lang.department') . ':') !!}
                <div class="form-group">
                    {!! Form::select(
                        'essentials_department_id',
                        $departments,
                        !empty($user->essentials_department_id) ? $user->essentials_department_id : null,
                        ['class' => 'form-control select2', 'style' => 'width: 100%;', 'placeholder' => __('messages.please_select')],
                    ) !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('essentials_designation_id', __('essentials::lang.designation') . ':') !!}
                <div class="form-group">
                    {!! Form::select(
                        'essentials_designation_id',
                        $designations,
                        !empty($user->essentials_designation_id) ? $user->essentials_designation_id : null,
                        ['class' => 'form-control select2', 'style' => 'width: 100%;', 'placeholder' => __('messages.please_select')],
                    ) !!}
                </div>
            </div>
        </div>
    </div>
@endcomponent
@component('components.widget', ['title' => __('essentials::lang.payroll')])
    <div class="row">
        <div class="col-md-2">
            {!! Form::label('month_num', 'عدد أيام الشهر' . ':') !!}
            <br />
            {!! Form::number('month_num', null, [
                'class' => 'form-control pull-left',
                'id' => 'month_num',
                'placeholder' => 'عدد أيام الشهر',
            ]) !!}
        </div>
        <div class="col-md-2">
            {!! Form::label('hour_num', 'عدد ساعات العمل' . ':') !!}
            <br />
            {!! Form::number('hour_num', null, [
                'class' => 'form-control pull-left',
                'id' => 'hour_num',
                'placeholder' => 'عدد ساعات العمل',
            ]) !!}
        </div>
        <div class="col-md-2">
            {!! Form::label('salary', 'قيمة المرتب الشهري' . ':') !!}
            <br />
            {!! Form::number('salary', null, [
                'class' => 'form-control pull-left',
                'id' => 'salary',
                'placeholder' => 'قيمة المرتب الشهري',
            ]) !!}
            <span>
                <button type="button" onclick="calc_salary()" class="btn btn-sm btn-info">حساب المرتب بالساعه</button>
                <div id="error_msg" class="text-danger"></div>
            </span>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <div class="multi-input">
                    {!! Form::label('essentials_salary', __('essentials::lang.Basic_salary_byhour') . ':') !!}
                    <br />
                    {!! Form::number('essentials_salary', !empty($user->essentials_salary) ? $user->essentials_salary : null, [
                        'class' => 'form-control  pull-left',
                        // 'readonly',
                        'id' => 'essentials_salary',
                        'placeholder' => __('essentials::lang.salary'),
                    ]) !!}

                    {!! Form::select(
                        'essentials_pay_period',
                        [
                            'month' => __('essentials::lang.per') . ' ' . __('lang_v1.month'),
                            'week' => __('essentials::lang.per') . ' ' . __('essentials::lang.week'),
                            'day' => __('essentials::lang.per') . ' ' . __('lang_v1.day'),
                        ],
                        !empty($user->essentials_pay_period) ? $user->essentials_pay_period : null,
                        ['class' => 'form-control width-60 pull-left dontdisplay', 'style' => 'display:none'],
                    ) !!}
                </div>
            </div>
        </div>
        <div class="form-group col-md-4">
            {!! Form::label('pay_components', __('essentials::lang.pay_components') . ':') !!}
            {!! Form::select(
                'pay_components[]',
                $pay_comoponenets,
                !empty($allowance_deduction_ids) ? $allowance_deduction_ids : [],
                ['class' => 'form-control select2', 'multiple'],
            ) !!}
        </div>
    </div>
@endcomponent
