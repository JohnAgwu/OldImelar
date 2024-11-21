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
                            <h5>Edit Project</h5>
                        </div>
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

                            <form method="POST" action="{{ route('business.update.project', [$business->id, $project->id]) }}" enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf

                                <edit-project project="{{ $project }}"  payment-status="{{ $paymentStatus }}" purchase-expenses="{{ $projectExpenses }}">
                                    <div class="mt-5 mb-5 text-center">
                                        <i class="text-black-50 fa fa-spinner fa-spin fa-3x"></i>
                                    </div>
                                </edit-project>
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

    <!-- Input mask Js -->
    <script src="{{ asset('assets/plugins/inputmask/js/inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>

    <script src="{{ asset('assets/js/business/edit-project.js') }}"></script>
@endpush
