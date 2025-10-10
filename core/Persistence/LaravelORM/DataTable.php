<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class DataTable implements RepositoryInterface
{
    protected Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getById($id): Model
    {
        return $this->model->query()->find($id);
    }

    public function getAll(): Collection
    {
        return $this->model->query()->get();
    }
    public function persist($entity)
    {
        // TODO: Implement persist() method.
    }

    public function begin()
    {
        // TODO: Implement begin() method.
    }

    public function commit()
    {
        // TODO: Implement commit() method.
    }
}
