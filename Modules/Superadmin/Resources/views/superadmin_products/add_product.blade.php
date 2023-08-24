<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@storeProduct'),
            'method' => 'post',
            'id' => '',
        ]) !!}

        {!! Form::hidden('business_id', $business_id) !!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('superadmin::lang.add_product')</h4>
        </div>

        <div class="modal-body">
            @if (count($products) > 0)
                <div class="form-group">
                    {!! Form::label('amount', __('superadmin::lang.products') . ':*') !!}
                    {!! Form::select('product_id', $products, null, [
                        'class' => 'form-control select2 ',
                        'placeholder' => __('lang_v1.none'),
                    ]) !!}
                </div>
                <div id="duration" class="hide">
                    <div class="form-group">
                        {!! Form::label('start_date', __('superadmin::lang.date_from') . ':*') !!}
                        {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('end_date', __('superadmin::lang.date_to') . ':*') !!}
                        {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::checkbox('paid', 1, true, ['class' => 'form-input', 'id' => 'paid']) !!}
                    {!! Form::label('paid', 'الدفع من خلال المحفظة') !!}
                </div>
            @else
                <div class="alert bg-danger">
                    <span>تم شراء جميع المنتجات المتاحة</span>
                </div>
            @endif



        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $('select[name="product_id"]').on('change', function() {
        var id = $(this).val();
        $.ajax({
            url: "{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@checkDuration') }}",
            type: "GET",
            dataType: "json",
            data: {
                'id': id
            },
            success: function(res) {
                if (res == true) {
                    $('#duration').removeClass('hide')
                } else {
                    $('#duration').addClass('hide')

                }
            },

        });
    });
</script>
