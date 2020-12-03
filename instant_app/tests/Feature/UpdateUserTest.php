<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function testShow()
    {
        $users = User::factory()->count(2)->create(
            ['name' => 'Short_Name']
        );
        $user = $users->last();
        Passport::actingAs($user);

        $data = [
            'name' => 'Full_Name',
            'email' => 'test222@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        $this->json('PUT', 'api/users/'.$users->first()->id, $data)
            ->assertStatus(403);
        $this->json('PUT', 'api/users/'.$user->id, $data)
            ->assertStatus(200);
    }
}
