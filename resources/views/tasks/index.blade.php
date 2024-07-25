@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div style="align-items: center" class="col-lg-12 margin-tb">
                <div>
                    <h4>
                        @auth
                            Bienvenido, {{ auth()->user()->name }}
                        @endauth
            
                    </h4>
                </div>
                <div class="pull-left">
                    <h2 class="mt-3">Tareas</h2>
                </div>
                <div class="pull-right">
                    
                    <!--<a class="btn btn-primary mt-3" href="{{ route('tasks.create') }}">Nueva Tarea</a>-->
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-3">
                <p>{{ $message }}</p>
            </div>
        @endif

        @if (auth()->check())
            <a href="/tasks/create" class="btn btn-outline-primary">Nueva Tarea</a>
        @else
            <div class="alert alert-warning" role="alert">
                Solo los usuarios registrados pueden crear una tarea.
            </div>
        @endif

        @if (!auth()->check())
            <div class="alert alert-danger" role="alert">
                Debe iniciar sesión para ver las tareas.
            </div>
        @endif


        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Prioridad</th>
                    <th>Descripcion</th>
                    <th>Completada</th>
                    <th>Usuario</th>
                    <th>Etiquetas</th>
                    <th>Acciones</th>
                    <th>Configuraciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->name }}</td>
                        <td>
                            @if ($task->priority == 'baja')
                                <span class="text-success">{{ $task->priority }}</span>
                            @elseif ($task->priority == 'media')
                                <span class="text-warning">{{ $task->priority }}</span>
                            @elseif ($task->priority == 'alta')
                                <span class="text-danger">{{ $task->priority }}</span>
                            @endif
                        </td>
                        <td>{{ $task->description }}</td>
                        <td>
                            @if ($task->completed)
                                <span class="badge bg-success">Completada</span>
                            @else
                                <span class="badge bg-danger">Pendiente</span>
                            @endif
                        </td>

                        

                        <td>{{ $task->user ? $task->user->name : 'Sin asignar' }}</td>





                        <td>
                            @foreach ($task->etiquetas as $etiqueta)
                                <span class="badge bg-primary">{{ $etiqueta->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <form action="{{ route('tasks.complete', $task->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary">Completar</button>
                            </form>
                        </td>
                        <td>

                            <a class="btn btn-primary" href="{{ route('tasks.edit', $task->id) }}">Editar</a>

                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
