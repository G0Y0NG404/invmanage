<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Item;
use InvalidArgumentException;

class InventoryService
{
    public function receiveItem(array $data): Item
    {
        if (isset($data['category_id'])) {
            $category = Category::find($data['category_id']);
        } else {
            $category = Category::where('name', $data['name'])->first();
        }
        if ($category) {
            $data['category_id'] = $category->id;
        }

        $item = Item::create($data);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Item Added',
            'description' => "Added {$item->name} (qty: {$item->quantity})",
        ]);

        return $item;
    }

    public function updateStatus(Item $item, array $data): Item
    {
        $oldStatus = $item->status;
        $item->update($data);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Item Updated',
            'description' => "{$item->name}: status {$oldStatus} → {$item->status}",
        ]);

        return $item;
    }

    public function checkoutItem(array $data): Item
    {
        $item = Item::findOrFail($data['item_id']);

        if ($item->quantity < $data['quantity']) {
            throw new InvalidArgumentException('Not enough stock.');
        }

        $item->decrement('quantity', $data['quantity']);
        $item->update([
            'status' => 'Deployed',
            'assigned_personnel' => $data['assigned_personnel'],
            'location_battalion' => $data['location_battalion'],
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Item Issued',
            'description' => "Issued {$data['quantity']}x {$item->name} to {$data['assigned_personnel']}",
        ]);

        return $item;
    }

    public function deleteItem(Item $item): void
    {
        $name = $item->name;
        $item->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Item Deleted',
            'description' => "Deleted {$name}",
        ]);
    }

    public function restoreItem(Item $item): void
    {
        $item->restore();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Item Restored',
            'description' => "Restored {$item->name}",
        ]);
    }
}
