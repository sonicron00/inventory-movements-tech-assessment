<?php


namespace App\Repositories;

use App\Models\Application;


class ApplicationRepository extends BaseRepository
{
    /**
     * Application Repository
     * Data layer for application transactions
     * @since      Class available since Release 0.0.1
     */

    public function __construct(Application $model)
    {
        parent::__construct($model);
    }

}