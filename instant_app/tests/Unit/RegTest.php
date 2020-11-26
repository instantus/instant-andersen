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
            'name' => 'fullname',
            'email' => 'test1233@gmail.com',
            'password' => '12312312'
        ];
        $createdUser = $this->userService->createUser($data);
        $this->assertInstanceOf(User::class, $createdUser, 'Not match');
        $this->assertDatabaseHas('users', ['email' => 'test1233@gmail.com']);
    }
}
