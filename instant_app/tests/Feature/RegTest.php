<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RegTest extends TestCase
{
    use DatabaseMigrations;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function testRegister() {
        $data = [
            'name' => 'fullname',
            'email' => 'another2@gmail.com',
            'password' => '12312312',
            'password_confirmation' => '12312312'
        ];
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        $response = $this->json('POST', 'api/users', $data, $headers)
            ->assertStatus(201)
            ->assertJsonStructure(['token']);
    }
}
