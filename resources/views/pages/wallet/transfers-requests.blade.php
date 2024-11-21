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
                                <h5>Transfer Request</h5>
                                <div class="card-header-right">

                                    <a class="btn btn-sm text-white bg-c-purple btn-shadow" href="{{ route('wallet.transfer-request-view') }}">
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
                                @include('partials.message')
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        @if($transfers->count() < 1 )
                                            <div class="text-center p-5">No Request to display</div>
                                        @else
                                            <thead>
                                            <th>Amount</th>
                                            <th>Account Number</th>
                                            <th>Account Name</th>
                                            <th>Bank</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            @if(auth()->user()->hasRole('ADMIN'))
                                                <th><i class="fa fa-cogs"></i></th>
                                            @endif
                                            </thead>

                                            <tbody>
                                            @foreach( $transfers as $transfer )
                                                <tr>
                                                    <td>₦{{ number_format($transfer->amount) }}</td>
                                                    <td>{{ $transfer->account_number }}</td>
                                                    <td>{{ $transfer->account_name }}</td>
                                                    <td>{{ $transfer->bank_name }}</td>
                                                    <td>
                                                        @if ( $transfer->status == 'APPROVED')
                                                            <span class="badge badge-success">{{ $transfer->status }}</span>
                                                        @elseif( $transfer->status == 'DENIED' )
                                                            <span class="badge badge-danger">{{ $transfer->status }}</span>
                                                        @else
                                                            <span class="badge badge-warning">{{ $transfer->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $transfer->created_at }}</td>

                                                    @if(auth()->user()->hasRole('ADMIN'))

                                                        <td>
                                                            @if ( $transfer->status == 'PENDING' )
                                                                <a href="/wallet/transfer-requests/approve/{{ $transfer->id }}" class="btn btn-sm btn-success" onclick="return confirm('Are you sure that you want to approve this request?')">Approve</a>

                                                                <a href="/wallet/transfer-requests/deny/{{ $transfer->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure that you want to deny this request?')">Deny</a>
                                                            @endif
                                                        </td>
                                                    @endif
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
