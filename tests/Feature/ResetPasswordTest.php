<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    private function getHeaders()
    {
        return [
            'Accept' => 'application/json',
            'X-API-KEY' => 'craftive-public-key-2026',
        ];
    }

    public function test_forgot_password_fails_if_email_does_not_exist()
    {
        $payload = ['email' => 'nonexistent@example.com'];

        $response = $this->postJson('/api/auth/forgot-password', $payload, $this->getHeaders());

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_forgot_password_succeeds_and_saves_otp_to_cache()
    {
        $user = User::factory()->create([
            'email' => 'test@craftive.id',
            'name' => 'Test User'
        ]);

        $payload = ['email' => 'test@craftive.id'];

        $response = $this->postJson('/api/auth/forgot-password', $payload, $this->getHeaders());

        // Should return 200 and demo_mode true/false
        $response->assertStatus(200);

        // Assert OTP is saved in cache
        $cachedOtp = Cache::get('reset_otp_test@craftive.id');
        $this->assertNotNull($cachedOtp);
        $this->assertEquals(6, strlen((string)$cachedOtp));
    }

    public function test_reset_password_fails_with_invalid_otp()
    {
        $user = User::factory()->create([
            'email' => 'test@craftive.id',
            'name' => 'Test User'
        ]);

        // Place a correct OTP in cache
        Cache::put('reset_otp_test@craftive.id', 123456, now()->addMinutes(10));

        $payload = [
            'email' => 'test@craftive.id',
            'otp' => '654321', // wrong OTP
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $response = $this->postJson('/api/auth/reset-password', $payload, $this->getHeaders());

        $response->assertStatus(422)
                 ->assertJsonPath('error', 'Kode OTP tidak valid atau telah kedaluwarsa.');
    }

    public function test_reset_password_succeeds_with_valid_otp_and_updates_password()
    {
        $user = User::factory()->create([
            'email' => 'test@craftive.id',
            'name' => 'Test User',
            'password' => Hash::make('oldpassword')
        ]);

        // Place correct OTP in cache
        Cache::put('reset_otp_test@craftive.id', 123456, now()->addMinutes(10));

        $payload = [
            'email' => 'test@craftive.id',
            'otp' => '123456',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $response = $this->postJson('/api/auth/reset-password', $payload, $this->getHeaders());

        $response->assertStatus(200)
                 ->assertJsonPath('message', 'Kata sandi Anda berhasil diperbarui. Silakan masuk kembali.');

        // Verify password is updated
        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));

        // Verify OTP is cleared from cache
        $this->assertNull(Cache::get('reset_otp_test@craftive.id'));
    }

    public function test_update_profile_succeeds()
    {
        $user = User::factory()->create([
            'email' => 'test@craftive.id',
            'name' => 'Original Name'
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'X-API-KEY' => 'craftive-public-key-2026',
        ];

        $payload = [
            'name' => 'New Name',
            'email' => 'test@craftive.id',
            'phone' => '081234567890',
            'address' => 'JL.Imam Bonjol No.45'
        ];

        $response = $this->putJson('/api/auth/profile', $payload, $headers);

        $response->assertStatus(200)
                 ->assertJsonPath('user.name', 'New Name')
                 ->assertJsonPath('user.address', 'JL.Imam Bonjol No.45');
    }
}
