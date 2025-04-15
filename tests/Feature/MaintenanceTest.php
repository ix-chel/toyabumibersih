<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company;
use App\Models\Store;
use App\Models\MaintenanceReport;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $technician;
    protected $company;
    protected $store;
    protected $maintenance;

    protected function setUp(): void
    {
        parent::setUp();
        
        $adminRole = Role::where('name', 'Super Admin')->first();
        $technicianRole = Role::where('name', 'Technician')->first();
        
        $this->admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->technician = User::factory()->create(['role_id' => $technicianRole->id]);
        
        $this->company = Company::factory()->create();
        $this->store = Store::factory()->create(['company_id' => $this->company->id]);
        $this->maintenance = MaintenanceReport::factory()->create([
            'store_id' => $this->store->id,
            'technician_id' => $this->technician->id
        ]);
    }

    public function test_technician_can_create_maintenance_report()
    {
        $token = $this->technician->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/maintenance-reports', [
            'store_id' => $this->store->id,
            'technician_id' => $this->technician->id,
            'maintenance_date' => now()->format('Y-m-d'),
            'description' => 'Test maintenance description',
            'status' => 'completed'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'store_id' => $this->store->id,
                'technician_id' => $this->technician->id,
                'description' => 'Test maintenance description',
                'status' => 'completed'
            ]);
    }

    public function test_admin_can_view_all_maintenance_reports()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/maintenance-reports');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'store_id',
                    'technician_id',
                    'maintenance_date',
                    'description',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function test_technician_can_update_own_maintenance_report()
    {
        $token = $this->technician->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->putJson('/api/maintenance-reports/' . $this->maintenance->id, [
            'description' => 'Updated maintenance description',
            'status' => 'in_progress'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'description' => 'Updated maintenance description',
                'status' => 'in_progress'
            ]);
    }

    public function test_admin_can_delete_maintenance_report()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->deleteJson('/api/maintenance-reports/' . $this->maintenance->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('maintenance_reports', ['id' => $this->maintenance->id]);
    }

    public function test_technician_cannot_delete_maintenance_report()
    {
        $token = $this->technician->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->deleteJson('/api/maintenance-reports/' . $this->maintenance->id);

        $response->assertStatus(403);
    }
} 