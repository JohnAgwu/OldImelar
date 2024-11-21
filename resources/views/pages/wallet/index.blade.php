@extends('layouts.user.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->

                <div class="row">
                    <!-- [ Wallet ] start -->
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-block">
                                @if (session('message'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                @endif


                                <h6 class="mb-4">Wallet ID: <b style="font-size: 20px">{{ $wallet->account_number }}</b></h6>
                                <h6 class="mb-4">Wallet Balance</h6>
                                <div class="row d-flex align-items-center">
                                    <div class="col-12">
                                        <h4 class="f-w-300 d-flex align-items-center m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>₦{{ number_format($wallet->balance, 2) }}</h4>
                                    </div>
                                </div>
                                <div class="progress m-t-30" style="height: 4px;">
                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <div class="row">
                                    <div class="mt-3">
                                        <a href="/wallet/topup" class="btn btn-block btn-primary">Top Up</a>
                                    </div>

                                    <div class="ml-2 mt-3">
                                        <a href="{{ route('wallet.transfers') }}" class="btn btn-block btn-info">Wallet Transfers</a>
                                    </div>

                                    <div class="col mt-3">
                                        <a href="{{ route('wallet.transfer-request') }}" class="btn btn-block bg-c-purple text-white">Transfer Requests</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Wallet ] end -->

                    <!-- [ Credit ] start -->
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="mb-4">Credit</h6>
                                <div class="row d-flex align-items-center">
                                    <div class="col-12">
                                        <h4 class="f-w-300 d-flex align-items-center m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>₦{{ number_format($wallet_credit, 2) }}</h4>
                                    </div>
                                </div>
                                <div class="progress m-t-30" style="height: 4px;">
                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Credit ] end -->

                    <!-- [ Debit ] start -->
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="mb-4">Debit</h6>
                                <div class="row d-flex align-items-center">
                                    <div class="col-12">
                                        <h4 class="f-w-300 d-flex align-items-center m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>₦{{ number_format($wallet_debit, 2) }}</h4>
                                    </div>
                                </div>
                                <div class="progress m-t-30" style="height: 4px;">
                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Debit ] end -->
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card Recent-Users">
                            <div class="card-header">
                                <h5>Recent Transaction</h5>
                                <div class="card-header-right">
                                    <div class="btn-group card-option">
                                        <a class=" pt-2" href="{{ route('wallet.transaction.all') }}">
                                            <b>View All</b>
                                        </a>

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
                            <div class="card-block px-0 py-3">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        @if($transactions->count() < 1 )
                                            <div class="text-center p-5">No Transaction to display</div>
                                        @else
                                            <thead>
                                            <th>Amount</th>
                                            <th>Prev Balance</th>
                                            <th>New Balance</th>
                                            <th>Type</th>
                                            <th>Info</th>
                                            <th>Date</th>
                                            </thead>

                                            <tbody>
                                            @foreach( $transactions as $transaction )
                                                <tr>
                                                    <td>₦{{ number_format($transaction->amount) }}</td>
                                                    <td>₦{{ number_format($transaction->prev_balance) }}</td>
                                                    <td>₦{{ number_format($transaction->new_balance) }}</td>
                                                    <td>{{ $transaction->type }}</td>
                                                    <td>{{ $transaction->info }}</td>
                                                    <td>{{ $transaction->created_at }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
    </div>
@endsection
