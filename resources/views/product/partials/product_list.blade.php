@php
    $colspan = 15;
    $custom_labels = json_decode(session('business.custom_labels'), true);
@endphp
<table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
    <thead>
        <tr>
            <th><input type="checkbox" id="select-all-row" data-table-id="product_table"></th>
            <th>@lang('lang_v1.image')</th>
            <th>@lang('messages.action')</th>
            <th>@lang('sale.product')</th>
            <th>@lang('lang_v1.locationsandwarehour') @show_tooltip(__('الفروع والمخازن المتاح بها المنتج'))</th>
            @can('view_purchase_price')
                @php
                    $colspan++;
                @endphp
                <th>@lang('lang_v1.unit_perchase_price')</th>
            @endcan
            @can('access_default_selling_price')
                @php
                    $colspan++;
                @endphp
                <th>@lang('lang_v1.selling_price')</th>
            @endcan
            <th>@lang('report.current_stock')</th>
            <th>@lang('product.product_type')</th>
            <th>@lang('product.category')</th>
            <th>@lang('product.brand')</th>
            <th>@lang('product.tax')</th>
            <th>@lang('product.sku')</th>
            <th>{{ $custom_labels['product']['custom_field_1'] ?? __('lang_v1.product_custom_field1') }}</th>
            <th>{{ $custom_labels['product']['custom_field_2'] ?? __('lang_v1.product_custom_field2') }}</th>
            <th>{{ $custom_labels['product']['custom_field_3'] ?? __('lang_v1.product_custom_field3') }}</th>
            <th>{{ $custom_labels['product']['custom_field_4'] ?? __('lang_v1.product_custom_field4') }}</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="{{ $colspan }}">
                <div style="display: flex; width: 100%;">
                    @if (!isMobile())
                    <div class="row">
                      <div style="margin-top:1px" class="col-lg-3">
                          @can('product.delete')
                              {!! Form::open([
                                  'url' => action('ProductController@massDestroy'),
                                  'method' => 'post',
                                  'id' => 'mass_delete_form',
                              ]) !!}
                              {!! Form::hidden('selected_rows', null, ['id' => 'selected_rows']) !!}
                              {!! Form::submit(__('lang_v1.delete_selected'), [
                                  'class' => 'btn btn-xs btn-danger width200',
                                  'id' => 'delete-selected',
                              ]) !!}
                              {!! Form::close() !!}
                          @endcan
                      </div>
                      <div style="margin-top:1px" class="col-lg-3">
                          {{--  @show_tooltip(__('lang_v1.deactive_product_tooltip')) --}}
                          {!! Form::open([
                              'url' => action('ProductController@massDeactivate'),
                              'method' => 'post',
                              'id' => 'mass_deactivate_form',
                          ]) !!}
                          {!! Form::hidden('selected_products', null, ['id' => 'selected_products']) !!}
                          {!! Form::submit(__('lang_v1.deactivate_selected'), [
                              'class' => 'btn btn-xs btn-danger width200',
                              'id' => 'deactivate-selected',
                          ]) !!}
                          {!! Form::close() !!}
                      </div>
                      <div style="margin-top:1px" class="col-lg-3">
                          @can('product.update')
                              @if (config('constants.enable_product_bulk_edit'))
                                  {!! Form::open(['url' => action('ProductController@bulkEdit'), 'method' => 'post', 'id' => 'bulk_edit_form']) !!}
                                  {!! Form::hidden('selected_products', null, ['id' => 'selected_products_for_edit']) !!}
                                  <button type="submit" class="btn btn-xs btn-primary width200"
                                      id="edit-selected">{{ __('lang_v1.bulk_edit') }}</button>
                                  {!! Form::close() !!}
                              @endif
                          @endcan
                      </div>
                      <div style="margin-top:1px" class="col-lg-3">
                          @if ($is_woocommerce)
                              <button type="button" class="btn btn-xs btn-warning toggle_woocomerce_sync width200">
                                  @lang('lang_v1.woocommerce_sync')
                              </button>
                          @endif
                      </div>
                  </div>
                    @else
                    <div class="row">
                      <div style="margin-top:1px" class="col-lg-3">
                          @can('product.delete')
                              {!! Form::open([
                                  'url' => action('ProductController@massDestroy'),
                                  'method' => 'post',
                                  'id' => 'mass_delete_form',
                              ]) !!}
                              {!! Form::hidden('selected_rows', null, ['id' => 'selected_rows']) !!}
                              {!! Form::submit(__('lang_v1.delete_selected'), [
                                  'class' => 'btn btn-xs btn-danger width267',
                                  'id' => 'delete-selected',
                              ]) !!}
                              {!! Form::close() !!}
                          @endcan
                      </div>
                      <div style="margin-top:1px" class="col-lg-3">
                          {{--  @show_tooltip(__('lang_v1.deactive_product_tooltip')) --}}
                          {!! Form::open([
                              'url' => action('ProductController@massDeactivate'),
                              'method' => 'post',
                              'id' => 'mass_deactivate_form',
                          ]) !!}
                          {!! Form::hidden('selected_products', null, ['id' => 'selected_products']) !!}
                          {!! Form::submit(__('lang_v1.deactivate_selected'), [
                              'class' => 'btn btn-xs btn-danger width267',
                              'id' => 'deactivate-selected',
                          ]) !!}
                          {!! Form::close() !!}
                      </div>
                      <div style="margin-top:1px" class="col-lg-3">
                          @can('product.update')
                              @if (config('constants.enable_product_bulk_edit'))
                                  {!! Form::open(['url' => action('ProductController@bulkEdit'), 'method' => 'post', 'id' => 'bulk_edit_form']) !!}
                                  {!! Form::hidden('selected_products', null, ['id' => 'selected_products_for_edit']) !!}
                                  <button type="submit" class="btn btn-xs btn-primary width267"
                                      id="edit-selected">{{ __('lang_v1.bulk_edit') }}</button>
                                  {!! Form::close() !!}
                              @endif
                          @endcan
                      </div>
                      <div style="margin-top:1px" class="col-lg-3">
                          @if ($is_woocommerce)
                              <button type="button" class="btn btn-xs btn-warning toggle_woocomerce_sync width267">
                                  @lang('lang_v1.woocommerce_sync')
                              </button>
                          @endif
                      </div>
                  </div>
                    @endif

                    


                </div>
            </td>

        </tr>
        <tr>
            <td colspan="{{ $colspan }}">
                <div style="display: flex; width: 100%;">

                    <div class="row">
                        <div class="col-lg-4">
                            <button type="button" class="btn btn-xs btn-success update_product_location width267"
                                data-type="add">@lang('lang_v1.add_to_location')</button>
                        </div>
                        <div class="col-lg-4">

                            <button type="button" class="btn btn-xs bg-navy update_product_location width267"
                                data-type="remove">@lang('lang_v1.remove_from_location')</button>
                        </div>

                        <div class="col-lg-4">
                            <button type="button" class="btn btn-xs btn-primary increase_product_price width267">
                                زياده اسعار المنتجات
                            </button>
                        </div>

                    </div>

                </div>
            </td>

        </tr>
    </tfoot>
</table>
