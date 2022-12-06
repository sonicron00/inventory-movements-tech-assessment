<?php


namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;


class ProductRepository extends BaseRepository
{
    /**
     * Product Repository
     * Data layer for products and product relational data
     * @since      Class available since Release 0.0.1
     */

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all transactions for a given product
     * Returns all application and purchase transactions
     * @param int $productId
     * @return array
     */
    public function getAllTransactionsByProduct(int $productId): array
    {
        $transactionArray = [];
        $productApplications = $this->find($productId)->applications();
        $productPurchases = $this->find($productId)->purchases();
        $transactionArray['applications'] = $productApplications->get();
        $transactionArray['purchases'] = $productPurchases->get();
        return $transactionArray;
    }

    /**
     * Get all purchase transactions for a given product
     * Returns all purchase transactions in given ascending order
     * @param int $productId
     * @param string $orderType ('asc' or 'desc')
     * @return Collection
     */
    public function getPurchasesByProductOrderedByDate(int $productId, string $orderType): Collection
    {
        return $this->find($productId)->purchases()->orderBy('transaction_date', $orderType)->get();
    }

    //@TODO - Add 'quantity_applied' to purchases

}