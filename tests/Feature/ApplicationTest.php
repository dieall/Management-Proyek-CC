<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Muzakki;
use App\Models\Mustahik;
use App\Models\ZisMasuk;
use App\Models\Penyaluran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test welcome page is accessible
     */
    public function test_welcome_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    /**
     * Test login page is accessible
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /**
     * Test user can login with username
     */
    public function test_user_can_login_with_username(): void
    {
        $user = User::factory()->admin()->create([
            'username' => 'testadmin',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'testadmin',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login fails with wrong credentials
     */
    public function test_login_fails_with_wrong_credentials(): void
    {
        User::factory()->admin()->create([
            'username' => 'testadmin',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'testadmin',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    /**
     * Test dashboard requires authentication
     */
    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can access dashboard
     */
    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->admin()->create();
        
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.index');
    }

    /**
     * Test muzakki CRUD operations
     */
    public function test_muzakki_crud_operations(): void
    {
        $user = User::factory()->admin()->create();

        // Create
        $response = $this->actingAs($user)->post('/muzakki', [
            'nama' => 'Ahmad Muzakki',
            'alamat' => 'Jl. Test No. 123',
            'no_hp' => '081234567890',
            'password' => 'password123',
        ]);
        $response->assertStatus(302);
        
        $muzakki = Muzakki::first();
        $this->assertEquals('Ahmad Muzakki', $muzakki->nama);

        // Read
        $response = $this->actingAs($user)->get('/muzakki');
        $response->assertStatus(200);

        // Update
        $response = $this->actingAs($user)->put('/muzakki/' . $muzakki->id_muzakki, [
            'nama' => 'Ahmad Updated',
            'alamat' => 'Jl. Updated',
            'no_hp' => '082345678901',
            'password' => 'newpassword123',
        ]);
        $response->assertStatus(302);

        // Delete
        $response = $this->actingAs($user)->delete('/muzakki/' . $muzakki->id_muzakki);
        $response->assertStatus(302);
    }

    /**
     * Test mustahik CRUD operations
     */
    public function test_mustahik_crud_operations(): void
    {
        $user = User::factory()->admin()->create();

        // Create
        $response = $this->actingAs($user)->post('/mustahik', [
            'nama' => 'Mustahik Test',
            'kategori_mustahik' => 'fakir',
            'alamat' => 'Jl. Test',
            'no_hp' => '081234567890',
            'status' => 'aktif',
        ]);
        $response->assertStatus(302);

        $mustahik = Mustahik::first();
        $this->assertEquals('fakir', $mustahik->kategori_mustahik);

        // Read
        $response = $this->actingAs($user)->get('/mustahik');
        $response->assertStatus(200);

        // Update
        $response = $this->actingAs($user)->put('/mustahik/' . $mustahik->id_mustahik, [
            'nama' => 'Mustahik Updated',
            'kategori_mustahik' => 'miskin',
            'alamat' => 'Jl. Updated',
            'no_hp' => '082345678901',
            'status' => 'aktif',
        ]);
        $response->assertStatus(302);

        // Delete
        $response = $this->actingAs($user)->delete('/mustahik/' . $mustahik->id_mustahik);
        $response->assertStatus(302);
    }

    /**
     * Test ZIS masuk creation
     */
    public function test_zis_masuk_creation(): void
    {
        $user = User::factory()->admin()->create();
        $muzakki = Muzakki::factory()->create();

        $response = $this->actingAs($user)->post('/zis', [
            'id_muzakki' => $muzakki->id_muzakki,
            'jenis_zis' => 'zakat',
            'jumlah' => 1000000,
            'tgl_masuk' => now()->toDateString(),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('zis_masuk', [
            'id_muzakki' => $muzakki->id_muzakki,
            'jenis_zis' => 'zakat',
        ]);
    }

    /**
     * Test user registration
     */
    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'username' => 'newuser',
            'nama_lengkap' => 'New User',
            'email' => 'newuser@test.com',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
        ]);
    }

    /**
     * Test validation on muzakki creation
     */
    public function test_muzakki_validation(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->post('/muzakki', [
            'nama' => '',
            'alamat' => '',
            'no_hp' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['nama']);
    }
}
