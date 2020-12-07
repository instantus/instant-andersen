<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function testDelete()
    {
        $users = User::factory()->count(2)->create();
        Passport::actingAs($users->last());

        $this->json('DELETE', 'api/users/' . $users->first()->id)
            ->assertStatus(403);
        $this->json('DELETE', 'api/users/' . $users->last()->id)
            ->assertStatus(204);
    }
}

