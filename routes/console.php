<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('backup:run', function () {
    // تنفيذ أمر النسخ الاحتياطي هنا
    $this->info('Backup command executed.');
});