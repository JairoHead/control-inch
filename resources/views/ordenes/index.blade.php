@extends('layouts.app')

@section('content')
    {{-- Renderiza el componente Livewire para Órdenes --}}
    @livewire('ordenes-table')
@endsection