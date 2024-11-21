@extends('layouts.user.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->

                <div class="row">
                    <div class="col">
                        <div class="card Recent-Users">
                            <div class="card-header">
                                <h5>Wallet Top Up</h5>
                                <div class="card-header-right">
                                    <div class="btn-group card-option">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="feather icon-more-horizontal"></i>
                                        </button>
                                        <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                            <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                            <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                            <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>
                                            <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <form method="POST" action="{{ route('wallet.topup') }}" id="topup-form">
                                    @csrf

                                    <div class="row form-group">

                                        <!--Amount-->
                                        <div class="col-sm-12">
                                            <label class="col-form-label">Amount</label>
                                            <input type="number" name="amount" class="form-control" value="1000" step="0.01" min="1000" max="50000">
                                        </div>
                                    </div>

                                    <!-- SUBMIT BUTTON-->
                                    <div class="row">
                                        <div class="col-sm-12 text-center mt-5">
                                            <button class="btn text-white label theme-bg btn-shadow">
                                                <i class="fa fa-paper-plane"></i>
                                                <b>Top up</b>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
    </div>
@endsection


@push('head')

@endpush
@push('script')
    <script src="https://js.paystack.co/v1/inline.js"></script>

    <script>
        $(function () {
            var form = $('#topup-form');
            form.on('submit', function (e) {
                e.preventDefault();
                form.off();

                var amount = $('[name="amount"]').val();
                var charge = 0;
                if ( amount < 2500 ) {
                    charge = (0.015 * amount) + 10
                }
                else {
                    charge = (0.0152 * amount) + 120
                }

                amount = (parseFloat(amount) + charge) * 100;

                var handler = PaystackPop.setup({
                    key: '{{ $paystack_key }}',
                    email: '{{ auth()->user()->email }}',
                    amount: amount,
                    currency: "NGN",
                    metadata: {
                        custom_fields: [
                            {display_name: "Wallet Id", variable_name: "wallet_id", value: {{ auth()->user()->wallet->id }}},
                            {display_name: "User Id", variable_name: "user_id", value: {{ auth()->user()->id }}}
                        ]
                    },
                    callback: function(response){
                        form.append('<input type="hidden" name="reference" value="' + response.reference +'" />');
                        form.submit();
                    },
                    onClose: function(){
                        // alert('window closed');
                    }
                });
                handler.openIframe();
            })
        })
    </script>
@endpush
