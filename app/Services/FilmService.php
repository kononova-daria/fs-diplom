<?php

namespace App\Services;

use App\Models\Film;
use App\Repositories\Interfaces\FilmRepositoryInterface;
use App\Repositories\Interfaces\FilmSessionRepositoryInterface;
use App\Repositories\Interfaces\HallRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;

class FilmService {
    private FilmRepositoryInterface $filmRepository;
    private HallRepositoryInterface $hallRepository;
    private FilmSessionRepositoryInterface $filmSessionRepository;
    private PlaceRepositoryInterface $placeRepository;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        FilmRepositoryInterface $filmRepository,
        HallRepositoryInterface $hallRepository,
        FilmSessionRepositoryInterface $filmSessionRepository,
        PlaceRepositoryInterface $placeRepository,
        OrderRepositoryInterface $orderRepository,
    )
    {
        $this->filmRepository = $filmRepository;
        $this->hallRepository = $hallRepository;
        $this->filmSessionRepository = $filmSessionRepository;
        $this->placeRepository = $placeRepository;
        $this->orderRepository = $orderRepository;
    }

    public function getFilms(string $url): \Illuminate\Database\Eloquent\Collection
    {
        $films = Film::all();

        switch ($url) {
            case 'admin/films':
                break;
            case 'client/films':
                foreach ($films as $film) {
                    $halls = $this->hallRepository->search('status', true);
                    $halls = array_filter([...$halls], function ($value) {
                        $places = $this->placeRepository->search('hall_id', $value->id);
                        return count($places);
                    });
                    $sessions = $this->filmSessionRepository->search('film_id', $film->id);
                    $film->halls = collect($halls);
                    foreach ($film->halls as $key=>$hall) {
                        $hall->sessions = [];
                        foreach ($sessions as $session) {
                            if ($session->hall_id === $hall->id) {
                                $hall->sessions[] = $session;
                            }
                        }
                        if (!count($hall->sessions)) {
                            unset($film->halls[$key]);
                        }
                    }
                }
                break;
        }
        return $films;
    }

    public function getFilm(int $id): Object {
        return $this->filmRepository->getById($id);
    }

    public function deleteFilm(int $id): void
    {
        $sessions = $this->filmSessionRepository->search('film_id', $id);
        foreach ($sessions as $value) {
            $this->orderRepository->delete('session_id', $value->id);
        }
        $this->filmSessionRepository->delete('film_id', $id);
        $this->filmRepository->delete('id', $id);
    }
}
