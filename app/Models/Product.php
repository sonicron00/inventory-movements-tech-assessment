<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /*
    * --------------------------------------------------------------------------
    * Product Model
    * Relationships: Purchases, Applications
    * --------------------------------------------------------------------------
    * This model is for the products table.
    */

    protected string $table = 'products';

    public array $fillable = [
        'external_id', // Field to store external system reference if applicable
        'description',
        'created_at',
        'updated_at'
    ];

    /*
     * Define relationship with purchase transactions 1:Many
     * @return HasMany
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'product_id', 'id');
    }

    /**
     * Define relationship with application transactions 1:Many
     * @return HasMany
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'product_id', 'id');
    }

}