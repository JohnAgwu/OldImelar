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
                                <h5>TELL A FRIEND</h5>
                                <div class="card-header-right">
                                    {{--<div class="btn-group card-option">--}}
                                    <div class="card-option">
                                        <a class="text-white label btn-primary btn-shadow" href="{{ route('business.settings.promotions.add-promopage', [$business->id]) }}">
                                            <i class="fa fa-plus"></i>
                                            <b class="d-none d-sm-inline">Add Promo Page</b>
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

                                @if ( sizeof($pages) > 0 )
                                    <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Page ID</th>
                                            <th>Views</th>
                                            <th>Created</th>
                                            <th class="text-right"></th>
                                        </tr></thead>
                                        <tbody>

                                        @foreach( $pages as $page )
                                            <tr>
                                                <td>{{ strtoupper($page->ref) }}</td>
                                                <td class="text-wrap">
                                                    {{ $page->views }}
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $page->created_at->format('M jS, Y') }}</h6>
                                                </td>

                                                <td class="text-right">
                                                    <a href="/page/{{$page->ref}}" class="text-white label btn-primary f-12 btn-shadow" target="_blank">View</a>
                                                    <a href="{{ route('business.settings.promotions.promopage.edit', [$business->id, $page->id]) }}" class="text-white label theme-bg2 f-12 btn-shadow">Edit</a>
                                                    <a href="{{ route('business.settings.promotions.promopage.delete', [$business->id, $page->id]) }}" class="text-white label theme-bgo f-12 btn-shadow">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                    <div class="p-5 text-center">
                                        <h4>You have not added a default promo page.</h4>

                                        <a href="{{ route('business.settings.promotions.add-promopage', [$business->id]) }}" class="btn text-white label theme-bg btn-shadow">
                                            <i class="fa fa-plus"></i>
                                            <b>Add Promo Page</b>
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