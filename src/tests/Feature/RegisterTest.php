<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testName()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $postData = [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->post('/register', $postData);
        $response->assertSessionHasErrors([
        ]);
    }

    /** @test */
    public function testEmail()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $postData = [
            'name' => 'テストユーザー',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->post('/register', $postData);
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    /** @test */
    public function testPassword()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $postData = [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => ''
        ];

        $response = $this->post('/register', $postData);
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    /** @test */
    public function testPasswordNumber()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $postData = [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'pass123',          
            'password_confirmation' => 'pass123',
        ];

        $response = $this->post('/register', $postData);

        $response->assertSessionHasErrors([
        ]);
    }

    /** @test */
    public function testConfirmationPassword()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $postData = [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password456', 
        ];

        $response = $this->post('/register', $postData);
        $response->assertSessionHasErrors(['password']);
    }

    public function testRegisterComplete()
    {
        $postData = [
            'name' => 'テストユーザー',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123', 
        ];

        $response = $this->post('/register', $postData);
        $response->assertRedirect(route('verification.notice'));

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
            'name' => 'テストユーザー',
        ]);
        $this->assertAuthenticated();
    }
}
