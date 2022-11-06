<?php

namespace App\Services;

use App\Models\FilmSession;
use App\Repositories\Interfaces\FilmRepositoryInterface;
use App\Repositories\Interfaces\FilmSessionRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class FilmSessionService {
    private FilmRepositoryInterface $filmRepository;
    private FilmSessionRepositoryInterface $filmSessionRepository;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        FilmRepositoryInterface $filmRepository,
        FilmSessionRepositoryInterface $filmSessionRepository,
        OrderRepositoryInterface $orderRepository,
    )
    {
        $this->filmRepository = $filmRepository;
        $this->filmSessionRepository = $filmSessionRepository;
        $this->orderRepository = $orderRepository;
    }

    public function getSessions(): \Illuminate\Database\Eloquent\Collection
    {
        $sessions = FilmSession::all();
        foreach ($sessions as $value) {
            $value->film = $this->filmRepository->search('id', $value->film_id)->first();
        }

        return $sessions;
    }

    public function deleteSession(int $id): void
    {
        $this->orderRepository->delete('session_id', $id);
        $this->filmSessionRepository->delete('id', $id);
    }
}
