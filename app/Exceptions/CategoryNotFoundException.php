<?php

namespace App\Exceptions;

use App\Http\Traits\Responses_Trait;
use Exception;

class CategoryNotFoundException extends Exception
{
    use Responses_Trait;
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return $this->returnErrorMessage($this->getMessage(), 404);
    }
}
