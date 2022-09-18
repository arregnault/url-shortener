<?php

namespace App\Shared\Traits\Tests;

trait Assert
{


    public function assertSuccessResponse($response, $code=200)
    {
        $response = $response->getData();
        $this->assertIsObject($response);
        $this->assertObjectHasAttribute('code', $response);
        $this->assertObjectHasAttribute('data', $response);
        $this->assertObjectHasAttribute('status', $response);
        $this->assertEquals('success', $response->status);
        $this->assertEquals($code, $response->code);

    }//end assertSuccessResponse()


    public function assertErrorResponse($response, $code=400)
    {
        $response = $response->getData();
        $this->assertIsObject($response);
        $this->assertEquals('error', $response->status);
        $this->assertObjectHasAttribute('code', $response);
        $this->assertObjectHasAttribute('message', $response);
        $this->assertObjectHasAttribute('status', $response);
        $this->assertEquals($code, $response->code);

    }//end assertErrorResponse()


}
