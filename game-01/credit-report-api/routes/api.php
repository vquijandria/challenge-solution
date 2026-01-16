<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreditReportExportController;

Route::get(
    '/credit-reports/export',
    [CreditReportExportController::class, 'export']
);
