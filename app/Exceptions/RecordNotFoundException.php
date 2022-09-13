<?php

namespace App\Exceptions;

use App\Shared\Traits\HttpResponse;
use Exception;

class RecordNotFoundException extends Exception
{

    use HttpResponse;


    /**
     * RecordNotFoundException constructor.
     *
     * @param string|int|null $id           Resource Identifier
     * @param string          $resourceName Resource Name
     *
     * @return void
     */
    public function __construct($id=null, string $resourceName="resource")
    {
        $idDataMessage = null;
        if (!empty($id) && (is_string($id) || is_numeric($id))) {
            $idDataMessage = "with id {$id}";
        }

        parent::__construct("The {$resourceName} {$idDataMessage} was not found", 404);

    }//end __construct()


}//end class
