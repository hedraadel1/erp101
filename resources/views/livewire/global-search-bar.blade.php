<div class="relative">
    <div style="margin-bottom:unset" class="form-group ">
        <input type="text" style="border-radius: 7px;" class="form-control " wire:model="query" id="global_search"
            placeholder="الذهاب الي ...">
    </div>


    @if (!empty($query))

        <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
            @if (!empty($items))
                @foreach ($items as $item)
                    {{ $item->username }}
                    <hr>
                @endforeach
            @else
                <div class="list-item">لا توجد نتائج</div>
            @endif
        </div>
    @endif


</div>
