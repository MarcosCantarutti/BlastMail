<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Email List') }}
        </x-h2>
    </x-slot>


    <x-card>

        @unless ($emailLists->isEmpty())
        <x-table :headers="['#',__('Email List'),__('# Subscribers'),__('Actions')]">
            <x-slot name="body">
                @foreach ($emailLists as $list)
                <tr>
                    <x-table.td>{{$list->id}}</x-table.td>
                    <x-table.td>{{$list->title}}</x-table.td>
                    <x-table.td>{{$list->subscribers()->count()}}</x-table.td>
                    <x-table.td>//</x-table.td>
                </tr>
                @endforeach
            </x-slot>
        </x-table>
        @endunless

    </x-card>
</x-layouts.app>