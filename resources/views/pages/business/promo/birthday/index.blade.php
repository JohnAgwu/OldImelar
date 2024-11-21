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
                                <h5>BIRTHDAY MESSAGE</h5>
                                <div class="card-header-right">
                                    {{--<div class="btn-group card-option">--}}
                                    <div class="card-option">
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

                                @if ( sizeof($messages) > 0 )
                                    <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Message</th>
                                            <th>Channel</th>
                                            <th>Created</th>
                                            <th>Last Modified</th>
                                            <th class="text-right"></th>
                                        </tr></thead>
                                        <tbody>

                                        @foreach( $messages as $message )
                                            <tr>
                                                <td class="text-wrap">
                                                    {{ $message->message }}
                                                </td>
                                                <td>
                                                    {{ $message->channel }}
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $message->created_at->format('M jS, Y') }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $message->updated_at->format('M jS, Y') }}</h6>
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{ route('business.edit-message', [$business->id, $message->id]) }}" class="text-white label theme-bg2 f-12 btn-shadow">Edit</a>
                                                    <a href="{{ route('business.delete-message', [$business->id, $message->id]) }}" class="text-white label theme-bgo f-12 btn-shadow">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>
                                @else
                                    <div class="p-5 text-center">
                                        <h4>You have not added a default birthday message.</h4>

                                        <a href="{{ route('business.settings.promotions.add-birthday-message-view', [$business->id]) }}" class="btn text-white label theme-bg btn-shadow">
                                            <i class="fa fa-plus"></i>
                                            <b>Add Message</b>
                                        </a>
                                    </div>
{{--                                        Wishing a cherished customer and friend a very happy birthday celebration. Thank you for contributing the growth and success of the business--}}
                                @endif
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