<?php


namespace App\Repositories;

use App\Models\Purchase;


class PurchaseRepository extends BaseRepository
{
    /**
     * Purchase Repository
     * Data layer for purchase transactions
     * @since      Class available since Release 0.0.1
     */

    public function __construct(Purchase $model)
    {
        parent::__construct($model);
    }

    //@TODO
    public function markPurchaseApplied(int $purchaseId)
    {

    }

}
