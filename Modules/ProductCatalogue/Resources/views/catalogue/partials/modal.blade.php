<div class="modal fade" id="AfterAddCart" tabindex="-1" role="dialog" aria-labelledby="AfterAddCart">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="popup_content modal-successful-cart">
                            <div class="popup-text">
                                <div class="heading_s3 text-center">
                                    <i class="ion-android-cart"></i>
                                    <h4>تم أضافة المنتج للعربة</h4>
                                </div>
                            </div>
                            <div class="me-5 ms-5">
                                <br>
                                <hr style="    height: 2px;width: 50%;margin: auto;">
                                <br>
                            </div>
                            <div class="row pt-3 pb-3">
                                <div class="col-sm-6">
                                    <div>
                                        <a class="btn  btn-style w3-block btn-block" href="{{route('product_catalogue.cart')}}"
                                            title="{{ __('lang.carts') }}">عربة التسوق</a>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div>
                                        <button type="button" class="btn  btnstyle w3-block" id="continueShopping"
                                            title="{{ __('lang.continue_shopping') }}">الاستمار في التسوق</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
