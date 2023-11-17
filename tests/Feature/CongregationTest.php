<?php

namespace Tests\Feature;

use App\Models\Congregation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CongregationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->initDatabase();
    }

    public function tearDown(): void
    {
        $this->resetDatabase();
        parent::tearDown();
    }

    // Valid request data creates a new VisibleCongregation and returns a 201 response with the created data
    public function test_valid_request_data(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson('/api/congregation', [
            'identifier' => '123',
            'congregation' => 'Test Congregation',
            'congregation_number' => '001',
            'contact_firstname' => 'John',
            'contact_lastname' => 'Doe',
            'contact_email' => 'john.doe@example.com',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'congregation.created_successfully',
                'data' => [
                    'identifier' => '123',
                    'congregation' => 'Test Congregation',
                    'congregation_number' => '001',
                    'contact_firstname' => 'John',
                    'contact_lastname' => 'Doe',
                    'contact_email' => 'john.doe@example.com',
                ],
            ]);
    }

    // Missing required request data returns a 422 response with validation errors
    public function test_missing_required_data()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson('/api/congregation', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'identifier',
                'congregation',
                'congregation_number',
                'contact_firstname',
                'contact_lastname',
                'contact_email',
            ]);
    }

    // Unique congregation_number creates a new VisibleCongregation and returns a 201 response with the created data
    public function test_unique_congregation_number()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        Congregation::factory()->create([
            'congregation_number' => '001',
        ]);

        $response = $this->postJson('/api/congregation', [
            'identifier' => '123',
            'congregation' => 'Test Congregation',
            'congregation_number' => '002',
            'contact_firstname' => 'John',
            'contact_lastname' => 'Doe',
            'contact_email' => 'john.doe@example.com',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'congregation.created_successfully',
                'data' => [
                    'identifier' => '123',
                    'congregation' => 'Test Congregation',
                    'congregation_number' => '002',
                    'contact_firstname' => 'John',
                    'contact_lastname' => 'Doe',
                    'contact_email' => 'john.doe@example.com',
                ],
            ]);
    }

    // Empty request data returns a 422 response with validation errors
    public function test_empty_request_data()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson('/api/congregation', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'identifier',
                'congregation',
                'congregation_number',
                'contact_firstname',
                'contact_lastname',
                'contact_email',
            ]);
    }

    // Invalid email format returns a 422 response with validation errors
    public function test_invalid_email_format()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson('/api/congregation', [
            'identifier' => '123',
            'congregation' => 'Test Congregation',
            'congregation_number' => '001',
            'contact_firstname' => 'John',
            'contact_lastname' => 'Doe',
            'contact_email' => 'invalid_email',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['contact_email']);
    }

    // Non-unique congregation_number returns a 422 response with validation errors
    public function test_non_unique_congregation_number()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        Congregation::factory()->create([
            'congregation_number' => '001',
        ]);

        $response = $this->postJson('/api/congregation', [
            'identifier' => '123',
            'congregation' => 'Test Congregation',
            'congregation_number' => '001',
            'contact_firstname' => 'John',
            'contact_lastname' => 'Doe',
            'contact_email' => 'john.doe@example.com',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['congregation_number']);
    }

    public function test_delete_existing_congregation()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        Congregation::factory()->create([
            'identifier' => '123',
        ]);

        $response = $this->deleteJson('/api/congregation/123');

        // Assert
        $response->assertStatus(204);
    }
}
