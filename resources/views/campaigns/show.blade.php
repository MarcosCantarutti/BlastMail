<x-layouts.app>
    {{-- @dd($what) --}}
    <x-slot name="header">
        <x-h2>
            <a class="hover:underline" href="{{route('campaigns.index')}}">{{ __('Campaigns') }}</a> > {{
            $campaign->name }} > {{
            __(str($what)->title()->toString) }}
        </x-h2>
    </x-slot>


    <x-card>

        <div>{{ $campaign->description }}</div>

        <x-tabs :tabs="[
            __('Statistics') => route('campaigns.show', ['campaign' => $campaign->id, 'what' => 'statistics']),
            __('Open') => route('campaigns.show', ['campaign' => $campaign->id, 'what' => 'open']),
            __('Clicked') => route('campaigns.show', ['campaign' => $campaign->id, 'what' => 'clicked']),
        ]">

            @include('campaigns.show._' . $what)

        </x-tabs>
    </x-card>
</x-layouts.app>
