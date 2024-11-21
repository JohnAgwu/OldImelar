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
                                <h5>Wallet TO Wallet Transfers</h5>
                                <div class="card-header-right">

                                    <a class="btn btn-sm text-white bg-c-purple btn-shadow" href="{{ route('wallet.transfer') }}">
                                        <i class="fa fa-plus"></i>
                                        <b class="d-none d-sm-inline">Make Transfer</b>
                                    </a>


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
                            <div class="card-block px-0 py-3">
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


                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        @if($transfers->count() < 1 )
                                            <div class="text-center p-5">No Request to display</div>
                                        @else
                                            <thead>
                                            <th>User</th>
                                            <th>Wallet ID</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            </thead>

                                            <tbody>
                                            @foreach( $transfers as $transfer )
                                                <tr>
                                                    <td>{{ $transfer->wallet->user->name }}</td>
                                                    <td>{{ \App\Model\Wallet::find($transfer->to_wallet_id)->account_number }}</td>
                                                    <td>₦{{ number_format($transfer->amount) }}</td>
                                                    <td>{{ $transfer->status }}</td>
                                                    <td>{{ $transfer->created_at }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        @endif
                                    </table>

                                    <hr>
                                    {{ $transfers->links() }}
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
