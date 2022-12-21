<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
//        $a = 'It works';
//        $this->assertEquals('It works',$a);

        $response = $this->get('/test');

        $response->assertStatus(200);
    }
}
