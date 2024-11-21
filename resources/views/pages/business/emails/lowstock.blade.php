@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ $business->name }}
        @endcomponent
    @endslot

    {{-- Body --}}
## Hello {{ $business->user->name }},

Some of your products are running out of stock.

### Below is a list of product(s) low in stock:
@component('mail::table')
| Product Name                      | Quantity(s) in stock      |
| -------------                     |:-------------:|
@foreach($products as $product)
| {{$product->name}}             | {{number_format($product->quantity)}}      |
@endforeach
@endcomponent

Thank you.<br>

<br>

    {{-- Subcopy --}}
    {{--@slot('subcopy')--}}
        {{--@component('mail::subcopy')--}}
            {{--<!-- subcopy here -->--}}
        {{--@endcomponent--}}
    {{--@endslot--}}


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            @copy {{ date('Y') }} {{ env('APP_NAME') }} All rights reserved.
        @endcomponent
    @endslot
@endcomponent
