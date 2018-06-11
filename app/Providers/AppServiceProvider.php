<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 삭제 - 미사용 추정. 나중에 삭제할것 (2018.04.25 KKW)
        // Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
        //     dd($value);
        //     return Hash::check($value, current($parameters));
        // });

        // 쿼리 로그 (2018.04.25 KKW)
        if ( config('app.log_query') ) {
            DB::listen(function ($event) {
                Log::getMonolog()->popHandler();
                Log::useDailyFiles(storage_path().'/logs/querylog.log');
                Log::info('query log', [
                    'sql' => $event->sql, 
                    'bindings' => $event->bindings
                ]);
            });
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
