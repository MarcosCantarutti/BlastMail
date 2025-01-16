@props([
'danger' => null
])
<span {{$attributes->class([
    'rounded-md w-fit border px-2 py-1 text-xs font-medium text-white dark:text-white',
    ' border-red-500 bg-red-500 dark:border-red-500 dark:bg-red-500 "' => $danger
    ])}}
    >
    {{$slot}}
</span>