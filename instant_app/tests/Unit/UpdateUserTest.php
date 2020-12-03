<?php

namespace Tests\Unit;

use App\Services\UserService;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use \Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use DatabaseMigrations;

    protected $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
        Artisan::call('passport:install');
    }

    public function testUpdate()
    {
        $users = User::factory()->count(2)->create(
            ['name' => 'Short_Name']
        );
        $user = $users->last();
        Passport::actingAs($user);

        $data = [
            'name' => 'Full_Name',
            'email' => 'test@gmail.com',
            'password' => '12345678'
        ];

        $this->userService->updateUser($data, $user);
        $this->assertDatabaseHas('users', [
            'name' => 'Full_Name',
            'email' => 'test@gmail.com']);
    }
}
