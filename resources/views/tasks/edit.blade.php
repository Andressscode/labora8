@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">Editar Tarea</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>¡Vaya!</strong> Hubo algunos problemas con tu entrada.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="name" value="{{ $task->name }}" class="form-control"
                                    placeholder="Nombre">
                            </div>

                            <div class="mb-3">
                                <label for="priority" class="form-label">Prioridad</label>
                                <select name="priority" class="form-select">
                                    <option value="baja" @if ($task->priority == 'baja') selected @endif>Baja</option>
                                    <option value="media" @if ($task->priority == 'media') selected @endif>Media</option>
                                    <option value="alta" @if ($task->priority == 'alta') selected @endif>Alta</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descripcion</label>
                                <textarea name="description" class="form-control" placeholder="Descripcion">{{ $task->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="user_id" class="form-label">Usuario</label>
                                <select name="user_id" class="form-select">
                                    <option value="">Selecciona un usuario</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if ($task->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="completed" class="form-label">Completada</label>
                                <div class="form-check">
                                    <input type="hidden" name="completed" value="0">
                                    <input type="checkbox" name="completed" value="1" class="form-check-input"
                                        {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tags" class="col-md-4 col-form-label text-md-end">Etiquetas</label>
                                <div class="col-md-6">
                                    <select name="etiquetas[]" id="etiquetas" class="form-control" multiple>
                                        @foreach($etiquetas as $etiqueta)
                                        <option value="{{ $etiqueta->id }}" {{ $task->etiquetas->contains($etiqueta->id) ? 'selected' : '' }}>{{ $etiqueta->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Actualizar
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
