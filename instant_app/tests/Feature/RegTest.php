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
            'name' => 'Full_Name',
            'email' => 'another@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];
        $dataAuth = [
            'email' => 'another@gmail.com',
            'password' => '12345678',
        ];
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        $this->json('POST', 'api/users', $data, $headers)
            ->assertStatus(201)
            ->assertJsonStructure(['token']);

        $this->json('POST', 'api/auth', $dataAuth, $headers)
            ->assertStatus(201)
            ->assertJsonStructure(['token']);
    }
}
