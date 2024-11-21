@extends('layouts.user.layout')

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
                                <h5>BUSINESSES</h5>
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

                            <div class="card-block pb-0">
                                <div class="table-responsive pb-5">
                                    <table id="invoice-received-table" class="display table dt-responsive nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Total Revenue</th>
                                            <th>Invoices</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Owner</th>
                                            <th>Address</th>
                                            <th>LGA</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th class="text-right"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $businesses as $business )
                                            <tr>
                                                <td>{{ $business->name }}</td>
                                                <td>{{ $business->invoices()->sum('amount_paid') }}</td>
                                                <td>{{ $business->invoices()->count() }}</td>
                                                <td>{{ $business->email }}</td>
                                                <td>{{ $business->Phone }}</td>
                                                <td>{{ $business->user->name }}</td>
                                                <td>{{ $business->address }}</td>
                                                <td>{{ $business->lga }}</td>
                                                <td>{{ $business->state }}</td>
                                                <td>{{ $business->country }}</td>
                                                <td>
{{--                                                    <a href="{{route('user.invoices.view', $invoice->id)}}" class="btn btn-sm theme-bg2 text-white">View</a>--}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    {{ $businesses->links() }}
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
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/datatables.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset('assets/plugins/data-tables/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
{{--    <script src="{{ asset('assets/js/pages/invoice.js') }}"></script>--}}
@endpush
