@extends('layouts.user.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->
                <div>
                    <div class="card">
                        <div class="card-header">
                            <h5>Add business</h5>
                            <span class="d-block m-t-5">Add a new <code>Business</code></span>
                        </div>
                        <div class="card-block">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('business.store') }}" enctype="multipart/form-data">
                                @csrf

                                <add-business business-types="{{ json_encode($business_types) }}" social-accounts="{{ json_encode($social_accounts) }}" ip-info="{{ $ipinfo }}">
                                    <div class="mt-5 mb-5 text-center">
                                        <i class="text-black-50 fa fa-spinner fa-spin fa-3x"></i>
                                    </div>
                                </add-business>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')

@endpush
@push('script')

    <script src="{{ asset('assets/js/business/add-business.js') }}"></script>
@endpush