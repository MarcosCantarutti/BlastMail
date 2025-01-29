<div>
    <x-input-label for="body" :value="__('Body')" />
    <x-input.richtext name="body" :value="old('body', $data['body'])" />
    <x-input-error :messages="$errors->get('body')" class="mt-2" />
</div>


<div class="flex items-center space-x-4">
    <x-button.link secondary :href="route('campaigns.index')">
        {{__('Cancel')}}
    </x-button.link>

    <x-button.primary type="submit">
        {{__('Save')}}
    </x-button.primary>
</div>