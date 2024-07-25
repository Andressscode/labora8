@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">Crear Nueva Tarea</div>

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

                        <form action="{{ route('tasks.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control" placeholder="Nombre">
                            </div>

                            <div class="mb-3">
                                <label for="priority" class="form-label">Prioridad</label>
                                <select name="priority" class="form-select">
                                    <option value="baja">Baja</option>
                                    <option value="media" selected>Media</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descripcion</label>
                                <textarea name="description" class="form-control" placeholder="descripcion"></textarea>
                            </div>

                            <div>
                                <label class="form-label" for="name">Usuario</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                </select>
                                @error('user_id')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <label for="etiquetas" class="col-md-4 col-form-label text-md-end">Etiquetas</label>
                                <div class="col-md-6">
                                    <select name="etiquetas[]" id="etiquetas" class="form-select" multiple>
                                        @foreach ($etiquetas as $etiqueta)
                                            <option value="{{ $etiqueta->id }}">{{ $etiqueta->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Crear Tarea
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
