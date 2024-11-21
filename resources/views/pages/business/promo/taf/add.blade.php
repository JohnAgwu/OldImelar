@extends('layouts.business.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->

                <div>
                    <div class="card">
                        <div class="card-header">
                            <h5>CREATE PROMO PAGE</h5>
                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{ route('business.settings.promotions.promopage.add', [$business->id]) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row form-group">
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Product Image 1</label>
                                        <input type="file" name="image1" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Product Image 2</label>
                                        <input type="file" name="image2" class="form-control" accept="image/*">
                                    </div>

                                </div>

                                <!-- SUBMIT BUTTON-->
                                <div class="row">
                                    <div class="col-sm-12 text-center mt-5">
                                        <button class="btn text-white label theme-bg btn-shadow">
                                            <i class="fa fa-paper-plane"></i>
                                            <b>Submit</b>
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- bootstrap-maxlength Js -->
    <script src="{{ asset('assets/plugins/bootstrap-maxlength/js/bootstrap-maxlength.min.js') }}"></script>

    <script>
        (function () {
            $('textarea.max-textarea').maxlength({
                alwaysShow: true
            });
        })();
    </script>
@endpush