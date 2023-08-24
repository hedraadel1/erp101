@extends('cms::frontend.layouts.app')
@section('title', 'Home')
@includeIf('cms::frontend.layouts.home_header')
@section('meta')
    <meta name="description" content="{{ $page->meta_description }}">
@endsection
@section('content')
    @php
        $page_meta = $page->pageMeta->keyBy('meta_key');
    @endphp
    <!------------------------------>
    <!--Features---------------->
    <!------------------------------>
    @includeIf('cms::frontend.pages.partials.features', ['page_meta' => $page_meta])


    <!------------------------------>
    <!--Industries---------------->
    <!------------------------------>
    @includeIf('cms::frontend.pages.partials.industries', ['page_meta' => $page_meta])



    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{-- @include('cms::frontend.pages.ifram' , ['products'=>$products]) --}}
            </div>
        </div>
    </div>
    <!------------------------------>
    <!--Stats---------------->
    <!------------------------------>
    @includeIf('cms::frontend.pages.partials.statistics', ['statistics' => $statistics ?? []])

    <!------------------------------>
    <!--Testimonial---------------->
    <!------------------------------>
    @includeIf('cms::frontend.pages.partials.testimonial', ['testimonials' => $testimonials ?? []])

    <!------------------------------>
    <!--CTA---------------->
    <!------------------------------>
    @includeIf('cms::frontend.pages.partials.cta')

    <!------------------------------>
    <!--FAQ---------------->
    <!------------------------------>
    @includeIf('cms::frontend.pages.partials.faq', ['faqs' => $faqs ?? []])
@endsection
@section('javascript')
    <script type="text/javascript">
        new Sticky("[sticky]");
    </script>
@endsection
