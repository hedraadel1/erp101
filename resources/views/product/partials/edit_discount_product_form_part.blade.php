<div class="table-responsive">
    <table class="table table-bordered edit_discount_product table-condensed " id="edit_discount_product">

        <tr style="background: #111827 !important;color: white !important;">
            <th style="background: #111827 !important;color: white !important;">@lang('product.quantity_from')</th>
            <th style="background: #111827 !important;color: white !important;">@lang('product.quantity_to')</th>
            <th style="background: #111827 !important;color: white !important;">@lang('product.discount_type')</th>
            <th style="background: #111827 !important;color: white !important;">@lang('product.discount')</th>
            <th style="background: #111827 !important;color: white !important;">
                <button onclick="addRow()"type="button" class="btn btn-success btn-xs "><i
                        class="fa fa-plus"></i></button>
            </th>
        </tr>

        @foreach ($product_discount as $item)
            <tr>
                <th>
                    <input type="number" class="form-control" value="{{ $item->quantity_from }}"
                        name="discount_product[qun_from][]">
                </th>
                <th>
                    <input type="number" class="form-control" value="{{ $item->quantity_to }}"
                        name="discount_product[qun_to][]">
                </th>
                <th>
                    {!! Form::select('discount_product[discount_type][]', $discount_types, $item->discount_type, [
                        'class' => 'form-control',
                    ]) !!}

                </th>
                <th>
                    <input type="number" value="{{ $item->discount }}" class="form-control"
                        name="discount_product[discount][]">
                </th>
                <th>
                    <button type="button" onclick="deleteRow(this)" class="btn btn-danger btn-xs ">-</button>
                </th>
            </tr>
        @endforeach

    </table>
</div>

<script>
    function addRow() {
        var tableRow = document.getElementById("edit_discount_product");
        var row = tableRow.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        cell1.innerHTML = '<input type="number" class="form-control" required name="discount_product[qun_from][]">';
        cell2.innerHTML = '<input type="number" class="form-control" required name="discount_product[qun_to][]">';
        cell3.innerHTML =
            '<select name="discount_product[discount_type][]" required class="form-control " id="">  <option value="" selected disabled hidden>أختر </option><option value="percentage">نسبة مئوية</option><option selected value="fixed">ثابت</option></select>';
        cell4.innerHTML = '<input type="number" class="form-control" required name="discount_product[discount][]">';
        cell5.innerHTML =
            '<button type="button" onclick="deleteRow(this)"class = "btn btn-danger btn-xs " > - </button>';
    }

    function deleteRow(el) {
        $(el).parent().parent().remove();
    }
</script>
