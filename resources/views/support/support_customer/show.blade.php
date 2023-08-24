@extends('layouts.app')
@section('title', ' الدعم الفني')
@section('css')
    <style>
        .statue-style {
            padding: 3px;
            border: 2px double;
            border-radius: 6px;
            margin-right: 3px;
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
            <div style="margin-bottom: 20px" class="col-md-12">
                <div style="height: 35px;" class="button-header-401">{{ $resource->id . ' - ' . $resource->title }}</div>
            </div>

            <div class="col-md-12">

                <div style="display: flex;text-align: center">
                    <div style="width:20%;border-color: brown;" class="statue-style">الحالة </div>
                    <div style="width:80%" class="statue-style">{{ $resource->status }}</div>
                </div>

                <div style="display: flex;text-align: center">
                    <div style="width:20%;border-color: brown;" class="statue-style">اولوية </div>
                    <div style="width:80%" class="statue-style">{{ $resource->priority }}</div>
                </div>

                <div style="display: flex;text-align: center">
                    <div style="width:20%;border-color: brown;" class="statue-style">النشاط </div>
                    <div style="width:80%" class="statue-style">{{ $resource->business->name }}</div>
                </div>

                <div style="display: flex;text-align: center">
                    <div style="width:20%;border-color: brown;" class="statue-style">بواسطه </div>
                    <div style="width:80%" class="statue-style">{{ $resource->user->username }}</div>
                </div>

                <div style="display: flex;text-align: center">
                    <div style="width:20%;border-color: brown;" class="statue-style">التاريخ </div>
                    <div style="width:80%" class="statue-style">{{ $resource->created_at }}</div>
                </div>
                <div class="col-md-12 pt-5">

                    <div class="card pt-5 pb-5">
                        <div class="col-md-12">
                            <div style="height: 35px;" class="button-header-401">تفاصيل التذكرة</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    @if ($resource->file)
                                        <a download="" class="btn btn-primary" href="{{ asset($resource->file) }}">
                                            تحميل
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
                                        <a download="" class="btn btn-primary" href="{{ asset($comment->file) }}">
                                            تحميل
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
                                    <input type="hidden" name="ticket_id" value="{{ $resource->id }}">
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
    </script>

@endsection
