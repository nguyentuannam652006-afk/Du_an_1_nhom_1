<?php

class TourController
{
    // Danh sách tour cho khách hàng
    public function listTours(): void
    {
        $tours = Tour::getAll();
        $destination = $_GET['destination'] ?? '';
        $keyword = $_GET['keyword'] ?? '';

        if (!empty($keyword)) {
            $tours = Tour::search($keyword, $destination ?: null);
        } elseif (!empty($destination)) {
            $tours = array_filter($tours, function($tour) use ($destination) {
                return $tour->destination === $destination;
            });
        }

        view('tours.index', [
            'title' => 'Danh sách Tour',
            'tours' => $tours,
            'keyword' => $keyword,
            'destination' => $destination,
        ]);
    }

    // Chi tiết tour
    public function detail(): void
    {
        $id = $_GET['id'] ?? 0;
        $tour = Tour::getById($id);

        if (!$tour) {
            header('Location: ' . BASE_URL . '?act=tours');
            exit;
        }

        $details = TourDetail::getByTourId($id);
        $schedules = TourSchedule::getByTourId($id);

        view('tours.detail', [
            'title' => $tour->name,
            'tour' => $tour,
            'details' => $details,
            'schedules' => $schedules,
        ]);
    }
}
