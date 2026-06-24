<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Validator::resolver(function ($translator, $data, $rules, $messages, $customAttributes) {
            $messages['required'] = 'Data tidak boleh kosong.';
            return new \Illuminate\Validation\Validator($translator, $data, $rules, $messages, $customAttributes);
        });
    }
}
