<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class GetUsersTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function testRegister()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        $firstUser = [
            'name' => 'Full_Name',
            'email' => 'first@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];
        $secondUser = $firstUser;
        $secondUser['email'] = 'second@gmail.com';

        $this->json('POST', 'api/users', $firstUser, $headers)->assertStatus(201);
        $response = $this->json('POST', 'api/users', $secondUser, $headers)->assertStatus(201);
        $token = $response->getOriginalContent()['token'];
        $headers['Authorization'] = 'Bearer '.$token;

        $this->json('GET', 'api/users', [], $headers)
            ->assertStatus(200)->assertJsonStructure(['users']);

        $this->json('GET', 'api/users/1', [], $headers)
            ->assertStatus(403);

        $this->json('GET', 'api/users/2', [], $headers)
            ->assertStatus(200)->assertJsonStructure(['email']);

        $this->json('GET', 'api/users/3', [], $headers)
            ->assertStatus(404);
    }
}
