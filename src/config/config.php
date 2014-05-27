<?php

use Ardan\Adsense\Models\Ad;

return [

  /**
   * AdSense ID
   */
  'ad_client' => '',

  /**
   * Set to true to display ads.
   */
  'enabled' => true,

  /**
   * Renderer. You may choose how the ads are displayed.
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
    'description' => 'A Google Ad',
  ],

  /**
   * The ads we may display.
   *
   * 'id'          The Ad ID from Google AdSense
   *
   * 'size'        May be an array [ width, height ], a string '100x200',
   *               or Ad::RESPONSIVE for responsive ads
   *
   * 'type'        Can either be Ad::LINK or Ad::CONTENT
   *
   * 'description' Optional and added as an HTML comment with the ad.
   */
  'ads' => [
    'test' => [
      'id' => '',
      'size' => [300, 100],
      'type' => Ad::CONTENT,
      'description' => 'Test Ad',
    ],
  ],
];

/* EOF */
