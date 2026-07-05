<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemStatusRequest;
use App\Http\Requests\CheckoutRequest;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Item;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct(
        private readonly InventoryService $inventoryService
    ) {}

    public function receiving()
    {
        return view('receiving');
    }

    public function store(StoreItemRequest $request)
    {
        $this->inventoryService->receiveItem($request->validated());

        return redirect('/tracking')->with('success', 'Item added successfully.');
    }

    public function tracking(Request $request)
    {
        $query = Item::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('nsn', 'like', "%{$search}%")
                  ->orWhere('assigned_personnel', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(20);
        $trashed = Item::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('tracking', compact('items', 'trashed'));
    }

    public function maintenance()
    {
        $items = Item::where('status', 'Under Repair')->orWhere('warranty_status', 'Expired')->get();
        return view('maintenance', compact('items'));
    }

    public function updateStatus(UpdateItemStatusRequest $request, Item $item)
    {
        $this->inventoryService->updateStatus($item, $request->validated());

        return back()->with('success', 'Item updated.');
    }

    public function issuance()
    {
        $items = Item::where('status', '!=', 'Decommissioned')->where('quantity', '>', 0)->get();
        return view('issuance', compact('items'));
    }

    public function checkout(CheckoutRequest $request)
    {
        try {
            $this->inventoryService->checkoutItem($request->validated());
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['quantity' => $e->getMessage()]);
        }

        return redirect('/tracking')->with('success', 'Item checked out successfully.');
    }

    public function destroy(Item $item)
    {
        $this->inventoryService->deleteItem($item);

        return redirect('/tracking')->with('success', 'Item deleted successfully.');
    }

    public function restore(Item $item)
    {
        $this->inventoryService->restoreItem($item);

        return redirect('/tracking')->with('success', 'Item restored successfully.');
    }

    public function audit(Request $request)
    {
        $query = Item::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('nsn', 'like', "%{$search}%")
                  ->orWhere('assigned_personnel', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(50);

        $totalQty = Item::sum('quantity');
        $deployed = Item::where('status', 'Deployed')->sum('quantity');
        $inWarehouse = Item::where('status', 'In-Warehouse')->sum('quantity');
        $underRepair = Item::where('status', 'Under Repair')->sum('quantity');
        $decommissioned = Item::where('status', 'Decommissioned')->sum('quantity');

        return view('audit', compact(
            'items', 'totalQty', 'deployed',
            'inWarehouse', 'underRepair', 'decommissioned'
        ));
    }

    public function editItem(Item $item)
    {
        $categories = Category::orderBy('name')->get();
        return view('item-form', compact('item', 'categories'));
    }

    public function updateItem(Request $request, Item $item)
    {
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'nsn' => 'nullable|string|max:255',
            'date_acquired' => 'nullable|date',
            'warranty_status' => 'nullable|string|max:255',
            'status' => 'required|string',
            'location_battalion' => 'nullable|string|max:255',
            'location_storage' => 'nullable|string|max:255',
            'assigned_personnel' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $item->update($data);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Item Updated',
            'description' => "Edited {$item->name} details",
        ]);

        return redirect('/tracking')->with('success', "{$item->name} updated successfully.");
    }

    public function exportCsv()
    {
        $items = Item::with('category')->orderBy('name')->get();

        $filename = 'inventory-export-' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($items) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Category', 'Serial Number', 'NSN', 'Status', 'Qty', 'Location', 'Personnel', 'Warranty', 'Date Acquired']);

            foreach ($items as $item) {
                fputcsv($handle, [
                    $item->name,
                    $item->category->name ?? '',
                    $item->serial_number ?? '',
                    $item->nsn ?? '',
                    $item->status,
                    $item->quantity,
                    $item->location_battalion ?? '',
                    $item->assigned_personnel ?? '',
                    $item->warranty_status ?? '',
                    $item->date_acquired ? $item->date_acquired->format('Y-m-d') : '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
