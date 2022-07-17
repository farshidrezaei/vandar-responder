<?php

namespace FarshidRezaei\VandarResponder\Tests\Unit;

use App\Http\Resources\Application\ApplicationResource;
use App\Models\Application;
use FarshidRezaei\VandarResponder\Facades\Responder;
use Illuminate\Http\Response;
use Tests\TestCaseWithData;

class ResponderTest extends TestCaseWithData
{
    //ok
    public function testResponseIsOk(): void
    {
        $message = "test Message";
        $data = ['testData'];

        $response = Responder::success(message: $message, data: $data)->getData(true);
        $this->assertEquals($response, [
            'message' => $message,
            'data' => $data,
        ]);
    }


    public function testResourceCollectionResponseIsOk(): void
    {
        $message = "test Message";

        $response = Responder::successResourceCollection(
            message: $message,
            data: ApplicationResource::collection(Application::paginate())
        );
        $this->assertIsNotClosedResource($response);
    }


    public function testResponseIsOkWithoutMessage(): void
    {
        $data = ['testData'];

        $response = Responder::success(data: $data)->getData(true);
        $this->assertEquals($response, [
            'data' => $data,
        ]);
    }

    public function testResponseIsOkWithoutData(): void
    {
        $response = Responder::success()->getData(true);
        $this->assertEquals($response, []);
    }


    //failure

    public function testResponseIsFailure(): void
    {
        $message = "test Message";
        $data = ['testData'];

        $response = Responder::failure(
            errorCode: Response::HTTP_UNAUTHORIZED,
            stringErrorCode: config('responder.errors.UNAUTHORIZED_ERROR'),
            message: $message,
            errors: $data
        )->getData(
            true
        );
        $this->assertEquals($response, [
            'message' => $message,
            'errors' => $data,
            'code'=>config('responder.errors.UNAUTHORIZED_ERROR')
        ]);
    }


    public function testResponseIsFailureWithoutMessage(): void
    {
        $data = ['testData'];

        $response = Responder::failure(
            errorCode: Response::HTTP_UNAUTHORIZED,
            stringErrorCode: config('responder.errors.UNAUTHORIZED_ERROR'),
            errors: $data
        )->getData(true);
        $this->assertEquals($response, [
            'errors' => $data,
            'code'=>config('responder.errors.UNAUTHORIZED_ERROR')
        ]);
    }

    public function testResponseIsFailureWithoutData(): void
    {
        $response = Responder::failure(
            errorCode: Response::HTTP_UNAUTHORIZED,
            stringErrorCode: config('responder.errors.UNAUTHORIZED_ERROR'),
        )->getData(true);
        $this->assertEquals($response, ['code'=>config('responder.errors.UNAUTHORIZED_ERROR')]);
    }
}
