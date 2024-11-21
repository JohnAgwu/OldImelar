@extends('layouts.user.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->

                <div class="row">
                    <div class="col">
                        <div class="card Recent-Users">
                            <div class="card-header">
                                <h5>Transfer to Bank</h5>
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
                            <div class="card-block">
                                @include('partials.message')
                                <br/>
                                <h6 class="text-info text-bold font-weight-bold" id="chargeNotice"></h6>
                                <br/>
                                <form method="POST" action="{{ route('wallet.make-transfer-request') }}" id="transfer-request-form">
                                    @csrf

                                    <div class="row form-group">

                                        <!--Amount-->
                                        <div class="col-sm-12">
                                            <label class="col-form-label" for="amount">Amount</label>
                                            <input type="number"
                                                   name="amount" id="amount"
                                                   class="form-control"
                                                   value="1000" step="0.01" min="100"
                                                   max="10000000" required>
                                        </div>
                                    </div>

                                    <div class="row form-group">

                                        <!--Wallet ID-->
                                        <div class="col-sm-12">
                                            <label class="col-form-label">Bank</label>
                                            <select name="bank_id" class="form-control" required>
                                                @foreach($banks as $bank)
                                                    <option value="{{ $bank->id }}">{{ $bank->account_number . ' | ' .$bank->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- SUBMIT BUTTON-->
                                    <div class="row">
                                        <div class="col-sm-12 text-center mt-5">
                                            <button class="btn text-white label theme-bg btn-shadow">
                                                <i class="fa fa-paper-plane"></i>
                                                <b>Transfer</b>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
    </div>
@endsection
@push('script')
<script type="text/javascript">

    //helper function to get transfer charge
    function getCharge(amount) {
        let resp;
        $.ajax({
            url: '/wallet/get-transfer-charge/' + amount,
            type: 'GET',
            dataType: 'json',
            async: false,
            success : function(data) {
                resp = data;
            }, error : function(req, err) {
                //silent
            }
        });

        //safe check
        if( typeof resp !== "undefined") {
            return resp;
        } else { return 0}
    }

    /**
     * helper function to update message
     * @param response
     */
    function updateMessage(response)
    {
        let noticeBox = $('#chargeNotice'),
            message;
        message = "Charges for this transfer is ₦ " + response + ". Know that this will be charged from your wallet.";
        noticeBox.html(message);
    }

    //on page load, update charge and message
    $(document).ready(function () {
        let amountInput = $('#amount'),
            $response = getCharge(amountInput.val());
        //update notice
       updateMessage($response);
    });

    //on change of amount, update charge with message
    $('#amount').on('keyup', function() {
        let elem = $(this), $response;

        //safe check
        if( elem.val() && elem.val().length > 0) {
            $response = getCharge(elem.val());
        }else{$response = 0}

        //update message
        updateMessage($response);
    });
</script>
@endpush
