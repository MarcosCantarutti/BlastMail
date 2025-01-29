<div class="grid grid-cols-2 gap-4">
    <div>

        <x-input-label for="sent_at" :value="__('Sent at')" />
        <x-input.text id="sent_at" class="block mt-1 w-full" name="sent_at" :value="old('sent_at', $data['send_at'])"
            type='date' autofocus />
        <x-input-error :messages="$errors->get('sent_at')" class="mt-2" />

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