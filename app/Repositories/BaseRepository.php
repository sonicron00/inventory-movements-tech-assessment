<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Abstract Class BaseRepository
 *
 * @category Abstract
 * @package  Box\Repositories
 */
abstract class BaseRepository
{
    /*
    |--------------------------------------------------------------------------
    | Base Repository
    |--------------------------------------------------------------------------
    |
    | This repository is responsible for the base methods that all the extending
    | repositories use. The model that is being accessed by the extending repo
    | should be passed in via a parent call to the constructor.
    |
    */

    /**
     * The model being accessed, passed in via the constructor.
     *
     * @var Model $model
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param Model $model - The model being accessed
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /*
    |--------------------------------------------------------------------------
    | Model returning methods
    |--------------------------------------------------------------------------
    |
    | These methods return an instance or instances of the model.
    |
    */

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param int $id - ID to find record for
     *
     * @return mixed
     * @throws ModelNotFoundException
     *
     * @example $id = 1;
     *
     */
    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Return count of all records.
     *
     * @return int
     */
    public function allCount(): int
    {
        return $this->model->all()->count();
    }

    /**
     * Return all records.
     *
     * @return mixed
     */
    public function all(): mixed
    {
        return $this->model->all();
    }

    public function allWithRelation(string $relation): array
    {
        return $this->model->with($relation)->get()->all();
    }

    /**
     * Return the first matched row or create a new one
     *
     * @param array $attributes - Attributes to search on
     * @param array $values - Values to store
     *
     * @return mixed
     * @example $values = ['column' => 'value', 'column1' => 'value1'...
     *
     * @example $attributes = ['column' => 'value'];
     */
    public function firstOrCreate(array $attributes, array $values)
    {
        return $this->model->firstOrCreate($attributes, $values);
    }

    /*
    |--------------------------------------------------------------------------
    | Model creating methods
    |--------------------------------------------------------------------------
    |
    | These methods create an instance of the model.
    |
    */

    /**
     * Update the first found record or create the record for the first time.
     *
     * @param array $attributes - Attributes to search on
     * @param array $values - Values to store
     *
     * @return mixed
     * @example $values = ['column' => 'value', 'column1' => 'value1'...
     *
     * @example $attributes = ['column' => 'value'];
     */
    public function updateOrCreate(array $attributes, array $values)
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * Save a new model and return the instance.
     *
     * @param array $attributes - Data to store
     *
     * @return mixed
     * @example $attributes = ['column' => 'value'...
     *
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

}
