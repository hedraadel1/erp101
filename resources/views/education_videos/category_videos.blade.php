@extends('layouts.guest')
<style>
    .blackline {
        border-top: 3px solid #000;
        border-bottom: 3px solid #000;
    }

    .newbox {
        border-radius: 5px;
        newbox-shadow: 0px 30px 40px -20px var(--grayishBlue);
        padding: 3px;
        justify-content: center;
        display: flex;
        place-items: center;
        background: white;
    }

    .filter {
        border-radius: 5px;
        newbox-shadow: 0px 30px 40px -20px var(--grayishBlue);
        padding: 10px;
        background: white;
    }

    .content_ {
        background-color: #f8f9fe;
        padding: 15px 15px 0 15px;
    }
</style>
@section('title', 'الشروحات')
@section('content')
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <div class="content_">
        <section class="content-header text-center" id="top">
            <div class="newbox blackline">
                <h3 style="margin-top: 10px;margin-bottom: 10px;">الشروحات</h3>
            </div>
        </section>

        <section style="padding: 15px 15px 0 15px;">



            <section>
                <div class="row  text-{{ isRtl() ? 'right' : 'left' }}" style="padding-top: 15px">
                    <div class="col-sm-12  page-header ">
                        <b class="h2">
                            {{ $category_videos->name }}
                        </b>
                    </div>
                    @foreach ($category_videos->videos as $item)
                        <div class="col-lg-3 col-md-4 col-sm-12  "
                            style="padding-top: 15px ;float:{{ isRtl() ? 'right' : 'left' }}">
                            <div class="box">
                                @if ($item->video)
                                    <video width="100%" height="180px" class="demo cursor"
                                        style="border: 1px solid #fafafa;" controls>
                                        <source src="{{ asset($item->video) }}" type="video/mp4">
                                    </video>
                                @else
                                    <iframe width="100%" height="180px"
                                        src="//www.youtube.com/embed/{{ $item->video_id }}" frameborder="0"
                                        allowfullscreen></iframe>
                                    {{-- <iframe src="{{ $item->video_url }}" frameborder="0"></iframe> --}}
                                @endif

                                <a role="button" class=" btn-modal"
                                    data-href="{{ action('EducationVideoController@show', [$item->id]) }}"
                                    data-container=".education_category_modal">
                                    <div class="box-body" style="padding: 10px;">
                                        <h4 style="height: 40px;  overflow: hidden;">{{ $item->name }}</h4>

                                        <p class="description" style="color:gray;height: 65px;overflow: hidden;">
                                            {{ $item->description }}
                                        </p>
                                    </div>
                                </a>

                            </div>
                        </div>
                    @endforeach
                </div>

            </section>
        </section>
    </div>

    <div class="modal fade education_category_modal" id="education_category_modal" tabindex="-1" role="dialog"
        aria-labelledby="gridSystemModalLabel"></div>
@endsection

@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>

    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        $(document).on('click', '.btn-modal', function(e) {
            e.preventDefault();
            var container = $(this).data('container');
            // alert(container);
            $.ajax({
                url: $(this).data('href'),
                dataType: 'html',
                success: function(result) {
                    $(container)
                        .html(result)
                        .modal('show');
                },
            });
        });
    </script>
@endsection
