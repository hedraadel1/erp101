<div class="modal fade" id="increase_product_price_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" id>
        <div class="modal-content">

            {!! Form::open([
                'url' => action('UnitController@increaseProductsPrice'),
                'method' => 'post',
            ]) !!}

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">تسعير المنتجات بناء علي الوحده</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('', 'حدد الوحدة' . ':') !!} <br>
                            <style>
                                .select2-container {
                                    width: 100% !important
                                }
                            </style>
                            <select required name="unit_id" class="form-control select2" id=""
                                style="width:100%">
                                <option value="">حدد</option>
                                @foreach ($units_for_price as $item)
                                    <option value="{{ $item->id }}">{{ $item->actual_name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <div class="form-group">
                            {!! Form::label('', ' قيمة الوحدة' . ': ') !!}
                            <input type="number" name="amount" class="form-control " required>
                            {{-- {!! Form::number('amount', null, ['class' => 'form-control', 'required']) !!} --}}
                        </div>
                    </div>
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
                <br>
            </div>

            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
