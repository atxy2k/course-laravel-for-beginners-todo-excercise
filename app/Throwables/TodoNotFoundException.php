<?php namespace App\Throwables;

use Exception;

class TodoNotFoundException extends Exception
{
    protected $messsage = 'Ocurrió un error al localizar la tarea seleccionada';
}