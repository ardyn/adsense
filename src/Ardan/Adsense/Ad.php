<?php

namespace Ardan\Adsense;

use Ardan\Adsense\Exceptions\AdNotFoundException;
use Ardan\Adsense\Exceptions\InvalidAdSizeException;

class Ad {

  /**
   * Ad Types
   *
   * @const string
   */
  const LINK = 'link';
  const CONTENT = 'content';

  /**
   * Response ad size
   *
   * @const string
   */
  const RESPONSIVE = 'auto';



  /**
   * Defaults
   *
   * @var array
   */
  protected $defaults;

  /**
   * Size delimiter
   *
   * @var array
   */
  protected $delimiter;

  /**
   * Ad key
   *
   * @var string
   */
  public $name;

  /**
   * Ad ID
   *
   * @var string
   */
  public $id;

  /**
   * Ad width in px
   *
   * @var string
   */
  public $width;

  /**
   * Ad height in px
   *
   * @var string
   */
  public $height;

  /**
   * Ad description
   *
   * @var string
   */
  public $description;

  /**
   * Ad type
   *
   * @var string
   */
  public $type;



  /**
   * Constructor
   *
   * @access public
   * @param array $defaults
   * @param string $deliminter
   * @return void
   */
  public function __construct(
    $defaults,
    $delimiter
  ) {

    $this->defaults = $defaults;
    $this->delimiter = $delimiter;

  } /* function __construct */



  /**
   * Load an ad from the config file
   *
   * @access public
   * @param string $name
   * @param array $ad
   * @return void
   */
  public function load($name, $ad) {

    if ( ! $ad )
      throw new AdNotFoundException("Ad '$name' is not configured.");

    $ad = array_merge($ad, $this->defaults);
    list ($width, $height) = $this->parseSize($ad['size']);

    $this->name = $name;
    $this->id = $ad['id'];
    $this->width = $width;
    $this->height = $height;
    $this->description = $ad['description'];
    $this->type = $ad['type'];

  } /* function __construct */



  /**
   * Parse ad size from config
   *
   * @access private
   * @param mixed $size
   * @return int
   */
  private function parseSize($size) {

    if ( $size == self::RESPONSIVE )
      return [ 0, 0 ];

    if ( is_array($size) ) {
      if ( count($size) != 2 )
        throw new InvalidAdSizeException('Invalid ad size. Size should be an array with two elements.');
      return $size;
    }

    return $this->parseSize(explode($this->delimiter, $size));

  } /* function parseSize */

} /* class Ad */

/* EOF */
