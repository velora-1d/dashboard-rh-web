<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login page is accessible.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Test user can login with correct credentials.
     */
    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@riyadlulhuda.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@riyadlulhuda.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/admin/dashboard');
    }

    /**
     * Test user cannot login with incorrect credentials.
     */
    public function test_user_cannot_login_with_incorrect_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@riyadlulhuda.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@riyadlulhuda.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /**
     * Test user can logout.
     */
    public function test_user_can_logout(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /**
     * Test guests are redirected to login.
     */
    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Test role-based access control.
     */
    public function test_role_based_access_control(): void
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        /** @var \App\Models\User $pendidikan */
        $pendidikan = User::factory()->create(['role' => 'pendidikan']);

        // Admin can access admin dashboard
        $this->actingAs($admin)->get('/admin/dashboard')->assertStatus(200);

        // Pendidikan cannot access admin dashboard
        $this->actingAs($pendidikan)->get('/admin/dashboard')->assertStatus(403);
    }
}
