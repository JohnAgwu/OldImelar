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
                            <h5>Edit Message</h5>
                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{ route('business.update-message', [$business->id, $message->id]) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row form-group">

                                    <!--Channel-->
                                    <div class="col-sm-12">
                                        <label class="col-form-label">Channel</label>
                                        <select name="channel" class="form-control">
                                            <option @if($message->channel === 'EMAIL') selected @endif value="EMAIL">Email</option>
                                            <option @if($message->channel === 'SMS') selected @endif value="SMS">SMS</option>
                                            <option @if($message->channel === 'WHATSAPP') selected @endif value="WHATSAPP">WhatsApp</option>
                                        </select>
                                    </div>

                                    <!--Message-->
                                    <div class="col-sm-12">
                                        <label class="col-form-label">Message</label>
                                        <textarea name="message" class="form-control max-textarea" maxlength="140" rows="4" autofocus>{{ $message->message }}</textarea>
                                    </div>

                                </div>

                                <!-- SUBMIT BUTTON-->
                                <div class="row">
                                    <div class="col-sm-12 text-center mt-5">
                                        <button class="btn text-white label theme-bg btn-shadow">
                                            <i class="fa fa-paper-plane"></i>
                                            <b>Submit</b>
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- bootstrap-maxlength Js -->
    <script src="{{ asset('assets/plugins/bootstrap-maxlength/js/bootstrap-maxlength.min.js') }}"></script>

    <script>
        (function () {
            $('textarea.max-textarea').maxlength({
                alwaysShow: true
            });
        })();
    </script>
@endpush