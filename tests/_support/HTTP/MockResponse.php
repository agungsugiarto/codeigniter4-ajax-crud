<?php

namespace Tests\Support\HTTP;

use CodeIgniter\HTTP\Response;

/**
 * Class MockResponse.
 */
class MockResponse extends Response
{
    /**
     * If true, will not write output. Useful during testing.
     *
     * @var bool
     */
    protected $pretend = true;

    // for testing
    public function getPretend()
    {
        return $this->pretend;
    }

    // artificial error for testing
    public function misbehave()
    {
        $this->statusCode = 0;
    }
}
