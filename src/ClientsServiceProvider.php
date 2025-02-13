<?php

namespace IlBronza\Clients;

use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\Referent;
use IlBronza\Products\Models\Sellables\Supplier;
use Illuminate\Contracts\Foundation\CachesConfiguration;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

use function array_merge;
use function array_replace_recursive;
use function dd;

class ClientsServiceProvider extends ServiceProvider
{
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot() : void
	{
		Relation::morphMap([
			'Client' => Client::getProjectClassName(),
			'Destination' => Destination::getProjectClassName(),
			'Referent' => Referent::getProjectClassName(),
		]);

		$this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'clients');
		// $this->loadViewsFrom(__DIR__.'/../resources/views', 'ilbronza');
		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
		$this->loadRoutesFrom(__DIR__ . '/../routes/clients.php');

		// Publishing is only necessary when using the CLI.
		if ($this->app->runningInConsole())
		{
			$this->bootForConsole();
		}
	}

	/**
	 * Register any package services.
	 *
	 * @return void
	 */

	protected function mergeConfigFrom($path, $key)
	{
		if (! ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
			$config = $this->app->make('config');

			$config->set($key, array_replace_recursive(
				require $path, $config->get($key, [])
			));
		}
	}



	public function register() : void
	{
		$this->mergeConfigFrom(__DIR__ . '/../config/clients.php', 'clients');

		// Register the service the package provides.
		$this->app->singleton('clients', function ($app)
		{
			return new Clients;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['clients'];
	}

	/**
	 * Console-specific booting.
	 *
	 * @return void
	 */
	protected function bootForConsole() : void
	{
		// Publishing the configuration file.
		$this->publishes([
			__DIR__ . '/../config/clients.php' => config_path('clients.php'),
		], 'clients.config');

		// $this->publishes([
		//     __DIR__.'/../database/migrations/' => database_path('migrations')
		// ], 'clients.migrations');

		// Publishing the routes.
		// $this->publishes([
		//     __DIR__.'/../routes' => base_path('routes'),
		// ], 'clients.routes');

		// Publishing the views.
		/*$this->publishes([
			__DIR__.'/../resources/views' => base_path('resources/views/vendor/ilbronza'),
		], 'clients.views');*/

		// Publishing assets.
		/*$this->publishes([
			__DIR__.'/../resources/assets' => public_path('vendor/ilbronza'),
		], 'clients.views');*/

		// Publishing the translation files.
		$this->publishes([
			__DIR__ . '/../resources/lang' => base_path('resources/lang/vendor/clients'),
		], 'clients.translations');

		// Registering package commands.
		// $this->commands([]);
	}
}
