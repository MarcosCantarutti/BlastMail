<div>
    <x-input-label for="body" :value="__('Body')" />
    <x-input.richtext name="body" :value="old('body')" />
    <x-input-error :messages="$errors->get('body')" class="mt-2" />
</div>