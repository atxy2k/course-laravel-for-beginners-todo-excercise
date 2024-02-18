@extends('templates.layout')
@section('content')

    <div class="container">
        <h1>
            Listado de tareas
            <a href="{{ route('todo.add') }}" class="btn btn-primary float-end">Agregar</a>
        </h1>

        <form action="{{ route('todo.index') }}" method="get" id="buscador">
            <div class="row mt-2 mb-2">
                <div class="col-4 offset-4">
                    <select name="status" id="status" class="form-control" onchange="document.getElementById('buscador').submit()">
                        <option value="">Cualquier estado</option>
                        <option value="1" {{ $status == 1 ? 'selected' : '' }}>Completadas</option>
                        <option value="2" {{ $status == 2 ? 'selected' : '' }}>No Completadas</option>
                    </select>
                </div>
                <div class="col-4">
                    <input type="text" value="{{ $query }}" class="form-control" name="query" placeholder="¿Que estás buscando?">
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titulo</th>
                        <th>Descripción</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($todos as $todo)
                        <tr>
                            <td>{{ $todo->id }}</td>
                            <td>{{ $todo->title }}</td>
                            <td>{{ $todo->description }}</td>
                            <td>
                                <span class="badge text-bg-{{ $todo->completed ? 'success' : 'primary' }}">
                                    {{ $todo->completed ? 'Completado' : 'Pendiente' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    @if(!$todo->completed)
                                        <a href="{{route('todo.complete', $todo->id)}}" class="btn btn-outline-success">Completar</a>
                                        <a href="{{ route('todo.update', $todo->id) }}" class="btn btn-outline-primary">Editar</a>
                                    @endif
                                    <a href="{{ route('todo.delete', $todo->id) }}" class="btn btn-outline-danger">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Aún sin elementos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $todos->links() }}
        </div>

    </div>


@endsection