<div class="gap-4 flex-col flex">
    <x-alert no-icon success
        :title="__('Your campaign was sent to the first '.$query['total_subscribers'].' subscribers on the list: '.$campaign->emailList->title)" />


    <div class=" grid grid-cols-3 gap-5 text-white">

        <x-dashboard.card :heading="$query['total_openings']" subheading="{{__('Open')}}" />

        <x-dashboard.card :heading="$query['unique_openings']" subheading="{{__('Uniques')}}" />

        <x-dashboard.card heading="{{ $query['openings_rate'] }}%" subheading="{{__('Open rate')}}" />

        <x-dashboard.card :heading="$query['total_clicks']" subheading="{{__('Clicks')}}" />

        <x-dashboard.card :heading="$query['unique_clicks']" subheading="{{__('Unique Clicks')}}" />

        <x-dashboard.card heading="{{ $query['clicks_rate'] }}%" subheading="{{__('Clicks rate')}}" />

    </div>

</div>
