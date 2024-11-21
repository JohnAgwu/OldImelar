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
                                <h5>CUSTOMERS</h5>
                                <div class="card-header-right">
                                    {{--<div class="btn-group card-option">--}}
                                    <div class="card-option">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-primary">Import from </span> <i class="fa fa-caret-down"></i>
                                        </button>
                                        <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                            <li class="dropdown-item reload-card">
                                                <a href="{{ route('business.customers.import', [$business->id, 'csv']) }}"><i class="fa fa-file-import"></i> CSV</a>
                                            </li>
{{--                                            <li class="dropdown-item reload-card">--}}
{{--                                                <a href="{{ route('business.customers.import', [$business->id, 'google']) }}"><i class="fa fa-file-import"></i> Google Contacts</a>--}}
{{--                                            </li>--}}
                                        </ul>


                                        <a class="text-white label btn-primary btn-shadow" href="{{ route('business.customers.create', [$business->id]) }}">
                                            <i class="fa fa-plus pr-2"></i>
                                            <b class="d-none d-sm-inline pr-2">Add a Customer</b>
                                        </a>
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
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Total Sales(count)</th>
                                            <th class="text-right"></th>
                                        </tr></thead>
                                        <tbody>

                                        @foreach( $customers as $customer )
                                            <tr>
                                                <td>
                                                    <h6 class="m-0">{{ $customer->user->name }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $customer->user->phone }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $customer->user->gender }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $customer->user->email }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $customer->user->invoices()->count() }}</h6>
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{ route('business.customers.edit', [$business->id, $customer->id]) }}" class="text-white label theme-bg2 f-12 btn-shadow">Edit</a>
                                                    <form method="POST" class="d-inline" action="{{ route('business.customers.destroy', [$business->id, $customer->id]) }}">
                                                        @method('DELETE')
                                                        @csrf

                                                        <button type="submit" class="text-white label theme-bgo f-12 btn-shadow" onclick="return confirm('Are you sure that you want to delete this customer?')">Delete</button>

                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>

                                {{ $customers->links() }}
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