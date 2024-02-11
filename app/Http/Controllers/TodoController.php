<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    //

    public function index(){
        $titulo = 'Tareas';
        return view('todo.index')->with([
            'title' => $titulo
        ]);
    }

}
