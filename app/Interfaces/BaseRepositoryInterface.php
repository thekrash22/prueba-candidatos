<?php

namespace App\Interfaces;

interface BaseRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function save(array $data);
    public function update($id, array $data);
    public function delete($id);
}
