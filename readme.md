# GuestPass for Laravel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

## Installation

Via Composer

``` bash
$ composer require jeroen-g/guestpass
```

If you run Laravel 5.5, the service provider and facade are autodiscovered. If not then add them manually:

```php
JeroenG\GuestPass\GuestPassServiceProvider::class,
// ...
'GuestPass' => JeroenG\GuestPass\GuestPassFacade::class,
```

## Usage

To use Guest Passes, you will need two models: one that is the owner granting guest access (typically a user) and another that is the object to which access is being granted. In the examples below, a photo is used for this.

### Creating new Guest Passes

Requires the owner and object models.
```php
GuestPass::create($user, $photo);
```
Returns true if successfull, false otherwise.

### Retrieving Guest Pass data

A Guest Pass contains the following data: `owner_model`, `owner,id`; `object_model`, `object_id`; `key` (unique); `view` (nullable).

#### Getting all keys of the owner
Requires the owner model.
```php
GuestPass::getKeysOf($user);
```
Returns a collection of all Guest Pass keys and their corresponding data is attached as well.

#### Finding a Guest Pass for corresponding owner and object
Requires the owner and object model.
```php
GuestPass::findGuestPass($user, $photo);
```
Returns an Eloquent model (or throws an exception).

#### Get one specific Guest Pass by its key
Requires the key (string).
```php
GuestPass::getGuestPass($key);
```
Returns an Eloquent model (or throws an exception).

### Checking ownership
Requires the owner and Guest Pass models.
```php
GuestPass::isOwner($user, $guestpass);
```
Returns true or false.

### Access controller

The package ships with a controller that checks for the `/gp/{owner id}/{key}` route and when valid it returns the view (404 otherwise). Each view is passed the object and the Guest Pass models.
The views will be sought in the `resources/views/guests/` directory.

### Custom views

When creating a Guest Pass it is possible to pass a custom view as the third parameter
```php
GuestPass::create($user, $photo, 'album');
```
In this case, the access controller will not use `photo.blade.php` (which would be the default) but `album.blade.php` but the directory remains the same and it is not necessary to add the file extension.

## Changelog

Please see [changelog.md](changelog.md) for what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details.

## Credits

- [JeroenG][link-author]
- [All Contributors][link-contributors]

## License

The EU Public License. Please see [license.md](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/Jeroen-G/GuestPass.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Jeroen-G/GuestPass/master.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Jeroen-G/GuestPass.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/Jeroen-G/GuestPass
[link-travis]: https://travis-ci.org/Jeroen-G/GuestPass
[link-code-quality]: https://scrutinizer-ci.com/g/Jeroen-G/GuestPass
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors