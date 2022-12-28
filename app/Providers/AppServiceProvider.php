<?php

namespace App\Providers;

use PagarMe\Client;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\ServiceProvider;
use App\Servicos\Pagamento\PagamentoInterface;
use App\Servicos\Pagamento\Provedores\Pagarme;
use App\Servicos\ConsultaCidade\Provedores\Ibge;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Servicos\ConsultaCEP\InterfaceConsultaCEP;
use App\Servicos\ConsultaCEP\ProvedoresCEP\ViaCEP;
use TeamPickr\DistanceMatrix\Licenses\StandardLicense;
use App\Servicos\ConsultaCidade\ConsultaCidadeInterface;
use App\Servicos\ConsultaDistancia\Provedores\GoogleMatrix;
use App\Servicos\ConsultaDistancia\ConsultaDistanciaInterface;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Sanctum::ignoreMigrations();
        $this->app->singleton(InterfaceConsultaCEP::class, function () {
            return new ViaCEP;
        });
        $this->app->singleton(ConsultaCidadeInterface::class, function () {
            return new Ibge;
        });
        $this->app->bind(ConsultaDistanciaInterface::class, function () {
            $licenca = new StandardLicense(config("google.key"));
            return new GoogleMatrix($licenca);
        });
        $this->app->singleton(PagamentoInterface::class, function () {
            $pagarmeSDK = new Client(config("services.pagarme.key"));
            return new Pagarme($pagarmeSDK);
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
