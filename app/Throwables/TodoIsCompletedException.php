<?php namespace App\Throwables;

use Exception;

class TodoIsCompletedException extends Exception {

    protected $messsage = 'La tarea ya se encuentra completada';

}