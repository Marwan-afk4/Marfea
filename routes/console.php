<?php

use App\Models\JobOffer;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


//i want to make a schedule to run every day to see the expire jobs

Schedule::call(function () {
    $expiredJobs = JobOffer::where('expire_date', '<', now())->get();

    foreach ($expiredJobs as $job) {
        $job->update(['status' => 'inactive']);
    }
    Log::info('Expired job offers deactivated: ' . $expiredJobs->count());
})->everySecond()->name('Deactivate expired job offers')->withoutOverlapping();

Artisan::command('schedule:run', function () {
    $this->call('schedule:run');
})->purpose('Run the scheduled tasks');
