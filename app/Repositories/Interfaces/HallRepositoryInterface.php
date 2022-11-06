<?php

namespace App\Repositories\Interfaces;

interface HallRepositoryInterface
{
    public function getById($id);
    public function delete($key, $value);
    public function search($key, $value);
}
