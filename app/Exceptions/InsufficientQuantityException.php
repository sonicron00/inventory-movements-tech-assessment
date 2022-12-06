<?php


namespace App\Exceptions;

use Exception;

class InsufficientQuantityException extends Exception
{
    /**
     * Custom exception for quantity violations on product purchase applications
     * @since      Class available since Release 0.0.1
     */

    protected $message = 'Quantity to be applied exceeds the quantity on hand.';
}