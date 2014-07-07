# Display Google AdSense Ads

A convenient way to display Google AdSense ads in your HTML. Just setup your ads,
then $adsense->get('ad') to return the HTML for the ad.

## Installation

Install via composer. Publish configuration files. Add your ads.

### Composer

Edit your `composer.json` file:

```json
"require": {
  "ardyn/adsense": "dev-master"
}
```
Run `composer update`.

### Publish Configuration Files

Run `php artisan config:publish ardyn/adsense`, then modify the contents of `app/config/packages/ardyn/adsense/config.php`.

* **id** *required* The ad ID.
* **size** *required* Size of ad. Either an array or string.
* **description** A short description of the ad.
* **type** Either Ad::LINK or Ad::CONTENT. Default is Ad::CONTENT.

```php
return [
  'ads' => [
    'example' => [
      'id' => '123456789',
      'size' => [ 300, 100 ],
      'description' => 'Test Ad',
      'type' => Ad::CONTENT,
    ],
  ],
];
```

Refer to `config.php` for more configuration documentation.

### Integrate with Laravel

Add the following to the `providers` array in your `app/config.php` file:

```php
'Ardyn\Adsense\AdsenseServiceProvider'
```

And add the alias in `aliases` array:

```php
'Adsense' => 'Ardyn\Adsense\Facades\Adsense'
```

## Usage

To display the HTML for an ad, call `Adsense::get('example');` where `'example'` is the array index of your ad.

Determine whether ads are displayed by setting the `enabled` configuration value to either a boolean value or
a closure that returns a boolean value. The closure may include parameters. Pass the arguments
in `Adsense::get('example', [ /* parameters */ ])`.

## Extending Blade

You may create a blade control structure to display an ad with `@adsense('example')` rather than `{{ Adsense::get('example') }}`.

Edit your `global.php` file and add the following code.

```php
Blade::extend(function ($view, $compiler) {

  $pattern = $compiler->createMatcher('adsense');

  return preg_replace($pattern, '<?php echo Adsense::get($2); ?>', $view);

});
```

## TODO

* Write tests.
* Extend Blade in AdsenseServiceProvider
