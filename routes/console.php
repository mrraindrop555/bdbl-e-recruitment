<?php

use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    date_default_timezone_set('Asia/Thimphu');

    $now = Carbon::now('Asia/Thimphu');

    Vacancy::where('status', 'Open')
        ->where('closure', 'Auto')
        ->each(function ($vacancy) use ($now) {
            if (Carbon::parse($vacancy->close_datetime)->lte($now)) {
                $vacancy->update(['status' => 'Closed']);
            }
        });
})->everyMinute();
