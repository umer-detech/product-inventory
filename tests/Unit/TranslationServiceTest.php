<?php

namespace Tests\Unit;

use App\Models\Translation;
use App\Models\User;
use App\Services\TranslationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TranslationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TranslationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(TranslationService::class);
    }

    public function test_it_creates_a_translation()
    {
        $data = ['key' => 'greeting', 'locale' => 'en', 'value' => 'Hello'];

        $translation = $this->service->store($data);

        $this->assertInstanceOf(Translation::class, $translation);
        $this->assertEquals('Hello', $translation->value);
    }

    public function test_it_updates_a_translation()
    {
        $translation = Translation::factory()->create(['value' => 'Old']);

        $updated = $this->service->update($translation, ['value' => 'New']);

        $this->assertEquals('New', $updated->value);
    }

    public function test_export_json_returns_translations_fast()
    {
        // Authenticate the user (use Passport if using Passport auth)
        $user = User::factory()->create();
        Passport::actingAs($user);

        // Create 1000 translation records
        Translation::factory()->count(1000)->create();

        // Measure time for export operation
        $start = microtime(true);

        // Send request to the export endpoint
        $response = $this->getJson('/api/translations/export/json');

        // Calculate response time
        $time = microtime(true) - $start;

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the JSON structure includes expected locales (like 'en')
        $response->assertJsonStructure([
            'en', // Assuming 'en' is one of the locales in the response
            'fr', // You can add more locales as required
            // Add more locale keys if needed
        ]);

        // Assert that the export response time is less than 0.5 seconds
        $this->assertTrue($time < 0.5, 'Export took too long: ' . $time . ' seconds');
    }


    public function test_paginated_translations_loads_fast()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        Passport::actingAs($user); // For Passport authentication

        // Seed some translation records (for performance testing)
        Translation::factory()->count(1000)->create();

        // Measure time to fetch the paginated results
        $start = microtime(true);

        // Paginated API request
        $response = $this->getJson('/api/translations?page=1&per_page=50');

        $time = microtime(true) - $start;

        // Assert that the response status is 200
        $response->assertStatus(200);

        // Assert that the request takes less than 200ms
        $this->assertTrue($time < 0.2, "Response took too long: {$time}s");
    }

}
