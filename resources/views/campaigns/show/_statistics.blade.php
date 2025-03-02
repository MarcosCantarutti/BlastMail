<div class="gap-4 flex-col flex">
    <x-alert no-icon success :title="__('Your campaign was sent to the first 10 subscribers on the first list')" />


    <div class=" grid grid-cols-3 gap-5 text-white">

        <x-dashboard.card heading="01" subheading="{{__('Open')}}" />

        <x-dashboard.card heading="02" subheading="{{__('Uniques')}}" />

        <x-dashboard.card heading="20%" subheading="{{__('Open rate')}}" />

        <x-dashboard.card heading="0" subheading="{{__('Clicks')}}" />

        <x-dashboard.card heading="0" subheading="{{__('Unique Clicks')}}" />

        <x-dashboard.card heading="20%" subheading="{{__('Clicks rate')}}" />

    </div>

</div>
