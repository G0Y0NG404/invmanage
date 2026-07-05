<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();

        Category::create(['name' => 'Radios', 'slug' => 'radios', 'description' => '']);
    }

    public function test_admin_can_access_receiving_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/receiving');

        $response->assertStatus(200);
    }

    public function test_admin_can_add_item(): void
    {
        $response = $this->actingAs($this->admin)->post('/receiving', [
            'name' => 'Radio',
            'serial_number' => 'SNR-001',
            'status' => 'In-Warehouse',
            'quantity' => 5,
        ]);

        $response->assertRedirect('/tracking');
        $this->assertDatabaseHas('items', ['serial_number' => 'SNR-001']);
    }

    public function test_admin_can_delete_item(): void
    {
        $item = Item::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/tracking/{$item->id}");

        $response->assertRedirect('/tracking');
        $this->assertSoftDeleted($item);
    }

    public function test_admin_can_checkout_item(): void
    {
        $item = Item::factory()->create(['quantity' => 10, 'status' => 'In-Warehouse']);

        $response = $this->actingAs($this->admin)->post('/issuance/checkout', [
            'item_id' => $item->id,
            'quantity' => 3,
            'assigned_personnel' => 'SGT Reyes',
            'location_battalion' => '1st Signal Bn',
        ]);

        $response->assertRedirect('/tracking');
        $this->assertEquals(7, $item->fresh()->quantity);
        $this->assertEquals('Deployed', $item->fresh()->status);
    }

    public function test_admin_can_update_item_status(): void
    {
        $item = Item::factory()->create(['status' => 'In-Warehouse']);

        $response = $this->actingAs($this->admin)->post("/tracking/{$item->id}/update", [
            'status' => 'Deployed',
        ]);

        $response->assertRedirect();
        $this->assertEquals('Deployed', $item->fresh()->status);
    }

    public function test_admin_can_restore_item(): void
    {
        $item = Item::factory()->create();
        $item->delete();

        $response = $this->actingAs($this->admin)->post("/tracking/{$item->id}/restore");

        $response->assertRedirect('/tracking');
        $this->assertNotSoftDeleted($item);
    }

    public function test_guest_cannot_access_tracking(): void
    {
        $response = $this->get('/tracking');

        $response->assertRedirect('/login');
    }

    public function test_tracking_page_paginates_items(): void
    {
        Item::factory(25)->create();

        $response = $this->actingAs($this->admin)->get('/tracking');

        $response->assertStatus(200);
    }

    public function test_maintenance_page_shows_repair_items(): void
    {
        Item::factory()->create(['status' => 'Under Repair', 'warranty_status' => 'Under Warranty']);
        Item::factory()->create(['status' => 'In-Warehouse', 'warranty_status' => 'Expired']);

        $response = $this->actingAs($this->admin)->get('/maintenance');

        $response->assertStatus(200);
    }

    public function test_audit_page_is_accessible(): void
    {
        $response = $this->actingAs($this->admin)->get('/audit');

        $response->assertStatus(200);
    }
}
