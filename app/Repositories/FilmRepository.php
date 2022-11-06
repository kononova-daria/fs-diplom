<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\FilmRepositoryInterface;

class FilmRepository implements FilmRepositoryInterface
{
    private const TABLE = 'films';

    public function getById($id): Object
    {
        return DB::table(self::TABLE)->find($id);
    }

    public function delete($key, $value): void
    {
        DB::table(self::TABLE)->where($key, $value)->delete();
    }

    public function search($key, $value): \Illuminate\Support\Collection
    {
        return DB::table(self::TABLE)->where($key, $value)->get();
    }
}
