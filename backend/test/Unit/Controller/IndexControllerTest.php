<?php

namespace HyperfTest\Unit\Controller;

use HyperfTest\HttpTestCase;

class IndexControllerTest extends HttpTestCase
{
    public function testIndex()
    {
        $response = $this->get('/');
        var_dump($response);
        // $this->assertSame(200, $response->getStatusCode());
    }
}