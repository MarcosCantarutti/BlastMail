@props(['heading' => $heading, 'subheading' => $subheading ])

<div class="border-2 border-slate-700 p-8 bg-slate-900 text-center rounded-xl">
    <div class="font-medium font-mono text-5xl">{{$heading}}</div>
    <div class="text-xl mt-1 opacity-80">{{$subheading}}</div>
</div>
