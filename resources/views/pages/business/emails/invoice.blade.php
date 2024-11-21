@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ $invoice->business->name }}
        @endcomponent
    @endslot

    {{-- Body --}}
## Hello {{ $invoice->customer->user->name }},

Thank you very much for your patronage.

### Below is a summary of your purchase:
@component('mail::table')
| Item Name                         | {{ $invoice->business->isFreelance() ? 'Price' : 'Quantity' }}      |
| -------------                     |:-------------:|
@if($invoice->business->isFreelance())
    @foreach($invoice->projects as $p)
        | {{$p->project->title}}             | N{{number_format($p->price)}}      |
    @endforeach
@else
    @foreach($invoice->products as $p)
        | {{$p->product->name}}             | {{number_format($p->quantity)}}      |
    @endforeach
@endif
@endcomponent

@component('mail::button', ['url' => $invoice->url . '?cid='. $customer->id])
    View Invoice
@endcomponent

{{--We look forward to doing more business together with you.<br>--}}

@foreach ( $invoice->business->social as $social )
@switch($social['type'])
@case('facebook')
{{--![Facebook]({{asset('assets/images/social-icon/facebook.png')}}){:height="36px" width="36px"}--}}
[<img style="margin-right:10px" src="{{asset('assets/images/social-icon/facebook.png')}}" width="30">]({{$social['value']}})
@break

@case('whatsapp')
[<img style="margin-right:10px" src="{{asset('assets/images/social-icon/whatsapp.png')}}" width="30">]({{$social['value']}})
@break

@case('instagram')
[<img style="margin-right:10px" src="{{asset('assets/images/social-icon/instagram.png')}}" width="30">]({{$social['value']}})
@break

@case('twitter')
[<img style="margin-right:10px" src="{{asset('assets/images/social-icon/twitter.png')}}" width="30">]({{$social['value']}})
@break

@case('youtube')
[<img src="{{asset('assets/images/social-icon/youtube.png')}}" width="30">]({{$social['value']}})
@break
@endswitch
@endforeach

<br>

We look forward to doing more business together with you. <br><br><br>

<div style="font-size:12px;">

<h4>Disclaimers for Imelar</h4>

<p style="font-size:10px;">All the information on this website - https://www.imelar.com - is published in good faith and for general information purpose only. www.imelar.com does not make any warranties about the completeness, reliability and accuracy of this information. Any action you take upon the information you find on this website (www.imelar.com), is strictly at your own risk. www.imelar.com will not be liable for any losses and/or damages in connection with the use of our website. Our Disclaimer was generated with the help of the [Disclaimer Generator](https://www.disclaimergenerator.net) and the [Terms and Conditions Template](https://www.termsandcondiitionssample.com).</p>

<p style="font-size:10px;">
    From our website, you can visit other websites by following hyperlinks to such external sites. While we strive to provide only quality links to useful and ethical websites, we have no control over the content and nature of these sites. These links to other websites do not imply a recommendation for all the content found on these sites. Site owners and content may change without notice and may occur before we have the opportunity to remove a link which may have gone 'bad'.
</p>

<p style="font-size:10px;">
    Please be also aware that when you leave our website, other sites may have different privacy policies and terms which are beyond our control. Please be sure to check the Privacy Policies of these sites as well as their "Terms of Service" before engaging in any business or uploading any information.
</p>

<h4>Consent</h4>
<p style="font-size:10px;">By using our website, you hereby consent to our disclaimer and agree to its terms.</p>


<h4>Update</h4>
<p style="font-size:10px;">Should we update, amend or make any changes to this document, those changes will be prominently posted here.</p>

</div>

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
