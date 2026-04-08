<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Archivo de comandos Artisan por consola.
// Este comando "inspire" es de ejemplo por defecto en Laravel.
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
