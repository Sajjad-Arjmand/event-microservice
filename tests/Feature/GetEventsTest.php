<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Event;

class GetEventsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_events_successfully()
    {
        Event::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/events');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'user_id', 'event_name', 'payload', 'created_at']
                ]
            ]);
    }

    public function test_get_events_with_filters()
    {
        Event::factory()->create(['user_id' => 999]);

        $response = $this->getJson('/api/v1/events?user_id=999');

        $response->assertStatus(200)
            ->assertJsonFragment(['user_id' => 999]);
    }
}
