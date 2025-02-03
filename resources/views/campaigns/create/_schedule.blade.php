<div class="grid grid-cols-2 gap-4">
    <div>

        <x-input-label for="send_at" :value="__('Send at')" />
        <x-input.text id="send_at" class="block mt-1 w-full" name="send_at" :value="old('send_at', $data['send_at'])"
            type='date' autofocus />
        <x-input-error :messages="$errors->get('send_at')" class="mt-2" />

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