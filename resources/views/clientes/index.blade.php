@extends('layouts.app')

@section('content')
    {{-- Renderiza el componente Livewire para Clientes --}}
    @livewire('clientes-table')
@endsection