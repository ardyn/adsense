<?php

namespace Ardyn\Adsense;

use Illuminate\Support\ServiceProvider;

class AdsenseServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;



	/**
	 * Boot the service provider
	 *
	 * @access public
	 * @param void
	 * @return void
	 */
	public function boot() {

        $this->publishes([
            __DIR__.'/../../config/adsense.php' => config_path('adsense.php'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../../views', 'adsense');

	} /* function boot */




	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {

        $this->registerAdsense();
        $this->registerAd();

	} /* function register */



	/**
	 * Register Ad
	 *
	 * @access protected
	 * @param void
	 * @return void
	 */
	protected function registerAd() {

	  $app = $this->app;

	  $app->bind('adsense.ad', function () use ($app) {

	    return new Ad(
	      $app['config']->get('adsense.defaults'),
	      $app['config']->get('adsense.delimiter')
	    );

	  });

	} /* function registerAd */



	/**
	 * Register Adsense
	 *
	 * @access protected
	 * @param void
	 * @return void
	 */
	protected function registerAdsense() {

	  $app = $this->app;

	  $app->bind('adsense', function () use ($app) {

	    return new Adsense(
	      $app['config'],
	      $app['adsense.ad'],
	      $app['view']
	    );

	 });

	} /* function registerAdsense */



	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {

		return array('adsense');

	} /* function provides */

} /* class AdsenseServiceProvider */

/* EOF */
