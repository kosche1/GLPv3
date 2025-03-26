@props(['progress' => 0, 'color' => 'emerald'])

<div class="w-full bg-neutral-700 rounded-full h-4 mb-4">
  <div class="bg-{{ $color }}-500 h-4 rounded-full transition-all duration-500 ease-out" style="width: {{ $progress }}%"></div>
</div>
<div class="text-sm text-{{ $color }}-400 font-medium">
  {{ round($progress) }}% Complete
</div> 