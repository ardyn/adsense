<?php

namespace Ardyn\Adsense;

use Illuminate\View\Factory as View;
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
   * @var \Ardyn\Adsense\Ad
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
   * @var \Closure|boolean
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
   * @param \Ardyn\Adsense\Models\Ad $ad
   * @param \Illuminate\View\Factory $view
   */
  public function __construct(
    Config $config,
    Ad $ad,
    View $view
  ) {

    $this->config = $config;
    $this->ad = $ad;
    $this->view = $view;

    $this->renderer = $config->get('adsense.renderer');
    $this->enabled = $config->get('adsense.enabled');
    $this->adClient = "ca-".$config->get('adsense.ad_client');
    $this->adLimits = $config->get('adsense.limits');
    $this->adCount = [
      Ad::LINK => 0,
      Ad::CONTENT => 0,
    ];

  } /* function __construct */



  /**
   * Return code for a Google AdSense ad
   *
   * @access public
   * @param string $name
   * @param array [$arguments] Arguments for enabled closure.
   * @return string
   */
  public function get($name, array $arguments=[]) {

    if ( ! $this->showAds($arguments) )
      return '';

    $this->ad->load($name, $this->config->get("adsense.ads.$name"));

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

    return $this->view->make("adsense::{$this->renderer}", $data)->render();

  } /* function get */



  /**
   * Whether to show ads
   *
   * @access protected
   * @param mixed $arguments
   * @return boolean
   */
  protected function showAds($arguments) {

    if ( is_callable($this->enabled) )
      return call_user_func_array($this->enabled, $arguments);

    return $this->enabled;

  } /* function showAds */

} /* class Adsense */

/* EOF */
