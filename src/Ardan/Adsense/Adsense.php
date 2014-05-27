<?php

namespace Ardan\Adsense;

use Ardan\Adsense\Models\Ad;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Config\Repository as Config;

class Adsense {

  /**
   * Config
   *
   * @var \Illuminate\Config\Repository
   */
  protected $config;

  /**
   * An Ad
   *
   * @var \Ardan\Adsense\Ad
   */
  protected $ad;

  /**
   * The view to render ad
   *
   * @var string
   */
  protected $renderer;

  /**
   * Ads enabled
   *
   * @var boolean
   */
  protected $enabled;

  /**
   * Client ID
   *
   * @var string
   */
  protected $ad_client;

  /**
   * Ad Counter
   *
   * @var array
   */
  protected $ad_count;



  /**
   * Constructor
   *
   * @access public
   * @param \Illuminate\Config\Repository $config
   * @param \Ardan\Adsense\Models\Ad $ad
   * @return void
   */
  public function __construct(
    Config $config,
    Ad $ad
  ) {

    $this->config = $config;
    $this->ad = $ad;
    $this->renderer = $config->get('ardan/adsense::renderer');
    $this->enabled = $config->get('ardan/adsense::enabled');
    $this->ad_client = $config->get('ardan/adsense::ad_client');
    $this->ad_limits = $config->get('ardan/adsense::limits');
    $this->ad_count = [
      Ad::LINK => 0,
      Ad::CONTENT => 0,
    ];

  } /* function __construct */



  /**
   * Return code for a Google AdSence ad
   *
   * @access public
   * @param string $name
   * @return string
   */
  public function get($name) {

    if ( ! $this->showAds() )
      return '';

    $this->ad->load($name, $this->config->get("ardan/adsense::ads.$name"));

    // Do not display more ads than Google allows
    if ( $this->ad_count[$this->ad->type]++ >= $this->ad_limits[$this->ad->type] ) {
      Log::notice("Adsense limit reached. Ad '{$this->ad->name}' not displayed.");
      return '';
    }

    $data = [
      'ad_client' => $this->ad_client,
      'slot' => $this->ad->id,
      'width' => $this->ad->width,
      'height' => $this->ad->height,
      'name' => $this->ad->name,
      'description' => $this->ad->description,
    ];

    return View::make("ardan/adsense::{$this->renderer}", $data);

  } /* function get */



  /**
   * Whether to show ads
   *
   * @access protected
   * @param void
   * @return boolean
   */
  protected function showAds() {

    return $this->enabled;

  } /* function showAds */

} /* class Adsense */

/* EOF */
