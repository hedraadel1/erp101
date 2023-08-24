@extends('layouts.app')
@section('title', __('lang_v1.supervisors'))

@section('content')
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">@lang('lang_v1.supervisors_section')
            </h3>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">


        @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.supervisors')])
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="all_supervisors_table" style="width: 100%;">
                    <thead>
                        <tr class="row-border blue-heading">
                            <th>اسم المشرف</th>

                            <th>@lang('lang_v1.options')</th>
                        </tr>
                    </thead>

                </table>


            </div>
            {{-- @endcan --}}
        @endcomponent
    </section>

    <div class="modal fade" id="user_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

@endsection

@section('javascript')


@endsection
