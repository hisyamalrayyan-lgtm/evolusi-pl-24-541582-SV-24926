<?php

namespace Tests\Feature;

use App\Models\Tugas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TugasTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that GET /api/tugas returns 200.
     */
    public function test_get_tugas_returns_200(): void
    {
        $response = $this->getJson('/api/tugas');

        $response->assertStatus(200);
    }

    /**
     * Test that POST /api/tugas creates a record.
     */
    public function test_post_tugas_creates_record(): void
    {
        $payload = [
            'judul'     => 'Tugas Pertama',
            'deskripsi' => 'Deskripsi tugas pertama',
            'status'    => 'pending',
        ];

        $response = $this->postJson('/api/tugas', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['judul' => 'Tugas Pertama']);

        $this->assertDatabaseHas('tugas', ['judul' => 'Tugas Pertama']);
    }

    /**
     * Test that GET /api/tugas/{id} returns the correct data.
     */
    public function test_get_single_tugas_returns_correct_data(): void
    {
        $tugas = Tugas::create([
            'judul'     => 'Tugas Detail',
            'deskripsi' => 'Detail deskripsi',
            'status'    => 'selesai',
        ]);

        $response = $this->getJson("/api/tugas/{$tugas->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'judul'  => 'Tugas Detail',
                     'status' => 'selesai',
                 ]);
    }
}
