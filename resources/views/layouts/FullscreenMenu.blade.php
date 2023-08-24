<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .overlayhomescreen {
            height: 100%;
            width: 100%;
            display: none;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        .overlayhomescreen-content {
            position: relative;
            top: 15%;
            width: 100%;
            text-align: center;

        }

        .overlayhomescreen a {
            padding: 8px;
            text-decoration: none;
            font-size: 36px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .overlayhomescreen a:hover,
        .overlayhomescreen a:focus {
            color: #f1f1f1;
        }

        .overlayhomescreen .closebtn {
            position: absolute;
            top: 20px;
            right: 45px;
            font-size: 60px;
        }

        @media screen and (max-height: 450px) {
            .overlayhomescreen a {
                font-size: 20px
            }

            .overlayhomescreen .closebtn {
                font-size: 40px;
                top: 15px;
                right: 35px;
            }

        }
    </style>
</head>

<div id="myNav" class="overlayhomescreen">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="overlayhomescreen-content">
        <div class="row">
            @if (in_array('purchases', $enabled_modules))
                @if (auth()->user()->can('purchase.view') ||
                        auth()->user()->can('view_own_purchase'))
                    <div class="col-sm-3">
                        <a href="./purchases"> <button class="button-19" role="button">قسم المشتريات</button></a>
                    </div>
                @endif
            @endif
            <div class="col-sm-3">
                <a href="./sells"> <button class="button-19" role="button">قسم المبيعات</button></a>
            </div>

            @if (auth()->user()->can('product.view'))
                <div class="col-sm-3">
                    <a href="./products"> <button class="button-19" role="button">قسم المنتجات</button></a>
                </div>
            @endif
            @if (in_array('expenses', $enabled_modules) &&
                    (auth()->user()->can('all_expense.access') ||
                        auth()->user()->can('view_own_expense')))
                <div class="col-sm-3">
                    <a href="./expenses"> <button class="button-19" role="button">قسم المصاريف</button></a>
                </div>
            @endif
        </div>
        <div style="margin-top: 10px;" class="row">
            @if (auth()->user()->can('customer.view') ||
                    auth()->user()->can('customer.view_own'))
                <div class="col-sm-3">
                    <a href="./contacts?type=customer"> <button class="button-19" role="button">قسم
                            العملاء</button></a>
                </div>
            @endif
            @if (auth()->user()->can('supplier.view') ||
                    auth()->user()->can('supplier.view_own'))
                <div class="col-sm-3">
                    <a href="./contacts?type=supplier"> <button class="button-19" role="button">قسم
                            الموردين</button></a>
                </div>
            @endif
            @if (auth()->user()->can('user.view'))
                <div class="col-sm-3">
                    <a href="./users"> <button class="button-19" role="button">قسم المستخدمين</button></a>
                </div>
            @endif
            @if (auth()->user()->can('business_settings.access'))
                <div class="col-sm-3">
                    <a href="./business/settings"> <button class="button-19" role="button">اعدادات النشاط
                        </button></a>
                </div>
            @endif
        </div>
    </div>
</div>



<script>
    function openNav() {
        document.getElementById("myNav").style.display = "block";
    }

    function closeNav() {
        document.getElementById("myNav").style.display = "none";
    }
</script>
