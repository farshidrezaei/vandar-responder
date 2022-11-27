# Responder, Vandar response handler laravel package

## Installation

### composer

```bash
composer require farshidrezaei/vandar-responder
```

you must publish config and languages files:

```bash
#config
php artisan vendor:publish --provider="FarshidRezaei\VandarResponder\Providers\ResponderServiceProvider" --tag="config"

#language
php artisan vendor:publish --provider="FarshidRezaei\VandarResponder\Providers\ResponderServiceProvider" --tag="language"
```

after publish config file you can customize string errors.
string errors will use in failure responses.

you can access errors like bellow:

```php
config('responder.errors.YOUR_ERROR')
config('responder.errors.INTERNAL_ERROR')
config('responder.errors.EXTERNAL_SERVICE_ERROR')
```

you can access translation like bellow:

```php
__('responder::exceptions.YOUR_ERROR')
__('responder::exceptions.validation')
```

## Usage



### Signatures of methods:
```php

Responder::success(?string $message = null, mixed $data = null): Illuminate\Http\JsonResponse

Responder::successResourceCollection(null|string $message = null, Illuminate\Http\Resources\Json\AnonymousResourceCollection $data) :lluminate\Http\Resources\Json\AnonymousResourceCollection

Responder::failure(int $errorCode, string $stringErrorCode, null|string $message = null, array|null $errors = [], array|null $data = []): Illuminate\Http\JsonResponse
```

Here's a quick example:



#### You can use function added macro on response class:

```php
// php 8
return response()->failure(
            errorCode: Response::HTTP_INTERNAL_SERVER_ERROR,// 500
            stringErrorCode: config('responder.errors.INTERNAL_ERROR'),
            message: "Service isn't available now. try again later.",
            data:['foo'=>'bar']
        );
 ```


#### Or call function from facade directly:

```php
use FarshidRezaei\VandarResponder\Services\Responder;

// php 8
 return Responder::failure(
            errorCode: Response::HTTP_INTERNAL_SERVER_ERROR,// 500
            stringErrorCode: config('responder.errors.INTERNAL_ERROR'),
            message: "Service isn't available now. try again later.",
            data:['foo'=>'bar']
        );


// php 7.4
 return Responder::failure(
            Response::HTTP_INTERNAL_SERVER_ERROR,// 500
            config('responder.errors.INTERNAL_ERROR'),
            "Service isn't available now. try again later.",
            ['foo'=>'bar']
        );

 ```

And you will get bellow response:

```josn
{
  "message": "Service isn't available now. try again later.",
  "code": "internal_error",
  "data": {
        "foo":"bar"
  }
}
```

#### Also you can use `responder()` helper function :

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



# Api Exception Handler

To standardize the responses, the exceptions must also follow vandar standards. laravel has itself rules to show response of
exceptions.
with this feature of this package you can customize every laravel exceptions.

for use this feature please add bellow code to `render()` function in `app/Exceptions/Handler.php`:

```php
    public function render($request, Throwable $e): \Illuminate\Http\Response|JsonResponse|Response
    {
        //...
        if ($request->expectsJson() && $exceptionResponse = ApiExceptionHandler::handle($e)) {
            return $exceptionResponse;
        }
        //...
        return parent::render($request, $e);
    }
```

we handle and customize some exceptions. after publish configs, you can see it in `config/responder.php` as `customExceptions`
key:

```php
  'customExceptions' => [
        RuntimeException::class => CustomDefaultException::class,
        Exception::class => CustomDefaultException::class,
        ValidationException::class => CustomValidationException::class,
        NotFoundHttpException::class => CustomNotFoundHttpException::class,
        MethodNotAllowedException::class => CustomMethodNotAllowed::class,
        ModelNotFoundException::class => CustomNotFoundHttpException::class,
        AuthenticationException::class => CustomAuthenticationException::class,
        AuthorizationException::class => CustomUnauthorizedException::class,
        UnauthorizedHttpException::class => CustomUnauthorizedException::class,
        ThrottleRequestsException::class => CustomThrottleRequestsException::class
    ]
```

you can customize,add,edit and override any of classes.

also you can publish this classes by run this command:

```bash
#customExceptions
php artisan vendor:publish --provider="FarshidRezaei\VandarResponder\Providers\ResponderServiceProvider" --tag="customExceptions"

```
**don't forget change namespace of classes after publish**



## customException structure

```php
class CustomDefaultException extends AbstractApiCustomException implements ApiCustomExceptionInterface
{
    public function __construct(?Exception $exception)
    {
        $this->errorCode = Response::HTTP_INTERNAL_SERVER_ERROR; // exception Status Code

        $this->stringErrorCode = config('responder.errors.EXTERNAL_SERVICE_ERROR'); // string error code

        $this->errorMessage = __('responder::exceptions.generalServerError'); // message of error

        parent::__construct();
    }
}
```

if you assign it for a laravel exception it will call responder `failure()` function and return json response to client.

```json
//with status 500
{
    "message": "خطایی رخ داده است، لطفا دوباره تلاش کنید",
    "code": "external_service_error"
}
```


### tip
if you want to create a non-laravel exception and throw it, you can call  `Responder::failure()` function in render of exception.

it will return standard json.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
