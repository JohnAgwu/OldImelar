@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ $business->name }}
        @endcomponent
    @endslot

    {{-- Body --}}
## Hi <em>{{ $customer->user->name }}</em>,

we now have more {{ $product->name }} available for you now.

You can order now or <a href="https://imela.com">__tell your friends__</a>.

<br>

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
