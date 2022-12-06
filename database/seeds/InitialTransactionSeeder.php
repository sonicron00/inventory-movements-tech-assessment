<?php

use App\Models\Application;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InitialTransactionSeeder extends DatabaseSeeder
{
    /**
     * Load the example transactions provided, using the product created in the intial product seeder.
     * Read CSV file from database/data directory and create Application or Purchase transactions
     * accordingly based on the transaction type specified.
     * @return void
     */
    public function run()
    {
        $defaultProductId = DB::table('products')->latest('id')->first()->id;

        $tranCSVFile = fopen(base_path("database/data/FertiliserTransactions.csv"), "r");

        $firstLine = true;

        while (($data = fgetcsv($tranCSVFile, '', ",")) !== false) {
            if (!$firstLine) {
                $tranDate = $data[0];
                $quantity = $data[2];
                $price = $data[3];
                $tranType = $data[1];

                if ($tranType == 'Purchase') {
                    $this->createPurchase($defaultProductId, $quantity, $price, $tranDate);
                }

                if ($tranType == 'Application') {
                    $this->createApplication($defaultProductId, $quantity, $price, $tranDate);
                }
            }
            $firstLine = false;
        }

        fclose($tranCSVFile);
    }

    private function createApplication(int $productId, string $quantity, string $price, string $tranDate): void
    {
        Application::create(
            [
                'transaction_date' => Carbon::createFromFormat('d/m/Y', $tranDate),
                'product_id' => $productId,
                'quantity' => $quantity,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        );
    }

    private function createPurchase(int $productId, string $quantity, string $price, string $tranDate): void
    {
        Purchase::create(
            [
                'transaction_date' => Carbon::createFromFormat('d/m/Y', $tranDate),
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        );
    }

}