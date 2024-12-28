<?php

namespace App\Utils;

class Error
{
    public $message;
    public function __construct($error)
    {
        $this->message = $error;
    }
}

?>
