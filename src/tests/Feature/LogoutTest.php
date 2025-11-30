<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testLogout()
    {
        $user = new User([
            'id' => 1,
            'name' => 'テストユーザー',
            'email' => 'testuser@example.com',
        ]);

        $this->actingAs($user); 
        $response = $this->post('/logout');
        $response->assertRedirect('/'); 
        $this->assertGuest();
    }
}
