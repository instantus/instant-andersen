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
        $users = User::factory()->count(2)->create();
        Passport::actingAs($users->last());

        $this->json('GET', 'api/users/'.$users->first()->id)
            ->assertStatus(403);
        $this->json('GET', 'api/users/'.$users->last()->id)
            ->assertStatus(200);
    }
}
