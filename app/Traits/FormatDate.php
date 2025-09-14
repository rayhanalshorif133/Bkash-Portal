<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatDate
{
    public function formatDate($date, $format = 'd M, Y')
    {
        return Carbon::parse($date)->format($format);
    }
}
