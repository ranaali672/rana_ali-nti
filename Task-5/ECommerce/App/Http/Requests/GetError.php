<?php
namespace App\Http\Requests;
class GetError {
    public static function message(string $message) :string
    {
        return str_replace('_',' ',$message);
    }
}