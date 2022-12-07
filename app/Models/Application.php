<?php


namespace App\Models;


class Application extends Transaction
{
    /*
    * --------------------------------------------------------------------------
    * Application Model
    * --------------------------------------------------------------------------
    * Apply transaction model to applications table
    */
    protected string $table = 'applications';

    public array $fillable = [
        'transaction_date',
        'product_id',
        'quantity',
        'created_at',
        'updated_at'
    ];

}