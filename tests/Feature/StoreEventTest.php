<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Event;

class StoreEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_event_successfully()
    {
        $data = [
            'user_id' => 12345,
            'event_name' => 'button_clicked',
            'payload' => json_encode(['key' => 'value'])
        ];

        $response = $this->postJson('/api/v1/event', $data);

        $response->assertStatus(201)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('events', [
            'user_id' => 12345,
            'event_name' => 'button_clicked'
        ]);
    }

    public function test_store_event_with_invalid_data()
    {
        $response = $this->postJson('/api/v1/event', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['user_id', 'event_name']);
    }
}
