<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company;
use App\Models\FeedbackComplaint;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackComplaintTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $company;
    protected $feedback;

    protected function setUp(): void
    {
        parent::setUp();
        
        $adminRole = Role::where('name', 'Super Admin')->first();
        $this->admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->company = Company::factory()->create();
        $this->feedback = FeedbackComplaint::factory()->create([
            'company_id' => $this->company->id
        ]);
    }

    public function test_anyone_can_create_feedback()
    {
        $response = $this->postJson('/api/feedback-complaints', [
            'company_id' => $this->company->id,
            'type' => 'feedback',
            'title' => 'Test Feedback',
            'description' => 'Test feedback description',
            'status' => 'pending'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'company_id' => $this->company->id,
                'type' => 'feedback',
                'title' => 'Test Feedback',
                'description' => 'Test feedback description',
                'status' => 'pending'
            ]);
    }

    public function test_admin_can_view_all_feedback()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/feedback-complaints');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'company_id',
                    'type',
                    'title',
                    'description',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function test_admin_can_update_feedback_status()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->putJson('/api/feedback-complaints/' . $this->feedback->id, [
            'status' => 'resolved'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'resolved'
            ]);
    }

    public function test_admin_can_delete_feedback()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->deleteJson('/api/feedback-complaints/' . $this->feedback->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('feedback_complaints', ['id' => $this->feedback->id]);
    }

    public function test_unauthorized_user_cannot_update_feedback()
    {
        $response = $this->putJson('/api/feedback-complaints/' . $this->feedback->id, [
            'status' => 'resolved'
        ]);

        $response->assertStatus(401);
    }
} 