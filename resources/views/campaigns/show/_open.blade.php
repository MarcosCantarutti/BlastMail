<div class="space-y-4">

    <x-form action="{{route('campaigns.show', ['campaign' => $campaign, 'what' => $what]) }}" get>
        @csrf
        <x-input.text name="search" placeholder="{{__('Search an email...')}}" value="{{ $search }}" />
    </x-form>

    <x-table :headers="[__('Name'), __('# Openings'), __('Email')]">

        <x-slot name="body">
            <tr>
                <x-table.td>Jeremias</x-table.td>
                <x-table.td>1</x-table.td>
                <x-table.td>jeremias@teste.com</x-table.td>
            </tr>
        </x-slot>
    </x-table>


</div>
