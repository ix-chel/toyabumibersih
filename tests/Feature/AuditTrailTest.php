<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\AuditTrail;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditTrailTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $auditTrail;

    protected function setUp(): void
    {
        parent::setUp();
        
        $adminRole = Role::where('name', 'Super Admin')->first();
        $this->admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->auditTrail = AuditTrail::factory()->create([
            'user_id' => $this->admin->id
        ]);
    }

    public function test_admin_can_view_all_audit_trails()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/audit-trails');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'user_id',
                    'action',
                    'description',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function test_admin_can_create_audit_trail()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/audit-trails', [
            'user_id' => $this->admin->id,
            'action' => 'test_action',
            'description' => 'Test audit trail description'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'user_id' => $this->admin->id,
                'action' => 'test_action',
                'description' => 'Test audit trail description'
            ]);
    }

    public function test_admin_can_view_specific_audit_trail()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/audit-trails/' . $this->auditTrail->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $this->auditTrail->id,
                'user_id' => $this->admin->id
            ]);
    }

    public function test_unauthorized_user_cannot_view_audit_trails()
    {
        $response = $this->getJson('/api/audit-trails');

        $response->assertStatus(401);
    }

    public function test_technician_cannot_view_audit_trails()
    {
        $technicianRole = Role::where('name', 'Technician')->first();
        $technician = User::factory()->create(['role_id' => $technicianRole->id]);
        $token = $technician->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/audit-trails');

        $response->assertStatus(403);
    }
} 