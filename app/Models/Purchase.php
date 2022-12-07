<?php


namespace App\Models;


class Purchase extends Transaction
{
    /*
    * --------------------------------------------------------------------------
    * Purchase Model
    * --------------------------------------------------------------------------
    * Apply transaction model to purchases table
    */
    protected string $table = 'purchases';

    public array $fillable = [
        'transaction_date',
        'product_id',
        'qty_purchased',
        'price',
        'qty_applied',
        'created_at',
        'updated_at'
    ];

}