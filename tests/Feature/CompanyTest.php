<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $company;

    protected function setUp(): void
    {
        parent::setUp();
        
        $adminRole = Role::where('name', 'Super Admin')->first();
        $this->admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->company = Company::factory()->create();
    }

    public function test_admin_can_create_company()
{
    $token = $this->admin->createToken('test-token')->plainTextToken;

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token
    ])->postJson('/api/companies', [
        'name' => 'Test Company',
        'address' => 'Test Address',
        'phone' => '1234567890',
        'company_email' => 'test@company.com',
        'supervisor_name' => 'John Doe',
        'supervisor_phone' => '08123456789',
        'supervisor_email' => 'john@company.com',
        'total_store' => 5,
        'status' => 'active',
        'joined_at' => now()->toDateString(),
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'name' => 'Test Company',
            'address' => 'Test Address',
            'phone' => '1234567890',
            'company_email' => 'test@company.com',
            'supervisor_name' => 'John Doe',
        ]);
}

} 