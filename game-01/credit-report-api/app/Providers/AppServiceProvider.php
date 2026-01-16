<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\CreditReports\Export\CreditReportExporter;
use App\Infrastructure\CreditReports\Export\Xlsx\XlsxCreditReportExporter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CreditReportExporter::class,
            XlsxCreditReportExporter::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
