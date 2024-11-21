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
                                <h5>Recent Transaction</h5>
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

                                    <hr>
                                    {{ $transactions->links() }}
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
