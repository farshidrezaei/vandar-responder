# Responder, Vandar response handler laravel package

## Installation

### composer

```bash
composer require farshidrezaei/vandar-responder
```

you must publish config file:

```bash
php artisan vendor:publish --provider="FarshidRezaei\VandarResponder\Providers\ResponderServiceProvider" --tag="config"
```

after publish config file you can customize string errors.
string errors will use in failure responses.
you can access errors like bellow:\

```php
config('responder.errors.YOUR_ERROR')
config('responder.errors.INTERNAL_ERROR')
config('responder.errors.EXTERNAL_SERVICE_ERROR')
```

## Usage

Here's a quick example:

```php
use FarshidRezaei\VandarResponder\Services\Responder;

// php 8
 return Responder::failure(
            errorCode: Response::HTTP_INTERNAL_SERVER_ERROR,// 500
            stringErrorCode: config('responder.errors.INTERNAL_ERROR'),
            message: "Service isn't available now. try again later.",
        );

// php 7.4
 return Responder::failure(
            Response::HTTP_INTERNAL_SERVER_ERROR,// 500
            config('responder.errors.INTERNAL_ERROR'),
            "Service isn't available now. try again later."
                   );
 ```

and you will get bellow response:

```josn
{
  "message": "Service isn't available now. try again later.",
  "code": "internal_error"
}
```

also you can use `responder()` helper function :

```php
// php 8
 return responder()->success(
                message:"User Info",
                data: [
                    "name"=>"Farshid",
                    "company"=>"Vandar",
                    "Position"=>"Full-Stack Web Developer"
                ]
        );
 ```

and you will get bellow response:

```json
{
    "message": "User Info",
    "data": {
        "name": "Farshid",
        "company": "Vandar",
        "Position": "Full-Stack Web Developer"
    }
}
```

if you want to respond laravel ResourceCollection do like bellow:

```php
// php 8
    $users=User::paginate();
    return Responder::successResourceCollection(
        message: 'User List.',
        data: USerResource::collection($users)
    );

 ```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
