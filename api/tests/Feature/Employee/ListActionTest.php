<?php

namespace Tests\Feature\Employee;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\FeatureTestCase;
use Tests\TestCase;

class ListActionTest extends FeatureTestCase
{
    public function test_guest_access(): void
    {
        $response = $this->get('/api/employees');
        $response->assertStatus(401);
    }

    public function test_user_access(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $response = $this->get('/api/employees');
        $response->assertStatus(200);

        $json = json_decode($response->getContent());
        $this->assertTrue($json->success);
    }
}
