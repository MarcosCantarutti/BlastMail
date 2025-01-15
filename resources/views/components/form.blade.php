@props([
'post' => null,
'delete' => null,
'flat' => false
])

@php
$method = $post ? 'POST' : 'GET';
@endphp

<form {{ $attributes->class(['gap-4 flex flex-col' => !$flat]) }} method="{{$method}}">
    @if ($method != 'GET')
    @csrf
    @endif
    {{$slot}}
</form>