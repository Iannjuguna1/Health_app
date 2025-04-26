<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Program;

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a program can be created successfully.
     */
    /** @test */
    public function a_program_can_be_created_successfully()
    {
        // Arrange: Prepare program data
        $programData = [
            'name' => 'HIV Awareness Program',
            'description' => 'A program to raise awareness about HIV prevention and treatment.',
            'status' => 'active',
        ];

        // Act: Send a POST request to create the program
        $response = $this->postJson('/api/programs', $programData);

        // Assert: Check that the response is successful and the program is saved in the database
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'program' => [
                'id',
                'name',
                'description',
                'status',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('programs', [
            'name' => 'HIV Awareness Program',
            'description' => 'A program to raise awareness about HIV prevention and treatment.',
            'status' => 'active',
        ]);
    }

    /**
     * Test that all programs can be listed.
     */
    /** @test */
    public function all_programs_can_be_listed()
    {
        // Arrange: Create multiple programs
        Program::factory()->count(3)->create();

        // Act: Send a GET request to list all programs
        $response = $this->getJson('/api/programs');

        // Assert: Check that the response is successful and contains the programs
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'description',
                'status',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test that a program can be updated successfully.
     */
    /** @test */
    public function a_program_can_be_updated_successfully()
    {
        // Arrange: Create a program
        $program = Program::factory()->create([
            'name' => 'Old Program Name',
            'description' => 'Old description.',
            'status' => 'active',
        ]);

        // Prepare updated program data
        $updatedData = [
            'name' => 'Updated Program Name',
            'description' => 'Updated description.',
            'status' => 'active',
        ];

        // Act: Send a PUT request to update the program
        $response = $this->putJson("/api/programs/{$program->id}", $updatedData);

        // Assert: Check that the response is successful and the program is updated in the database
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'program' => [
                'id',
                'name',
                'description',
                'status',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'name' => 'Updated Program Name',
            'description' => 'Updated description.',
            'status' => 'active',
        ]);
    }

    /**
     * Test that a program can be suspended successfully.
     */
    /** @test */
    public function a_program_can_be_suspended_successfully()
    {
        // Arrange: Create a program
        $program = Program::factory()->create([
            'name' => 'Active Program',
            'description' => 'This program is active.',
            'status' => 'active',
        ]);

        // Act: Send a PATCH request to suspend the program
        $response = $this->patchJson("/api/programs/{$program->id}/suspend");

        // Assert: Check that the response is successful and the program is suspended
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'program' => [
                'id',
                'name',
                'description',
                'status',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'status' => 'suspended',
        ]);
    }
}
