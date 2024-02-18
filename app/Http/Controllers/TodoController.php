<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Prologue\Alerts\Facades\Alert;
use App\Models\Todo;
use Illuminate\Support\Arr;
use Throwable;
use App\Throwables\TodoNotFoundException;
use App\Throwables\TodoIsCompletedException;
use App\Http\Requests\UpdateTodoRequest;

class TodoController extends Controller
{
    //

    public function index(Request $request){
        $status = $request->get('status');
        $query = $request->get('query');
        // Eloquent\Collection
        // Todo::all();
        // Illuminate\Collection
        // Todo::get();
        // Eloquent\Builder;
        $todos = Todo::query();
        // select * from todos where (title like '%form%' or description like '%form%') and completed = 1
        if(!is_null($query))
        {
            $todos = $todos->where(function($builder) use ($query){
                return $builder->where('title', 'like', "%$query%")
                ->orWhere('description', 'like', "%$query%");
            });
        }
        if(!is_null($status))
        {
            $todos = $todos->where('completed', ((int) $status) === 1 );
        }
        $titulo = 'Tareas';
        return view('todo.index')->with([
            'title' => $titulo,
            'todos' => $todos->paginate(10)->appends([
                'status' => empty($status) ? '' : (int) $status,
                'query' => $query
            ]),
            'status' => empty($status) ? '' : (int) $status,
            'query' => $query
        ]);
    }

    public function add(){
        $titulo = 'Agregar tarea';
        return view('todo.add', [
            'title' => $titulo
        ]);
    }

    public function store(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->passes()){
            $todo_data = Arr::only($data, ['title','description']);
            Todo::create($todo_data);
            Alert::success('Elemento registrado correctamente')->flash();
            return redirect()->route('todo.index');
        }
        Alert::add('error', $validator->errors()->first())->flash();
        return redirect()->route('todo.add')->withInput($request->all());
    }

    public function complete(int $id){
        $todo = Todo::find($id);
        if($todo !== null)
        {
            if(!$todo->completed)
            {
                $todo->completed = true;
                $todo->save();
                Alert::success('Elemento completado correctamente')->flash();
                return redirect()->route('todo.index');
            }
            else
            {
                Alert::error('El elemento ya se encuentra completado')->flash();
                return redirect()->route('todo.index');
            }    
        }
        {
            Alert::error('Ocurrió un error al localizar el elemento')->flash();
            return redirect()->route('todo.index');
        }
    }

    public function update(int $id){
        try
        {
            $todo = Todo::where('id', $id)->first();
            throw_if(is_null($todo), TodoNotFoundException::class);
            throw_if($todo->completed, TodoIsCompletedException::class);
            $title = 'Editar tarea';
            return view('todo.change', compact('todo','title'));
        }
        catch(Throwable $e)
        {
            Alert::error($e->getMessage())->flash();
            return redirect()->route('todo.index');
        }
    }

    public function storeUpdate(UpdateTodoRequest $request, int $id){
        try
        {
            $todo = Todo::where('id', $id)->first();
            throw_if(is_null($todo), TodoNotFoundException::class);
            throw_if($todo->completed, TodoIsCompletedException::class);
            $todo->update($request->only(['title','description']));
            Alert::success('Elemento actualizado correctamente')->flash();
            return redirect()->route('todo.index');
        }
        catch(Throwable $e)
        {
            Alert::error($e->getMessage())->flash();
            return redirect()->route('todo.index');
        }
    }

    public function delete(int $id){
        try
        {
            $todo = Todo::where('id', $id)->first();
            throw_if(is_null($todo), TodoNotFoundException::class);
            $todo->delete();
            Alert::success('Elemento eliminado correctamente')->flash();
            return redirect()->route('todo.index');
        }
        catch(Throwable $e)
        {
            logger($e->getMessage());
            logger($e->getFile());
            logger($e->getLine());
            Alert::error($e->getMessage())->flash();
            return redirect()->route('todo.index');
        }
    }

}
