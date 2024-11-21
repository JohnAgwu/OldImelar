@extends('layouts.business.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card User-Activity">
                            <div class="card-header">
                                <h5>BANK ACCOUNTS</h5>
                                <div class="card-header-right">
                                    {{--<div class="btn-group card-option">--}}
                                    <div class="card-option">
                                        <a class="text-white label theme-bg btn-shadow" href="{{ route('business.settings.add.bank', ['id' => $business->id]) }}">
                                            <i class="fa fa-plus"></i>
                                            <b class="d-none d-sm-inline">Add Bank</b>
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

                            <div class="card-block pb-0">
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
                                        <thead>
                                        <tr>
                                            <th>Account Name</th>
                                            <th>Account Number</th>
                                            <th>Bank</th>
                                            <th>Date Added</th>
                                            <th class="text-right"></th>
                                        </tr></thead>
                                        <tbody>

                                        @foreach( $business->banks as $bank )
                                            <tr>
                                                <td>
                                                    <h6 class="m-0">{{ $bank->account_name }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $bank->account_number }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $bank->name }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $bank->created_at->format('M jS, Y') }}</h6>
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{ route('business.settings.edit.bank', [$business->id, $bank->id]) }}" class="text-white label theme-bg2 f-12 btn-shadow">Edit</a>
                                                    <a href="{{ route('business.settings.delete.bank', [$business->id, $bank->id]) }}" class="text-white label theme-bgo f-12 btn-shadow">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach


                                        </tbody>
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


@push('head')

@endpush
@push('script')
    <script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
    <script>
        $(document).ready(function() {
            AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
            AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0})
            // $('.autonumber').autoNumeric('init');
        });
    </script>
@endpush