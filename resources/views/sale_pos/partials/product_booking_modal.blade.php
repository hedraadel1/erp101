<div class="modal fade no-print" id="product_booking_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('lang_v1.product_bookings')</h4>
            </div>
            <div class="modal-body">
                <div class="filter">
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::text('search', null, [
                                'class' => 'form-control',
                                'id' => 'search-product-name',
                                'placeholder' => 'ابحث باسم المنتج',
                            ]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::select('contact_id', $customers, null, [
                                'class' => 'form-control select2',
                                'id' => 'filter-customer_id',
                                'placeholder' => 'Enter Customer name / phone',
                                'style' => 'width: 100%',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <br>
                <div id="product-booking-body">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
