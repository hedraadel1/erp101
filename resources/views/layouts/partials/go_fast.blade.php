        <ul class="list-unstyled list-group" style="padding: 0px!important">
            {{-- <b class="h5">قسم المستخدمين</b> --}}
            {{-- @can('user.view')
                <a href="{{ action('ManageUserController@index') }}" class=" btn-block btn btn-xs bg-blue">
                    قسم المستخدمين
                </a>
                &nbsp;
            @endcan --}}
            @if (count($items) > 0)
                @foreach ($items as $item)
                    <li class="media" style="width: 100%  ;padding:10px;margin:0px;  border-bottom: 1px solid #c5c2c2;">
                        <a target="_blank" href="{{ $item->menu_url }}" class="list_search_item ">
                            <div class="" style="display:flex;justify-content: space-between;">
                                {{-- {{ dd($items) }} --}}
                                <b class="mt-0 mb-1">{{ optional($item)->menu_name }}
                                    {{-- <br><small>{{ $item->getRoleNameAttribute() }}</small> --}}
                                </b>

                            </div>
                        </a>
                    </li>
                @endforeach
            @else
                <br>
                <li class="list-item">
                    لا توجد نتائج
                </li>
            @endif
        </ul>
