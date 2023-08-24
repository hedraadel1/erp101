{!! Form::open([
    'url' => action('ProductController@saveProductSerial'),
    'method' => 'post',
    'id' => 'save_product_serial_form',
]) !!}
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
                ادخل السريال الخاص بالمنتج : {{ $product->name }}
            </h4>
        </div>
        <div class="modal-body">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="business_id" value="{{ auth()->user()->business_id }}">
            <div class="form-group div_input">
                <div class="row">
                    <div class="col-md-10">
                        {!! Form::text('serial_code[]', null, [
                            'class' => 'form-control',
                            'placeholder' => 'ادخل السيريل',
                        ]) !!}
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn Btn-Primary add_input">+</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                @lang('messages.close')

            </button>
            <button type="submit" class="btn btn-primary ">
                @lang('messages.save')
            </button>
        </div>
    </div>
</div>
{!! Form::close() !!}
