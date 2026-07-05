<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        // Tactical Communications
        $cat1 = 1;
        $items1 = [
            ['Military Grade Radios (HF/VHF/UHF)', 'RAD-001', 'NSN-5820-01-234-5678', '2024-03-15', 'Under Warranty', 'Deployed', '1st Signal Bn', 'Locker A1', 'SGT Reyes', 45],
            ['Satellite Terminals (SATCOM)', 'SAT-002', 'NSN-5895-01-345-6789', '2024-06-01', 'Under Warranty', 'Deployed', '2nd Signal Bn', 'Locker B3', 'CPL Mercado', 12],
            ['Antenna Systems', 'ANT-003', 'NSN-5985-01-456-7890', '2023-11-20', 'Expired', 'In-Warehouse', 'HQ Company', 'Locker C1', null, 30],
            ['Tactical Routers', 'RTR-004', 'NSN-5895-01-567-8901', '2024-09-10', 'Under Warranty', 'Deployed', '3rd Signal Bn', 'Locker A2', 'LT Garcia', 25],
            ['Field Phones', 'PHN-005', 'NSN-5805-01-678-9012', '2023-05-30', 'Expired', 'In-Warehouse', '1st Signal Bn', 'Locker D1', null, 60],
        ];
        foreach ($items1 as $item) {
            Item::create([
                'category_id' => $cat1,
                'name' => $item[0], 'serial_number' => $item[1], 'nsn' => $item[2],
                'date_acquired' => $item[3], 'warranty_status' => $item[4],
                'status' => $item[5], 'location_battalion' => $item[6],
                'location_storage' => $item[7], 'assigned_personnel' => $item[8],
                'quantity' => $item[9],
            ]);
        }

        // Computing Hardware
        $cat2 = 2;
        $items2 = [
            ['Ruggedized Laptops', 'LAP-001', 'NSN-7025-01-789-0123', '2024-02-20', 'Under Warranty', 'Deployed', '1st Signal Bn', 'Locker E1', 'CPL Tan', 80],
            ['Monitors', 'MON-002', 'NSN-7025-01-890-1234', '2024-04-15', 'Under Warranty', 'In-Warehouse', 'HQ Company', 'Locker E2', null, 100],
            ['CPU Units (Workstations)', 'CPU-003', 'NSN-7025-01-901-2345', '2023-08-01', 'Expired', 'Deployed', '2nd Signal Bn', 'Locker E3', 'SGT Lim', 55],
            ['Keyboards', 'KBD-004', 'NSN-7025-01-012-3456', '2024-01-10', 'Under Warranty', 'In-Warehouse', 'HQ Company', 'Locker E4', null, 150],
            ['Optical Mice', 'MOU-005', 'NSN-7025-01-123-4567', '2024-01-10', 'Under Warranty', 'In-Warehouse', 'HQ Company', 'Locker E4', null, 150],
            ['Server Racks', 'SRV-006', 'NSN-7025-01-234-5679', '2023-10-05', 'Expired', 'Under Repair', 'HQ Company', 'Locker F1', null, 8],
        ];
        foreach ($items2 as $item) {
            Item::create([
                'category_id' => $cat2,
                'name' => $item[0], 'serial_number' => $item[1], 'nsn' => $item[2],
                'date_acquired' => $item[3], 'warranty_status' => $item[4],
                'status' => $item[5], 'location_battalion' => $item[6],
                'location_storage' => $item[7], 'assigned_personnel' => $item[8],
                'quantity' => $item[9],
            ]);
        }

        // Power and Infrastructure
        $cat3 = 3;
        $items3 = [
            ['Portable Generators', 'GEN-001', 'NSN-6115-01-345-6780', '2024-05-20', 'Under Warranty', 'Deployed', '1st Signal Bn', 'Locker G1', 'SGT Reyes', 20],
            ['UPS (Uninterruptible Power Supply)', 'UPS-002', 'NSN-6120-01-456-7891', '2024-07-01', 'Under Warranty', 'In-Warehouse', 'HQ Company', 'Locker G2', null, 35],
            ['Solar Power Kits', 'SOL-003', 'NSN-6115-01-567-8902', '2024-10-15', 'Under Warranty', 'Deployed', '3rd Signal Bn', 'Locker G3', 'LT Garcia', 15],
            ['Fiber Optic Cables (m)', 'FIB-004', 'NSN-6015-01-678-9013', '2024-02-01', 'Under Warranty', 'In-Warehouse', 'HQ Company', 'Locker H1', null, 5000],
            ['Ethernet Switches', 'SWT-005', 'NSN-5895-01-789-0124', '2024-08-20', 'Under Warranty', 'Deployed', '2nd Signal Bn', 'Locker H2', 'CPL Mercado', 40],
        ];
        foreach ($items3 as $item) {
            Item::create([
                'category_id' => $cat3,
                'name' => $item[0], 'serial_number' => $item[1], 'nsn' => $item[2],
                'date_acquired' => $item[3], 'warranty_status' => $item[4],
                'status' => $item[5], 'location_battalion' => $item[6],
                'location_storage' => $item[7], 'assigned_personnel' => $item[8],
                'quantity' => $item[9],
            ]);
        }


    }
}
