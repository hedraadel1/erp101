@extends('layouts.app')
@section('title', ' الدعم الفني')
@section('css')
    <style>
        .statue-style {
            padding: 3px;
            border: 1px solid;
            border-radius: 6px;
        }

        .pt-5 {
            padding-top: 15px;
        }

        .pb-5 {
            padding-bottom: 15px;
        }
    </style>
@endsection
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>

    <!-- Main content -->
    <section class="content ">
        <div class="row nav-tabs-custom pt-5">
            <div class="col-md-12">
                <h1> تفاصيل التذكرة (#{{ $resource->id . ' - ' . $resource->title }})</h1>
                <br>
            </div>
            <div class="col-md-8 pt-5">
                <span class="statue-style">الحالة :{{ $resource->status }}</span>
                <span class="statue-style"> اولوية : {{ $resource->priority }}</span>
                <span class="statue-style"> النشاط : {{ $resource->business->name }}</span>
                <span class="statue-style"> بواسطه : {{ $resource->user->username }}</span>
                <span class="statue-style"> التاريخ : {{ $resource->created_at }}</span>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{-- {!! Form::label('status', __('status') . ':') !!} --}}
                    {!! Form::select('status', $status, $resource->status, [
                        'class' => 'form-control select2',
                        'placeholder' => 'status',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-12 pt-5">
                <hr>
                <div class="card pt-5 pb-5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                @if ($resource->file)
                                    <a download="" class="btn btn-primary" href="{{ asset($resource->file) }}"> تحميل
                                        الملف</a>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="desc">
                                    {!! $resource->description !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row nav-tabs-custom pt-5">
            <div class="col-md-12 pt-5">
                @foreach ($comments as $comment)
                    <div class="card">
                        <div class="row">
                            <div class="col-md-3" style="border-left: 1px solid #ddd1d1;">
                                <h5><b>{{ optional($comment->user)->username }}</b></h5>
                                <p><b>تم النشر :</b>{{ $comment->created_at }}</p>
                                @if (auth()->user()->id == $comment->user_id)
                                    <a href="{{ route('support_customer.destroy.comment', $comment->id) }}"
                                        class="btn btn-danger">حذف</a>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="desc pb-5">
                                    {!! $comment->comment !!}
                                </div>
                                @if ($comment->file)
                                    <a download="" class="btn btn-primary" href="{{ asset($comment->file) }}"> تحميل
                                        الملف</a>
                                @endif

                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>

        @if (auth()->user()->can('replay_ticket'))
            <div class="row nav-tabs-custom">

                <div class="col-md-12 pt-5">
                    <div class="">
                        <form action="{{ route('support_customer.store.comment') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row " style="padding: 10px">
                                <input type="hidden" id="ticket_id" name="ticket_id" value="{{ $resource->id }}">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! Form::label('comment', __('lang_v1.comment') . ':') !!}
                                        <textarea name="comment" class="form-control" id="comment" cols="30" rows="10"></textarea>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('file', __('file') . ':') !!}
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">أضافة رد</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </section>


@endsection

@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script>
        if ($('textarea#comment').length > 0) {
            tinymce.init({
                selector: 'textarea#comment',
                height: 250
            });
        }

        $(document).ready(function() {
            $('select[name="status"]').on('change', function() {
                var status = $(this).val();
                if (status) {
                    $.ajax({
                        url: "/supportadmin/update-status",
                        type: "post",
                        dataType: "json",
                        data: {
                            'id': $('#ticket_id').val(),
                            'status': $(this).val(),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            location.reload();
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>

@endsection
