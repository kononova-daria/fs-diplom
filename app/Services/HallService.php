<?php

namespace App\Services;

use App\Repositories\Interfaces\FilmSessionRepositoryInterface;
use App\Repositories\Interfaces\HallRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;

class HallService {
    private FilmSessionRepositoryInterface $filmSessionRepository;
    private OrderRepositoryInterface $orderRepository;
    private PlaceRepositoryInterface $placeRepository;
    private HallRepositoryInterface $hallRepository;

    public function __construct(
        FilmSessionRepositoryInterface $filmSessionRepository,
        OrderRepositoryInterface $orderRepository,
        PlaceRepositoryInterface $placeRepository,
        HallRepositoryInterface $hallRepository,
    )
    {
        $this->filmSessionRepository = $filmSessionRepository;
        $this->orderRepository = $orderRepository;
        $this->placeRepository = $placeRepository;
        $this->hallRepository = $hallRepository;
    }

    public function getHall(int $id): Object {
        return $this->hallRepository->getById($id);
    }

    public function deleteHall(int $id): void
    {
        $sessions = $this->filmSessionRepository->search('hall_id', $id);
        foreach ($sessions as $value) {
            $this->orderRepository->delete('session_id', $value->id);
        }
        $this->placeRepository->delete('hall_id', $id);
        $this->filmSessionRepository->delete('hall_id', $id);
        $this->hallRepository->delete('id', $id);
    }
}
