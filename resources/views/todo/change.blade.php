@extends('templates.layout')
@section('content')

    <div class="container">

        <h1>Formulario de editar</h1>

        <form action="{{ route('todo.store-update', $todo->id) }}" method="post">
            @csrf
            <div class="row mt-4">
                <label for="title" class="form-label col-2 text-end mt-2
                    @if($errors->has('title')) text-danger @endif">Title</label>
                <div class="col-10">
                    <input type="text" class="form-control" 
                        id="title" required name="title" value="{{ old('title', $todo->title) }}"
                        placeholder="Escriba el titulo de la tarea">
                </div>
            </div>
            <div class="row mt-4">
                <label for="description" class="form-label col-2 text-end mt-2 
                    @if($errors->has('description')) text-danger @endif">Description</label>
                <div class="col-10">
                    <textarea class="form-control" 
                        id="description" required name="description"
                        placeholder="Escriba el contenido de la tarea">{{old('description', $todo->description)}}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                </div>
            </div>
            <div class="row mt-4">
                <div class="offset-2 col-10">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('todo.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>

    </div>

    

@endsection