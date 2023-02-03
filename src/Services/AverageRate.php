<?php

namespace App\Services;

use App\Entity\Hike;

class AverageRate
{
    public function get(Hike $hike): float
    {
        $rates = [];
        foreach ($hike->getComments() as $comment) {
            $rates[] = $comment->getRate();
        }
        if (empty($rates)) {
            return 0;
        } else {
            $totalRates = 0;

            foreach ($rates as $rate) {
                $totalRates += $rate;
            }

            return round($totalRates / count($rates), 1);
        }
    }
}
