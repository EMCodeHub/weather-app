<?php

namespace Tests\Feature\Models;

use App\Models\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_request()
    {
        $data = [
            'latitude' => 55.0,
            'longitude' => 13.0,
        ];

        $request = Request::create($data);

        $this->assertDatabaseHas('requests', $data);
        $this->assertEquals($data['latitude'], $request->latitude);
        $this->assertEquals($data['longitude'], $request->longitude);
    }
}
