<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    static function getById($id);
    static function delete($key, $value);
    static function search($key, $value);
}
