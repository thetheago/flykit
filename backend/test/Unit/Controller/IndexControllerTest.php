<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Controller;

use HyperfTest\HttpTestCase;

/**
 * @internal
 * @coversNothing
 */
class IndexControllerTest extends HttpTestCase
{
    public function testIndex()
    {
        $response = $this->get('/');
        var_dump($response);
        // $this->assertSame(200, $response->getStatusCode());
    }
}
