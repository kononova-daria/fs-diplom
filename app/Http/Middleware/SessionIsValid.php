<?php

namespace App\Http\Middleware;

use App\Repositories\Interfaces\FilmSessionRepositoryInterface;
use Closure;
use Illuminate\Http\Request;

class SessionIsValid
{
    private FilmSessionRepositoryInterface $filmSessionRepository;

    public function __construct(FilmSessionRepositoryInterface $filmSessionRepository)
    {
        $this->filmSessionRepository = $filmSessionRepository;
    }

    public function handle(Request $request, Closure $next)
    {
        $sessions = $this->filmSessionRepository->search('hall_id', $request->input('hall_id'));
        if (count($sessions)) {
            foreach ($sessions as $value) {
                if ($request->input('start') >= $value->start && $request->input('start') <= $value->end) {
                    return response(['В выбранном зале на данное время уже существует сеанс.'],400);
                }
            }
        }
        return $next($request);
    }
}
