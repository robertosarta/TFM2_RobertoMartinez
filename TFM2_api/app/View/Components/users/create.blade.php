@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Usuario</h1>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div>
            <label>Nombre</label>
            <input type="text" name="name" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>Contraseña</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div>
            <label>Rol</label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="cliente">Cliente</option>
            </select>
        </div>

        <button type="submit">Crear Usuario</button>
    </form>
</div>
@endsection