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
    protected $table = 'purchases';

    public $fillable = [
        'transaction_date',
        'product_id',
        'qty_purchased',
        'price',
        'qty_applied', // Added for future functionality of allocating inventory
        'created_at',
        'updated_at'
    ];

}