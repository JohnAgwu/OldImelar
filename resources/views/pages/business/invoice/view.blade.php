
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Imelar :: Invoice</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="imelar"/>
    <meta name="keywords" content="imelar">
    <meta name="author" content="Canaan Etai" />

    {{--Opengraph--}}
    <meta property="og:image" content="{{ asset('assets/images/logo.png') }}" />
    <meta property="og:image:secure_url" content="{{ asset('assets/images/logo.png') }}" />
    <meta property="og:image:type" content="image/png" />
    {{--<meta property="og:image:width" content="400" />--}}
    {{--<meta property="og:image:height" content="300" />--}}
    <meta property="og:image:alt" content="IMELA LOGO" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material/css/materialdesignicons.min.css') }}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/animation/css/animate.min.css') }}">
    <!-- notification css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/notification/css/notification.min.css') }}">
    <!-- pnotify css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/pnotify/css/pnotify.custom.min.css') }}">
    <!-- pnotify-custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/pages/pnotify.css') }}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style type="text/css">
        @media print { body { -webkit-print-color-adjust: exact; } }

        table.table-bordered{
            border:3px solid #a389d4;
            margin-top:20px;
        }
        table.table-bordered > thead > tr > th:not(:last-child){
            border-right: 4px solid white;
        }
        table.table-bordered > tbody > tr {
            border:3px solid #a389d4;
        }
        table.table-bordered > tbody > tr > td {
            border-right: 4px solid white;
            border-left: 4px solid white;
        }
        .borderb {
            border-bottom: 2px solid #a389d4;
        }
    </style>

</head>

<body>


<div class="mt-3 ml-5" style="width: 1200px">

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

    <div class="card" id="invoice-base" invoice="{{ json_encode($invoice) }}">

        <div class="card-block mb-3 p-0 position-relative d-flex flex-column align-items-center">

            <div class="theme-bg2 w-100 text-right pr-2 pt-1" style="height: 30px;">
                <span class="text-white"
                      style="cursor:pointer;"
                      onclick="window.print()"
                ><i class="fa fa-print"></i></span>
            </div>

            <div class="theme-bg2 w-25 position-absolute d-flex align-items-center justify-content-center" style="height: 60px; border-radius: 0 0 50px 50px;">
                <h2 class="text-white">INVOICE</h2>
            </div>

        </div>

        <div class="d-flex">
            <div class="text-center p-3 w-25">
                <img src="{{ asset('storage/' . $invoice->business->logo)  }}" alt="Business Logo" height="100">
            </div>
            <div class="w-50"></div>

            <div class="w-25 mt-3">
                <div class="d-flex">
                    <div class="w-75 text-right">{{ $invoice->business->phone }}</div>
                    <div class="w-25 pl-3 text-left text-c-purple font-weight-bold">Phone</div>
                </div>
                <div class="d-flex">
                    <div class="w-75 text-right">{{ $invoice->business->email }}</div>
                    <div class="w-25 pl-3 text-left text-c-purple font-weight-bold">Email</div>
                </div>
                <div class="d-flex">
                    <div class="w-75 text-right">{{ $invoice->business->address }}</div>
                    <div class="w-25 pl-3 text-left text-c-purple font-weight-bold">Address</div>
                </div>
            </div>
        </div>

        <div class="card-block p-0 position-relative d-flex flex-column align-items-center">

            <div class="bg-white w-100 text-center" style="height: 55px; border-bottom: 2px solid #a389d4;">
                @if ( $invoice->payment_status != 'FULLY PAID')
                    @if ( $invoice->payment_option == 'AUTOMATIC')
                        @if(sizeof($debitCards) > 0)
                            <span class="text-success">Amount due will be automatically debited on payment due date</span>
                        @else
                            @if(auth()->check())
                                <button id="link-card" class="btn text-white label bg-info btn-shadow mb-5">Add A Debit Card</button>
                            @else
                                <a href="{{ route('business.invoices.login', [$invoice->business_id, $invoice->id]) }}" class="btn text-white label bg-primary btn-shadow mb-5">Login to add card</a>
                            @endif
                        @endif
                    @else
                        <button id="make-payment" class="btn text-white label theme-bg2 btn-shadow mb-5">Make Payment</button>
                    @endif
                @endif
            </div>


            <div class="bg-white w-25 position-absolute d-flex align-items-end justify-content-center" style="height: 35px; border-radius: 0 0 50px 50px; z-index: 10;border-bottom: 2px solid #a389d4;top: 52px;border-right: 2px solid #a389d4;border-left: 2px solid #a389d4;">
                <h5 class="text-c-purple font-weight-bold pb-1">
                    @if ( $invoice->payment_status == 'FULLY PAID')
                        <span class="label theme-bg btn-shadow text-white font-weight-bold">{{ $invoice->payment_status }}</span>
                    @else
                        Total Due: <span class="autoCurrency">{{ $invoice->products_sum - $invoice->amount_paid }}</span>
                    @endif
                </h5>
            </div>

        </div>

        <div class="d-flex">
            <div class="w-25 text-center p-3 pl-5">
                <div class="theme-bg2">
                    <h4 class="text-white font-weight-bold p-1">INVOICE DETAILS</h4>
                </div>
                <div>
                    <div class="d-flex">
                        <div class="w-50 text-left font-weight-bold">INVOICE NO</div>
                        <div class="w-50 text-left font-weight-bold">#{{ str_pad($invoice->id, 8, 0, STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="d-flex">
                        <div class="w-50 text-left font-weight-bold">INVOICE DATE</div>
                        <div class="w-50 text-left font-weight-bold">{{ $invoice->created_at->format('d M, Y') }}</div>
                    </div>
                    <div class="d-flex">
                        <div class="w-50 text-left font-weight-bold">DUE DATE</div>
                        <div class="w-50 text-left font-weight-bold">{{ $invoice->payment_due_date ? $invoice->payment_due_date->format('d M, Y') : "N/A" }}</div>
                    </div>
                </div>
            </div>

            <div class="w-50"></div>

            <div class="w-25 mt-3 pr-5">
                <div class="theme-bg2 text-center">
                    <h4 class="text-white p-1 font-weight-bold">INVOICE TO</h4>
                </div>
                <div class="text-right">
                    <h4 class="font-weight-bold">{{ $invoice->customer->user->name }}</h4>
                </div>
                <div class="text-right">
                    <h6>{{ $invoice->customer->user->email }}</h6>
                </div>
                <div class="text-right">
                    <h6>{{ $invoice->customer->user->phone }}</h6>
                </div>
            </div>
        </div>

        <div class="mt-2">
            @if($invoice->business->isFreelance() )
                <table class="table table-bordered table-striped">
                    <thead class="theme-bg2">
                    <tr class="text-white">
                        <th class="text-center font-weight-bold">S/N</th>
                        <th class="font-weight-bold">ITEM TITLE</th>
                        <th class="font-weight-bold text-center">STATUS</th>
                        <th class="font-weight-bold text-center">PRICE</th>
                        <th class="font-weight-bold text-center">AMOUNT PAID</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice->projects as $index => $p)
                        <tr>
                            <td class="text-center">{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                            <td><h6 class="font-weight-bold">{{ $p->project->title }}</h6></td>
                            <td class="text-center"><span class="badge badge-info">{{ $p->project->status }}</span></td>
                            <td class="text-center autoCurrency">{{ $p->price }}</td>
                            <td class="text-center autoCurrency">{{ $invoice->amount_paid }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <table class="table table-bordered table-striped">
                    <thead class="theme-bg2">
                    <tr class="text-white">
                        <th class="text-center font-weight-bold">S/N</th>
                        <th class="font-weight-bold">ITEM DESCRIPTION</th>
                        <th class="font-weight-bold text-center">QTY</th>
                        <th class="font-weight-bold text-center">UNIT PRICE</th>
                        <th class="font-weight-bold text-center">PRICE</th>
                        <th class="font-weight-bold text-center">AMOUNT PAID</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice->products as $index => $product)
                        <tr>
                            <td class="text-center">{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <h5 class="font-weight-bold">{{ $product->product->name }}</h5>
                                <div class="text-wrap">{{ $product->product->description }}</div>
                            </td>
                            <td class="text-center autonumber">{{ $product->quantity }}</td>
                            <td class="text-center autoCurrency">{{ $product->amount / $product->quantity }}</td>
                            <td class="text-center autoCurrency">{{ $product->amount }}</td>
                            <td class="text-center autoCurrency">{{ $invoice->amount_paid }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="ml-3">
            <div class="d-flex">
                {{--33.333333% col-sm-4--}}
                <div style="width: 33.333333%" class="mt-5 mb-5">
                    <div>
                        <h5 class="text-c-purple font-weight-bold">Bank Information</h5>
                        @foreach ( $invoice->business->banks as $index => $bank )
                            <div class="@if($index !== 0) mt-3 @endif">
                                <div class="d-flex">
                                    <div class="w-50 text-left">Bank</div>
                                    <div class="w-50 text-left">{{ $bank->name }}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="w-50 text-left">Account Name</div>
                                    <div class="w-50 text-left">{{ $bank->account_name }}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="w-50 text-left">Account Number</div>
                                    <div class="w-50 text-left">{{ $bank->account_number }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5">
                        <h5 class="text-c-purple font-weight-bold">Payment Methods</h5>
                        <div class="text-left mb-3">VISA, MASTERCARD, VERVE, BANK, GT 737</div>

                        @if ( $invoice->payment_status == 'FULLY PAID')
                            <span class="label theme-bg btn-shadow text-white font-weight-bold">{{ $invoice->payment_status }}</span>
                        @else
                        <div class="bg-white w-100 mt-3">
                            <button id="make-payment" class="btn text-white label theme-bg2 btn-shadow mb-2">Make Payment</button>
                        </div>
                        @endif
                    </div>
                </div>

                {{--25%  col-sm-3--}}
                <div class="w-25"></div>

                {{--41.666667% col-sm-5--}}
                <div class="pr-5" style="width: 41.666667%">
                    <div class="d-flex p-2 borderb">
                        <div class="w-50 text-right">TOTAL PAID</div>
                        <div class="w-50 text-center autoCurrency">{{ $invoice->amount_paid ?? 0 }}</div>
                    </div>

                    <div class="d-flex p-2 borderb">
                        <div class="w-50 text-right">TOTAL DUE</div>
                        <div class="w-50 text-center autoCurrency">{{ $invoice->products_sum - $invoice->amount_paid }}</div>
                    </div>

                    <div class="d-flex p-2 borderb">
                        <div class="w-50 text-right">LESS DISCOUNT</div>
                        <div class="w-50 text-center">₦0.00</div>
                    </div>

                    <div class="d-flex p-2 borderb theme-bg2">
                        <div class="w-50 text-right">
                            <h4 class="text-white">GRAND TOTAL</h4>
                        </div>
                        <div class="w-50 text-center">
                            <h4 class="text-white autoCurrency">{{ $invoice->products_sum}}</h4>
{{--                            <h4 class="text-white autoCurrency">{{ $invoice->products->sum('amount') - $invoice->amount_paid }}</h4>--}}
                        </div>
                    </div>


                    <div class="mt-5 text-center">
                        @if($invoice->business->signature != null)
                            <img src="/assets/images/business/signature/business.jpg" >
                        @else
                            <h6 class="italic">SIGN</h6>
                        @endif
                        <h4>{{ $invoice->business->user->name }}</h4>
                        <h6>Account Manager</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-block p-0 position-relative d-flex flex-column align-items-center">
            <div class="theme-bg2 w-25 position-absolute d-flex align-items-center justify-content-center" style="height: 35px; border-radius:50px 50px 0 0; bottom: 0;">
                <p class="text-center text-white mt-3">Thank you for you patronage</p>
            </div>

            <div class="theme-bg2 w-100 text-right pr-2" style="height: 25px;">
                <a href="{{env('APP_URL')}}" target="_blank">
                    <small class="text-white">Powered by {{ strtoupper(env('APP_NAME')) }}</small>
                </a>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('assets/plugins/jquery/js/jquery.min.js') }}"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
<script src="{{ asset('assets/js/pages/invoice-view.js') }}"></script>
</body>

</html>
