<div class="flex flex-col gap-4">

    <x-alert success :title="__('Your Campaign is ready to be send!')" />

    <div>
        <div>De:</div>
        <div>Para:</div>

        <div>Assunto: {{$data['subject']}}</div>

        <div>Template:</div>
    </div>

    <hr />
    <div x-data="{show: '{{data_get($data, 'send_when', 'now')}}' }">
        <x-input-label :value="__('Schedule delivery')" />
        <div class="flex flex-col gap-2">
            <x-input.radio id="send_now" name='send_when' value='now' x-model='show'>{{__('Send now')}}</x-input.radio>
            <x-input.radio id="send_later" name='send_when' value='later' x-model='show'>{{__('Schedule delivery')}}
            </x-input.radio>
        </div>


        <div x-show="show == 'later'">
            <x-input.text id="send_at" class="block mt-1 w-full" name="send_at"
                :value="old('send_at', $data['send_at'])" type='date' autofocus />
            <x-input-error :messages="$errors->get('send_at')" class="mt-2" />
        </div>
    </div>

</div>

<div class="flex items-center space-x-4">
    <x-button.link secondary :href="route('campaigns.index')">
        {{__('Cancel')}}
    </x-button.link>

    <x-button.primary type="submit">
        {{__('Save')}}
    </x-button.primary>
</div>