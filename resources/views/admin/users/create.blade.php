@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 flex justify-center">
    <div class="w-full max-w-2xl">
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 sm:p-8">

                <div class="mb-6 pb-4 border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-center">Crear Nuevo Usuario</h1>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <p class="font-bold">¡Error de validación!</p>
                        <ul class="mt-1 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="form-label">Foto de Perfil <span class="text-gray-500 text-xs">(Opcional)</span></label>
                            <div class="mt-2 flex items-center gap-x-4">
                                <img 
                                id="photo_preview" 
                                src="{{ $user->profile_photo_path 
                                        ? Storage::url($user->profile_photo_path) 
                                        : asset('images/default-avatar.png') }}" 
                                alt="Vista previa" 
                                class="h-20 w-20 rounded-full object-cover bg-gray-200">
                                <div>
                                    <input id="photo" name="photo" type="file" class="form-input-file" accept="image/jpeg,image/png,image/jpg">
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG hasta 2MB.</p>
                                    @error('photo') <p class="form-error-message">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="name" class="form-label">Nombre <span class="text-red-500">*</span></label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-input w-full" required>
                        </div>
                        <div>
                            <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input w-full" required>
                        </div>
                        <div>
                            <label for="password" class="form-label">Contraseña <span class="text-red-500">*</span></label>
                            <input id="password" type="password" name="password" class="form-input w-full" required>
                        </div>
                        <div>
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-red-500">*</span></label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-input w-full" required>
                        </div>
                        <div>
                            <label for="role" class="form-label">Rol <span class="text-red-500">*</span></label>
                            <select name="role" id="role" class="form-select w-full" required>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Usuario</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                        </div>
                        <div>
                            <label for="is_active" class="form-label">Estado <span class="text-red-500">*</span></label>
                            <select name="is_active" id="is_active" class="form-select w-full" required>
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 space-x-3">
                        <a href="{{ route('admin.users.index') }}" class="form-button-secondary">Cancelar</a>
                        <button class="form-button-primary" type="submit">Guardar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('photo_preview');
        
        if (photoInput && photoPreview) {
            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endpush
@endsection