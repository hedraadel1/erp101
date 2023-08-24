@extends('layouts.app')
@section('title', __('expense.expense_categories'))

@section('content')

<!-- Content Header (Page header) -->
<section style="margin-top: -25px;" class="content-header">
  <div class="newbox blackline">
      <h3 style="margin-top: 10px;margin-bottom: 10px;">
          @lang( 'expense.manage_your_expense_categories' )
       </h3>
  </div>

</section>


<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'expense.all_your_expense_categories' )])
        @slot('tool')
        <div class="row">
          <div class="col-md-12">
            <div class="box-tools">
                <button type="button" class="btn btn-block button-add btn-modal" 
                data-href="{{action('ExpenseCategoryController@create')}}" 
                data-container=".expense_category_modal">
                <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
            </div>
          </div>
        </div>
            
        @endslot
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="expense_category_table">
                <thead>
                    <tr>
                        <th>@lang( 'expense.category_name' )</th>
                        <th>@lang( 'expense.category_code' )</th>
                        <th>@lang( 'messages.action' )</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent

    <div class="modal fade expense_category_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
