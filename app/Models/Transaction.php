<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

abstract class Transaction extends Model
{
    /*
    * --------------------------------------------------------------------------
    * Transaction Base Model
    * Relationships: Products
    * --------------------------------------------------------------------------
    * This model is for extending to relevant transaction tables.
    */

    /*
     * Define relationship with product Many:1
     * @return BelongsTo
     */
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}