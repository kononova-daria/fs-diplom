<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\RepositoryInterface;

class FilmSessionRepository implements RepositoryInterface
{
    private const TABLE = 'film_sessions';

    static function getById($id)
    {
        return DB::table(self::TABLE)->find($id);
    }

    static function delete($key, $value)
    {
        DB::table(self::TABLE)->where($key, $value)->delete();
    }

    static function search($key, $value)
    {
        return DB::table(self::TABLE)->where($key, $value)->get();
    }
}
