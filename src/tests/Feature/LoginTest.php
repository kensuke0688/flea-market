<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testEmail()
    {
        $postData = [
            'email' => '',
            'password' => 'password123',
        ];

        $response = $this->from('/login')->post('/login', $postData);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    public function testPassword()
    {
        $postData = [
            'email' => 'testuser@example.com',
            'password' => '',
        ];

        $response = $this->from('/login')->post('/login', $postData);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    public function testLoginInformation()
    {
        $postData = [
            'email' => 'noname@example.com',
            'password' => 'password',
        ];

        $response = $this->from('/login')->post('/login', $postData);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);

        $this->assertGuest();
    }

    public function testLoginComplete()
    {
        $postData = [
            'email' => 'testuser@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/login', $postData);
        $response->assertRedirect('/'); 
    }
}
