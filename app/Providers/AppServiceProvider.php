<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Servicos\ConsultaCidade\Provedores\Ibge;
use App\Servicos\ConsultaCEP\ProvedoresCEP\ViaCEP;
use App\Servicos\ConsultaCEP\InterfaceConsultaCEP;
use App\Servicos\ConsultaCidade\ConsultaCidadeInterface;
use App\Servicos\ConsultaDistancia\ConsultaDistanciaInterface;
use App\Servicos\ConsultaDistancia\Provedores\GoogleMatrix;
use App\Servicos\Pagamento\PagamentoInterface;
use App\Servicos\Pagamento\Provedores\Pagarme;
use PagarMe\Client;
use TeamPickr\DistanceMatrix\Licenses\StandardLicense;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
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
            $pagarmeSDK = new Client(config("services/pagarme/key"));
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
