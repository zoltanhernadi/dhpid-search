<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this-> get('/search');
        $response->assertStatus(200);

    }
}
