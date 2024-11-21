@extends('layouts.user.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->
                @if(sizeof($businesses) < 1 )
                    <div class="text-center p-5 m-5">
                        <p class="text-black-50 f-20">
                            We have opened up channels to make starting and managing your small business very easy.
                        </p>
                        <p class="text-black-50 f-20">
                            You can now easily send invoices, understand and manage your customers or prospects, track your business performance, simplify sales and enjoy credit facilities.
                        </p>
                        <p class="text-black-50 f-20">
                            Start something now.
                        </p>

                        <a href="{{route('add-business')}}" class="btn btn-primary shadow-2 mt-5">Add your business</a>
                    </div>
                @else
                    <div class="row">
                        @foreach( $businesses as $index => $business )
                            <div class="col-md-6 col-xl-6">
                                <div class="card Active-visitor">
                                    <div class="card-block text-center">
                                        <a href="{{ route('business.edit', [$business->id]) }}" class="text-white label theme-bg2 f-12 btn-shadow position-absolute" style="top:0;left:0;">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="{{ route('business.delete', [$business->id]) }}" class="text-white label theme-bgo f-12 btn-shadow position-absolute" style="top:0;right:0;" id="delete-business">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                        <h5 class="mb-4 font-weight-bold">{{ $business->name }}</h5>
                                        <i class="fas fa-money-bill-alt f-30 text-c-green"></i>
                                        <h3 class="f-w-300 mt-3 font-weight-bold autoCurrency">{{ $business->total_income }}</h3>
                                        <span class="text-muted">Total sum of income</span>
                                        <div class="progress mt-4 m-b-40">
                                            <div class="progress-bar progress-c-theme"
                                                 role="progressbar" style="width: 100%; height:7px;"
                                                 aria-valuenow="75" aria-valuemin="0" aria-valuemax="1000000">
                                            </div>
                                        </div>
                                        <div class="row card-active">
                                            <div class="col-md-4 col-6">
                                                <h4>{{ $business->invoices()->count() }}</h4>
                                                <span class="text-muted">Invoice</span>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                @if($business->isFreelance())
                                                    <h4>{{ $business->projects()->count() }}</h4>
                                                    <span class="text-muted">Projects</span>
                                                @else
                                                    <h4>{{ $business->products()->count() }}</h4>
                                                    <span class="text-muted">Products</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <h4>{{ $business->customers()->count() }}</h4>
                                                <span class="text-muted">Customers</span>
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            <a href="{{ route('business.dashboard', ['id' => $business->id]) }}" class="btn btn-primary shadow-2 text-uppercase btn-block" style="max-width:150px;margin:0 auto;">Dashboard</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <!-- [ Main Content ] end -->
            </div>
        </div>
    </div>
@endsection


@push('head')

@endpush
@push('script')
    <!-- dashboard-custom js -->
    <script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="/assets/js/pages/dashboard-custom.js"></script>

    <script>
        $(document).on('click', '#delete-business', function (e) {
            e.preventDefault();

            swal({
                title: "Are you sure?",
                text: "Every data related to this business will be deleted as well & Once deleted, you will not be able to revert this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if ( willDelete ) {
                        window.location.href = $(this).attr('href');
                    }

                    return false;
                });
        })
    </script>
@endpush
