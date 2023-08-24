<div class="modal  fade" id="brand_store_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{ __('superadmin::lang.brand_store') }}
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@hideProduct') }}"
                method="post">
                @csrf
                <div class="modal-body">
                    <iframe style="width: 100%;height:400px"
                        src="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@getBrandStoreIfram') }}#Brand-Store"
                        frameborder="0"></iframe>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="submit" class="btn btn-info">عدم الظهور مرة
                    اخري</button> --}}
            </form>
        </div>
    </div>
</div>
