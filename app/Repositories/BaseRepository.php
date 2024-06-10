<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return Cache::remember('all_'.class_basename($this->model), 60, function () {
            return $this->model->all();
        });
    }

    public function getById($id)
    {
        $record = $this->model->find($id);
        if(!$record){
            throw new ModelNotFoundException("There is no registered");
        }
        return $record;
    }

    public function save(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model->find($id);
        return $record->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
