<?php

namespace Ardan\Adsense;

use Ardan\Adsense\Ad;
use Illuminate\View\Environment as View;
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
  protected $adClient;

  /**
   * View
   *
   * @var \Illuminate\View\Environment
   */
  protected $view;

  /**
   * Ad limits
   *
   * @var array
   */
  protected $adLimits;

  /**
   * Ad Counter
   *
   * @var array
   */
  protected $adCount;



  /**
   * Constructor
   *
   * @access public
   * @param \Illuminate\Config\Repository $config
   * @param \Ardan\Adsense\Models\Ad $ad
   * @param \Illuminate\View\Environment $view
   * @return void
   */
  public function __construct(
    Config $config,
    Ad $ad,
    View $view
  ) {

    $this->config = $config;
    $this->ad = $ad;
    $this->view = $view;

    $this->renderer = $config->get('ardan/adsense::renderer');
    $this->enabled = $config->get('ardan/adsense::enabled');
    $this->adClient = "ca-".$config->get('ardan/adsense::ad_client');
    $this->adLimits = $config->get('ardan/adsense::limits');
    $this->adCount = [
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
    if ( $this->adCount[$this->ad->type]++ >= $this->adLimits[$this->ad->type] )
      return "<!-- Adsense limit reached. Ad '{$this->ad->name}' not displayed. -->";

    $data = [
      'ad_client' => $this->adClient,
      'slot' => $this->ad->id,
      'width' => $this->ad->width,
      'height' => $this->ad->height,
      'name' => $this->ad->name,
      'description' => $this->ad->description,
    ];

    return $this->view->make("ardan/adsense::{$this->renderer}", $data)->render();

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
