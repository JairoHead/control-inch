@extends('layouts.app')

@section('content')

    
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                
                {{-- Aquí llamamos al componente de Livewire que contiene la tabla --}}
                @livewire('admin.users-table')

            </div>
        </div>
    

@endsection

