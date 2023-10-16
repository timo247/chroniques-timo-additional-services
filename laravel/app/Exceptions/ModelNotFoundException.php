<?php

namespace App\Exceptions;

use Exception;

class ModelNotFoundException extends Exception
{
    protected $message = 'L\'instance demandée n\'a pas été trouvée.';
}
