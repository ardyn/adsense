# Display Google AdSense Ads

A convenient way to display Google AdSense ads in your Blade templates.

## Installation

Install via composer. Publish configuration files. Add your ads.

### Composer

Edit your `composer.json` file:

```json
"require": {
  "ardan/adsense": "dev-master"
},
"repositories": [
  {
    "type": "vcs",
    "url": "https://ardan@bitbucket.org/ardan/adsense.git"
  }
]
```
Run `composer update`.

### Publish Configuration Files

Run `php artisan config:publish ardan/adsense`, then modify the contents of `app/config/packages/ardan/adsense/config.php`.

* **id** *required* The ad ID
* **size** *required* Size of ad. Either an array or string.
* **description** A short description of the ad
* **type** Either Ad::LINK or Ad::CONTENT. Default is Ad::CONTENT

```php
return [
  'ads' => [
    'ad_key' => [
      'id' => '123456789',
      'size' => [ 300, 100 ],
      'description' => 'Test Ad',
      'type' => Ad::CONTENT,
    ],
  ],
];
```

### Integrate with Laravel

Add the following to the `providers` array in your `app/config.php` file:

```php
'Ardan\Adsense\AdsenseServiceProvider'
```

And add the alias in `aliases` array:

```php
'Adsense' => 'Ardan\Adense\Facades\Adsense'
```

## Usage

To display the HTML for an ad, call `Adsense::get('ad_key');` where `'ad_key'` is the array index of your ad.

## Extending Blade

You may create a blade control structure to display an ad with `@adsense('ad_key')` rather than `{{ Adsense::get('ad_key') }}`.

Edit your `global.php` file and add the following code.

```php
Blade::extend(function ($view, $compiler) {

  $pattern = $compiler->createMatcher('adsense');

  return preg_replace($pattern, '<?php echo Adsense::get($2); ?>', $view);

});
```

## TODO

* Write tests.
* Proofread.
