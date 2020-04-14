<?php

namespace App\Providers;

use App\Source;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use function foo\func;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $tmp_sources = Source::all();
        $sources = [];
        foreach ($tmp_sources as $source) {
            $sources[] = [
                'source_id' => $source->id,
                'name' => $source->name
            ];
        }

        View::share('sources', $sources);
    }
}
