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
                                <h5>Transfer to Wallet</h5>
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
                                <form method="POST" action="{{ route('wallet.transfer') }}" id="topup-form">
                                    @csrf

                                    <div class="row form-group">

                                        <!--Wallet ID-->
                                        <div class="col-sm-12">
                                            <label class="col-form-label">Wallet ID</label>
                                            <input type="number" name="wallet_id" class="form-control" minlength="10" maxlength="10" required>
                                        </div>
                                    </div>

                                    <div class="row form-group">

                                        <!--Amount-->
                                        <div class="col-sm-12">
                                            <label class="col-form-label">Amount</label>
                                            <input type="number" name="amount" class="form-control" value="1000" step="0.01" min="100" max="10000000" required>
                                        </div>
                                    </div>

                                    <!-- SUBMIT BUTTON-->
                                    <div class="row">
                                        <div class="col-sm-12 text-center mt-5">
                                            <button class="btn text-white label theme-bg btn-shadow">
                                                <i class="fa fa-paper-plane"></i>
                                                <b>Transfer</b>
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
