<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetUsersTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function testIndex()
    {
        $user = User::factory()->make();
        Passport::actingAs($user);

        $this->json('GET', 'api/users')
            ->assertStatus(200)->assertJsonStructure(['users']);
    }
}
