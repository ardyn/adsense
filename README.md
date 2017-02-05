# Display Google AdSense Ads

A convenient way to display Google AdSense ads in your Laravel 5 application. Just setup your ads,
then $adsense->get('ad') to return the HTML for the ad.

## Installation

Install via composer. Publish configuration files. Add your ads.

### Composer

Edit your `composer.json` file:

```json
"require": {
  "ardyn/adsense": "~2.0"
}
```
Run `composer update`.

### Publish Configuration Files

Run `php artisan vendor:publish`, then modify the contents of `/config/adsense.php`.

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

Refer to `adsense.php` for more configuration documentation.

### Integrate with Laravel 5

Add the following to the `providers` array in your `config/app.php` file:

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
in `Adsense::get('example', [ /* parameters */ ])`. Closures are not recommened as Laravel's config:cache cannot serialize closures correctly.

## TODO

* Write tests
