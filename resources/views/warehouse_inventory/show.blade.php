<div class="modal-dialog" role="document">
    <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"> عرض جرد المخزن</h4>
        </div>

        <div class="modal-body">
            <div class="form-group">
                <div class="desc">
                    <label for="">{{ __('lang_v1.date') }}</label> :
                    <strong>{{ $warehouse_inventory->date }}</strong>
                </div>
                <div class="desc">
                    <label for="">ملاحظات</label> : <br>
                    <p>{{ $warehouse_inventory->notes }}</p>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="">
                        <thead>
                            <tr>
                                <th>@lang('lang_v1.product_name')</th>
                                <th>@lang('lang_v1.quantity')</th>
                                <th>@lang('lang_v1.type')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warehouse_inventory->inventory_products as $item)
                                <tr>
                                 
                                    <td>{{ $item->product->name }}</td>
                                    <td>
                                        {{ $item->new_quantity }}
                                    </td>
                                    <td>
                                        @if ($item->new_quantity < $item->old_quantity)
                                            يوجد عجز ({{ $item->old_quantity - $item->new_quantity }})
                                        @elseif ($item->new_quantity > $item->old_quantity)
                                            يوجد زيادة ({{ $item->old_quantity - $item->new_quantity }})
                                        @else
                                            -----
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
        <div class="modal-footer">
            {{-- <button type="submit" class="btn btn-primary">@lang('messages.save')</button> --}}
            <button type="button" class="btn btn-default button-29" data-dismiss="modal">@lang('messages.close')</button>
        </div>
        {!! Form::close() !!}
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
