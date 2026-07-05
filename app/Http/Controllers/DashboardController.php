<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $totalActive = Item::where('status', '!=', 'Decommissioned')->sum('quantity');
        $deployed = Item::where('status', 'Deployed')->sum('quantity');
        $inRepair = Item::where('status', 'Under Repair')->sum('quantity');
        $lowStock = Item::where('quantity', '<=', 2)->where('status', '!=', 'Decommissioned')->count();

        $catBreakdown = Category::with('items')->get()->mapWithKeys(function ($cat) {
            $qty = $cat->items->where('status', '!=', 'Decommissioned')->sum('quantity');
            return [$cat->name => $qty];
        });

        $priorityItems = Item::with('category')
            ->where(function ($q) {
                $q->where('quantity', '<=', 2)
                  ->orWhere('status', 'Under Repair');
            })
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalActive', 'deployed', 'inRepair', 'lowStock',
            'catBreakdown', 'priorityItems'
        ));
    }
}
