<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use App\Services\InventoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class InventoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private InventoryService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(InventoryService::class);

        $user = User::factory()->create();
        $this->actingAs($user);

        Category::create(['name' => 'Radios', 'slug' => 'radios', 'description' => '']);
    }

    public function test_can_receive_item_with_category_matching(): void
    {
        $item = $this->service->receiveItem([
            'name' => 'Radios',
            'serial_number' => 'SNR-001',
            'status' => 'In-Warehouse',
            'quantity' => 5,
        ]);

        $this->assertDatabaseHas('items', ['id' => $item->id, 'serial_number' => 'SNR-001']);
        $this->assertEquals(1, $item->category_id);
    }

    public function test_can_receive_item_without_category(): void
    {
        $item = $this->service->receiveItem([
            'name' => 'Unknown Device',
            'serial_number' => 'SNR-999',
            'status' => 'In-Warehouse',
            'quantity' => 1,
        ]);

        $this->assertNull($item->category_id);
    }

    public function test_can_update_item_status(): void
    {
        $item = Item::factory()->create(['status' => 'In-Warehouse']);

        $this->service->updateStatus($item, ['status' => 'Deployed']);

        $this->assertEquals('Deployed', $item->fresh()->status);
    }

    public function test_can_checkout_item(): void
    {
        $item = Item::factory()->create([
            'quantity' => 10,
            'status' => 'In-Warehouse',
        ]);

        $this->service->checkoutItem([
            'item_id' => $item->id,
            'quantity' => 3,
            'assigned_personnel' => 'SGT Reyes',
            'location_battalion' => '1st Signal Bn',
        ]);

        $item->refresh();

        $this->assertEquals(7, $item->quantity);
        $this->assertEquals('Deployed', $item->status);
        $this->assertEquals('SGT Reyes', $item->assigned_personnel);
    }

    public function test_throws_exception_when_stock_insufficient(): void
    {
        $item = Item::factory()->create(['quantity' => 2]);

        $this->expectException(InvalidArgumentException::class);

        $this->service->checkoutItem([
            'item_id' => $item->id,
            'quantity' => 5,
            'assigned_personnel' => 'CPL Cruz',
            'location_battalion' => '2nd Signal Bn',
        ]);
    }

    public function test_soft_deletes_item(): void
    {
        $item = Item::factory()->create();

        $this->service->deleteItem($item);

        $this->assertSoftDeleted($item);
    }

    public function test_can_restore_item(): void
    {
        $item = Item::factory()->create();
        $item->delete();

        $this->service->restoreItem($item);

        $this->assertNotSoftDeleted($item);
    }

    public function test_logs_activity_on_receive(): void
    {
        $this->service->receiveItem([
            'name' => 'Test Item',
            'status' => 'In-Warehouse',
            'quantity' => 1,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'Item Added',
        ]);
    }
}
