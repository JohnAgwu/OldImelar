@extends('layouts.business.layout')

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
                            <h5>Edit business</h5>
                            <span class="d-block m-t-5">Modify a <code>Business</code> information</span>
                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{ route('business.update', [$business->id]) }}" enctype="multipart/form-data">
                                @csrf

                                <edit-business business="{{ json_encode($business) }}" business-types="{{ json_encode($business_types) }}" social-accounts="{{ json_encode($social_accounts) }}"></edit-business>

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

    <script src="{{ asset('assets/js/business/edit-business.js') }}"></script>
@endpush