@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.superadmin_automsg'))
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
      .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 25px;
      }

      .switch input {
          opacity: 0;
          width: 0;
          height: 0;
      }

      .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
      }

      .slider:before {
          position: absolute;
          content: "";
          height: 20px;
          width: 20px;
          left: 10px;
          bottom: 3px;

          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
      }

      input:checked+.slider {
          background-color: green;
      }

      input:focus+.slider {
          box-shadow: 0 0 1px green;
      }

      input:checked+.slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
      }

      /* Rounded sliders */
      .slider.round {
          border-radius: 34px;
      }

      .slider.round:before {
          border-radius: 50%;
      }
  </style>
@endsection
@section('content')
    @include('superadmin::layouts.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">@lang('superadmin::lang.superadmin_automsg')</h3>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => __('superadmin::lang.superadmin_automsg'),
        ])
            {{-- @slot('tool') --}}
            <div class="box-tools" style="padding: 5px">
                <button type="button" class="btn button-add btn-modal"
                    data-href="{{ action('\Modules\Superadmin\Http\Controllers\WhatsappNotificationController@create') }}"
                    data-container=".whatsapp_notifications">
                    <i class="fa fa-plus"></i> @lang('messages.add')</button>
            </div>
            {{-- @endslot --}}

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="whatsapp_notifications">
                    <thead>
                        <tr>
                            <th>الرسالة</th>
                            <th>الوقت</th>
                            <th>الي</th>
                            <th>الحالة</th>
                            <th>@lang('messages.action')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcomponent


        <div class="modal fade whatsapp_notifications" id="whatsapp_notifications" tabindex="-1" role="dialog"
            aria-labelledby="gridSystemModalLabel"></div>
    </section>
    <!-- /.content -->
@stop
@section('javascript')

    <script>
        init_tinymce('msg_details');
    </script>



    <script>
        $(document).on('click', 'input.status_whatsapp_notifications_button', function() {
            var is_active = 0;
            var id = $(this).data('id');
            var status = $(this).data('status');
            if (status == 0) {
                is_active = 1;
            }
            $.ajax({
                url: '/settings/whatsapp-notification-status',
                dataType: 'json',
                method: 'POST',
                data: {
                    'is_active': is_active,
                    'id': id,
                    '_token': "{{ csrf_token() }}",
                },
                success: function(result) {
                    whatsapp_notifications.ajax.reload();
                    toastr.success(result.msg);
                }
            });
        });
    </script>
@endsection
