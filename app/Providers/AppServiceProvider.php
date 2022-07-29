<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Servicos\ConsultaCEP\ProvedoresCEP\ViaCEP;
use App\Servicos\ConsultaCEP\InterfaceConsultaCEP;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * @return void
     */
    public function register()
    {
        $this->app->singleton(InterfaceConsultaCEP::class, function() {
			return new ViaCEP;
		});
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
    }
}
