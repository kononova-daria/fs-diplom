<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function getById($id);
    public function delete($key, $value);
    public function search($key, $value);
    public function filter($filters);
}
