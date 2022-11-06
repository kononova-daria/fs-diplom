<?php

namespace App\Repositories\Interfaces;

interface PlaceRepositoryInterface
{
    public function getById($id);
    public function delete($key, $value);
    public function search($key, $value);
}
