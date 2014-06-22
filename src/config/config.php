<?php

use Ardyn\Adsense\Ad;

return [

  /**
   * AdSense ID from Google, aka publisher ID
   */
  'ad_client' => '',

  /**
   * Set to true to display ads. Can either be boolean or a Closure that returns
   * a boolean value.
   */
  'enabled' => true,

  /**
   * Renderer. You may choose how the ads are displayed. Publish this packages
   * view files to override these renderers or to create your own renderers.
   *
   * Available options: 'placeholdit', 'asynchronous', 'synchronous'
   */
  'renderer' => 'placeholdit',

  /**
   * Size delimiter
   */
   'delimiter' => 'x',

  /**
   * Limit number of ads that can be displayed on the page
   */
  'limits' => [
    Ad::CONTENT => 3,
    Ad::LINK => 3,
  ],

  /**
   * Default values for ads
   */
  'defaults' => [
    'type' => Ad::CONTENT,
    'description' => 'A Google Ad', # Comments only, doesn't do anything.
  ],

  /**
   * The ads we may display.
   *
   * 'id'          The Ad ID from Google AdSense
   *
   * 'size'        May be an array [ width, height ], a string '200x100',
   *               or Ad::RESPONSIVE for responsive ads
   *
   * 'type'        Can either be Ad::LINK or Ad::CONTENT
   *
   * 'description' Optional and added as an HTML comment with the ad.
   */
  'ads' => [
    'example' => [
      'id' => '0123456789',
      'size' => Ad::RESPONSIVE,
      'type' => Ad::CONTENT,
      'description' => 'Example Ad',
    ],
  ],
];

/* EOF */
