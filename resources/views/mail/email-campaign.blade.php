@php
$trackingImage = '<img src="' . route('tracking.openings', $mail) . '" style="display: none;" />';
@endphp

<x-mail::message>
    {!! $body !!}
    {{ __('Thanks') }},<br>
    {{ config('app.name') }}

    {!! $trackingImage !!}
</x-mail::message>
