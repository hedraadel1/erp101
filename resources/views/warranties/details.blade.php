@extends('layouts.app')
@section('title', __('lang_v1.warranties'))
@section('css')
   
@endsection
@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">
                فحص الضمان
            </h3>
        </div>

    </section>


    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['title' => 'فحص الضمان'])
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ action('WarrantyController@getSerialDetails') }}" method="get" id="warranty_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('serial_code', ' : السيريال') !!}
                                    {!! Form::text('serial_code', null, ['class' => 'form-control', 'requried']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="submit" class="btn button-29" value="فحص">
                                    {{-- <button  type="submit"></button> --}}
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>

            <br><br>
            <div class="row">
                <div class="col-md-12">
                    <div id="serial_details"></div>
                </div>
            </div>
        @endcomponent

    </section>
    <!-- /.content -->
@stop

@section('javascript')
    <script type="text/javascript"></script>
    <script>
        $(document).on('submit', 'form#warranty_form', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();

            $.ajax({
                method: 'GET',
                url: $(this).attr('action'),
                dataType: 'html',
                data: data,

                success: function(result) {
                    $('#serial_details').html('');
                    $('#serial_details').append(result);
                },
            });
        });
    </script>
@endsection
