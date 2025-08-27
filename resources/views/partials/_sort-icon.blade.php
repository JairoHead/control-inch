{{-- resources/views/partials/_sort-icon.blade.php --}}
@props(['field'])

@php
    // Accede a las propiedades públicas del componente Livewire que incluye este parcial
    $sortField = $this->sortField ?? null;
    $sortDirection = $this->sortDirection ?? null;
@endphp

@if ($sortField === $field)
    @if ($sortDirection === 'asc')
        {{-- Flecha Arriba (Ascendente) --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    @else
        {{-- Flecha Abajo (Descendente) --}}
         <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    @endif
@else
    {{-- Icono neutral de ordenamiento (opcional) --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline ml-1 text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
    </svg>
@endif