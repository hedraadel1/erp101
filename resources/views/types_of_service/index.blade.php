@extends('layouts.app')
@section('title', __('lang_v1.types_of_service'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">
                @lang('lang_v1.types_of_service')
            </h3>
        </div>

    </section>


    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-primary'])
            @slot('tool')
            <div class="row">
              <div class="col-md-12">
                <div class="box-tools">
                    <button type="button" class="btn btn-block button-add btn-modal"
                        data-href="{{ action('TypesOfServiceController@create') }}" data-container=".type_of_service_modal">
                        <i class="fa fa-plus"></i> @lang('messages.add')</button>
                </div>
              </div>
            </div>
                
            @endslot
            @can('brand.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="types_of_service_table">
                        <thead>
                            <tr>
                                <th>@lang('tax_rate.name')</th>
                                <th>@lang('lang_v1.description')</th>
                                <th>@lang('lang_v1.packing_charge')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcan
        @endcomponent

        <div class="modal fade type_of_service_modal contains_select2" tabindex="-1" role="dialog"
            aria-labelledby="gridSystemModalLabel">
        </div>

    </section>
    <!-- /.content -->

@endsection
