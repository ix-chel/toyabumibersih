<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company;
use App\Models\Store;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $company;
    protected $store;

    protected function setUp(): void
    {
        parent::setUp();
        
        $adminRole = Role::where('name', 'Super Admin')->first();
        $this->admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->company = Company::factory()->create();
        $this->store = Store::factory()->create(['company_id' => $this->company->id]);
    }

    public function test_admin_can_create_store()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/stores', [
            'company_id' => $this->company->id,
            'name' => 'Test Store',
            'address' => 'Test Address',
            'phone' => '1234567890',
            'email' => 'test@store.com'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'company_id' => $this->company->id,
                'name' => 'Test Store',
                'address' => 'Test Address',
                'phone' => '1234567890',
                'email' => 'test@store.com'
            ]);
    }

    public function test_admin_can_view_stores()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/stores');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'company_id',
                    'name',
                    'address',
                    'phone',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function test_admin_can_update_store()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->putJson('/api/stores/' . $this->store->id, [
            'name' => 'Updated Store Name',
            'address' => 'Updated Address',
            'phone' => '0987654321',
            'email' => 'updated@store.com'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Updated Store Name',
                'address' => 'Updated Address',
                'phone' => '0987654321',
                'email' => 'updated@store.com'
            ]);
    }

    public function test_admin_can_delete_store()
    {
        $token = $this->admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->deleteJson('/api/stores/' . $this->store->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('stores', ['id' => $this->store->id]);
    }

    public function test_technician_cannot_create_store()
    {
        $technicianRole = Role::where('name', 'Technician')->first();
        $technician = User::factory()->create(['role_id' => $technicianRole->id]);
        $token = $technician->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/stores', [
            'company_id' => $this->company->id,
            'name' => 'Test Store',
            'address' => 'Test Address',
            'phone' => '1234567890',
            'email' => 'test@store.com'
        ]);

        $response->assertStatus(403);
    }
} 