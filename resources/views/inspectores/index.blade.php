@extends('layouts.app')

@section('content')
    {{-- Renderiza el componente Livewire. El componente se encarga de todo el contenido interno. --}}
    @livewire('inspectores-table')
@endsection
