<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Client;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a client can be registered successfully.
     */
    /** @test */
    public function a_client_can_be_registered_successfully()
    {
        // Arrange: Prepare client data
        $clientData = [
            'first_name' => 'Ian',
            'last_name' => 'Njuguna',
            'email' => 'ian@example.com',
            'phone' => '0712345678',
        ];

        // Act: Send a POST request to register the client
        $response = $this->postJson('/api/clients', $clientData);

        // Assert: Check that the response is successful and the client is saved in the database
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'client' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('clients', [
            'email' => 'ian@example.com',
        ]);
    }

    /**
     * Test that client registration requires all fields.
     */

    public function client_registration_requires_all_fields()
    {
        // Act: Send a POST request with empty data
        $response = $this->postJson('/api/clients', []);

        // Assert: Check that the response returns validation errors for required fields
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'phone']);
    }

    /**
     * Test that client registration requires a valid email.
     */

    public function client_registration_requires_a_valid_email()
    {
        // Arrange: Prepare client data with an invalid email
        $clientData = [
            'first_name' => 'Ian',
            'last_name' => 'Njuguna',
            'email' => 'invalid-email', // Invalid email
            'phone' => '0712345678',
        ];

        // Act: Send a POST request to register the client
        $response = $this->postJson('/api/clients', $clientData);

        // Assert: Check that the response returns a validation error for the email field
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * Test that client registration requires a unique email.
        */
    public function client_registration_requires_unique_email()
    {
        // Arrange: Create an existing client with the same email
        Client::factory()->create(['email' => 'ian@example.com']);

        // Prepare client data with a duplicate email
        $clientData = [
            'first_name' => 'Ian',
            'last_name' => 'Njuguna',
            'email' => 'ian@example.com', // Duplicate email
            'phone' => '0712345678',
        ];

        // Act: Send a POST request to register the client
        $response = $this->postJson('/api/clients', $clientData);

        // Assert: Check that the response returns a validation error for the email field
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * Test that a client can be deleted successfully.
     */
    /** @test */
    public function a_client_can_be_deleted()
    {
        // Arrange: Create a client
        $client = Client::factory()->create();

        // Act: Send a DELETE request to delete the client
        $response = $this->deleteJson("/api/clients/{$client->id}");

        // Assert: Check that the response is successful and the client is soft deleted
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Client deleted successfully']);

        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }

    /**
     * Test that a client's profile can be retrieved successfully.
     */
    /** @test */
    public function a_client_profile_can_be_retrieved()
    {
        // Arrange: Create a client
        $client = Client::factory()->create();

        // Act: Send a GET request to retrieve the client's profile
        $response = $this->getJson("/api/clients/{$client->id}");

        // Assert: Check that the response is successful and contains the client's data
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'client' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}
