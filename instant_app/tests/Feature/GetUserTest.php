<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function testShow()
    {
        User::factory()->count(2)->create();
        $user = User::factory()->make();
        Passport::actingAs($user);

        $this->json('GET', 'api/users/1')
            ->assertStatus(403);
        $this->json('GET', 'api/users/'.$user->id)
            ->assertStatus(200);
    }
}
