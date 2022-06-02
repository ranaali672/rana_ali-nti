<?php
namespace App\Database\Contracts;
interface ConnectTo  {
    function __construct();
    function __destruct();
}
