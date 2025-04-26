<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Client;
use App\Models\Program;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a client can be enrolled in one or more programs.
     */
    /** @test */
    public function a_client_can_be_enrolled_in_programs()
    {
        // Arrange: Create a client and multiple programs
        $client = Client::factory()->create();
        $programs = Program::factory()->count(3)->create();

        // Prepare enrollment data
        $enrollmentData = [
            'client_id' => $client->id,
            'program_ids' => $programs->pluck('id')->toArray(),
        ];

        // Act: Send a POST request to enroll the client in programs
        $response = $this->postJson('/api/enrollments', $enrollmentData);

        // Assert: Check that the response is successful and the client is enrolled in the programs
        $response->assertStatus(200); // Ensure the response status is 200
        $response->assertJsonStructure([
            'message',
            'enrolled_programs' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        // Assert: Verify that the enrollments exist in the database
        foreach ($programs as $program) {
            $this->assertDatabaseHas('enrollments', [
                'client_id' => $client->id,
                'program_id' => $program->id,
            ]);
        }
    }
}
