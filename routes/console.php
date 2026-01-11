<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Database Backup Schedule - runs daily at 2 AM
Schedule::command('db:backup --keep=7')
    ->daily()
    ->at('02:00')
    ->onSuccess(function () {
        Log::info('✅ Database backup completed successfully');
    })
    ->onFailure(function () {
        Log::error('❌ Database backup failed');
    });

// Calendar Reminders - runs daily at 7 AM and 3 PM to notify about events 2 days ahead
Schedule::command('calendar:reminders')
    ->dailyAt('07:00')
    ->onSuccess(function () {
        Log::info('✅ Calendar reminders sent successfully');
    })
    ->onFailure(function () {
        Log::error('❌ Calendar reminders failed');
    });

Schedule::command('calendar:reminders')
    ->dailyAt('15:00')
    ->onSuccess(function () {
        Log::info('✅ Calendar reminders sent successfully (afternoon)');
    })
    ->onFailure(function () {
        Log::error('❌ Calendar reminders failed (afternoon)');
    });
