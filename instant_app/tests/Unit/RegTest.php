<?php

namespace Tests\Unit;

use App\Services\UserService;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use \Tests\TestCase;

class RegTest extends TestCase
{
    use DatabaseMigrations;
    protected $userService;
    public function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
        Artisan::call('passport:install');
    }

    public function testCreate()
    {
        $data = [
            'name' => 'Full_Name',
            'email' => 'test@gmail.com',
            'password' => '12345678'
        ];
        $createdUser = $this->userService->createUser($data);
        $this->assertInstanceOf(User::class, $createdUser, 'Create user: Failed');
        $this->assertDatabaseHas('users', ['email' => 'test@gmail.com']);

        $getUser = $this->userService->getUser($data);
        $this->assertInstanceOf(User::class, $getUser, 'Get user: Failed');
    }
}
