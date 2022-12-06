<?php


namespace App\Repositories;

use App\Models\Product;


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
        array_push(
            $transactionArray,
            [
                'applications' => $productApplications->all()
            ]
        );
        array_push(
            $transactionArray,
            [
                'purchases' => $productPurchases->all()
            ]
        );
        return $transactionArray;
    }

    /**
     * Get all purchase transactions for a given product
     * Returns all purchase transactions in given ascending order
     * @param int $productId
     * @param string $orderType ('asc' or 'desc')
     * @return array
     */
    public function getPurchasesByProductOrderedByDate(int $productId, string $orderType): array
    {
        return $this->find($productId)->purchases()->orderBy('transaction_date', $orderType)->get();
    }

    //@TODO - Add 'quantity_applied' to purchases

}