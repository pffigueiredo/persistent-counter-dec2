<?php

namespace Tests\Feature;

use App\Models\Counter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CounterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the counter index page displays correctly.
     */
    public function test_counter_index_displays_correctly(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('Welcome')
                 ->has('count');
        });
    }

    /**
     * Test counter starts at zero when no counter exists.
     */
    public function test_counter_starts_at_zero(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->where('count', 0);
        });

        $this->assertDatabaseHas('counters', [
            'count' => 0
        ]);
    }

    /**
     * Test counter can be incremented.
     */
    public function test_counter_can_be_incremented(): void
    {
        Counter::create(['count' => 5]);

        $response = $this->post('/counter', ['action' => 'increment']);

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->where('count', 6);
        });

        $this->assertDatabaseHas('counters', [
            'count' => 6
        ]);
    }

    /**
     * Test counter can be decremented.
     */
    public function test_counter_can_be_decremented(): void
    {
        Counter::create(['count' => 5]);

        $response = $this->post('/counter', ['action' => 'decrement']);

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->where('count', 4);
        });

        $this->assertDatabaseHas('counters', [
            'count' => 4
        ]);
    }

    /**
     * Test counter defaults to increment when no action specified.
     */
    public function test_counter_defaults_to_increment(): void
    {
        Counter::create(['count' => 3]);

        $response = $this->post('/counter');

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->where('count', 4);
        });

        $this->assertDatabaseHas('counters', [
            'count' => 4
        ]);
    }

    /**
     * Test counter persists across requests.
     */
    public function test_counter_persists_across_requests(): void
    {
        // First request creates counter at 0
        $this->get('/');
        
        // Increment counter
        $this->post('/counter', ['action' => 'increment']);
        
        // New request should show incremented value
        $response = $this->get('/');
        
        $response->assertInertia(function ($page) {
            $page->where('count', 1);
        });
    }
}