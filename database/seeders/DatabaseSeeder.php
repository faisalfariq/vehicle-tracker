<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Region;
use App\Models\VehicleType;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Booking;
use App\Models\BookingApproval;
use App\Models\BookingLog;
use App\Models\FuelLog;
use App\Models\ServiceLog;
use App\Models\Document;
use App\Models\Setting;
use App\Models\AppLog;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Role
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleApprover = Role::create(['name' => 'approver']);
        $roleUser = Role::create(['name' => 'user']);

        // Region
        $region_pusat = Region::create([
            'name' => 'Kantor Pusat',
            'type' => 'pusat',
            'address' => 'Jl. Raya No.1 Pusat, Malang'
        ]);
        $region_cabang = Region::create([
            'name' => 'Kantor Cabang',
            'type' => 'cabang',
            'address' => 'Jl. Raya No.1 Cabang, Malang'
        ]);
        $region_tambang = Region::create([
            'name' => 'Tambang 1',
            'type' => 'pusat',
            'address' => 'Jl. Raya No.1 Tambang 1, Malang'
        ]);

        // User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@company.com',
            'password' => Hash::make('Admin123'),
            'role_id' => $roleAdmin->id,
            'region_id' => $region_pusat->id,
            'is_active' => true,
        ]);
        $approver = User::create([
            'name' => 'Approver',
            'email' => 'approver@company.com',
            'password' => Hash::make('Approver123'),
            'role_id' => $roleApprover->id,
            'region_id' => $region_cabang->id,
            'is_active' => true,
        ]);
        $user1 = User::create([
            'name' => 'Regular User 1',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role_id' => $roleUser->id,
            'region_id' => $region_tambang->id,
            'is_active' => true,
        ]);
        $user2 = User::create([
            'name' => 'Regular User 2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            'role_id' => $roleUser->id,
            'region_id' => $region_tambang->id,
            'is_active' => true,
        ]);

        // Vehicle Type
        $type_pessenger = VehicleType::create(['name' => 'Pessenger']);
        $type_goods = VehicleType::create(['name' => 'Goods']);

        // Vehicle
        $vehicle1 = Vehicle::create([
            'name' => 'Toyota Fortuner',
            'plate_number' => 'N 1111 AB',
            'type_id' => $type_pessenger->id,
            'is_rented' => false,
            'fuel_type' => 'Diesel',
            'region_id' => $region_tambang->id,
            'is_available' => true,
        ]);
        $vehicle2 = Vehicle::create([
            'name' => 'Pajero',
            'plate_number' => 'N 2222 AB',
            'type_id' => $type_pessenger->id,
            'is_rented' => false,
            'fuel_type' => 'Diesel',
            'region_id' => $region_tambang->id,
            'is_available' => true,
        ]);
        $vehicle3 = Vehicle::create([
            'name' => 'Truck',
            'plate_number' => 'N 3333 AB',
            'type_id' => $type_goods->id,
            'is_rented' => false,
            'fuel_type' => 'Diesel',
            'region_id' => $region_tambang->id,
            'is_available' => true,
        ]);
        
        $vehicle4 = Vehicle::create([
            'name' => 'Pickup',
            'plate_number' => 'N 4444 AB',
            'type_id' => $type_goods->id,
            'is_rented' => false,
            'fuel_type' => 'Diesel',
            'region_id' => $region_tambang->id,
            'is_available' => true,
        ]);

        // Driver
        $driver1 = Driver::create([
            'name' => 'Driver1',
            'license_number' => 'SIM111',
            'phone' => '082111111111',
            'region_id' => $region_tambang->id,
            'is_active' => true,
        ]);
        $driver2 = Driver::create([
            'name' => 'Driver2',
            'license_number' => 'SIM222',
            'phone' => '082111111112',
            'region_id' => $region_tambang->id,
            'is_active' => true,
        ]);
        $driver3 = Driver::create([
            'name' => 'Driver3',
            'license_number' => 'SIM333',
            'phone' => '082111111113',
            'region_id' => $region_tambang->id,
            'is_active' => true,
        ]);
        $driver4 = Driver::create([
            'name' => 'Driver4',
            'license_number' => 'SIM444',
            'phone' => '082111111114',
            'region_id' => $region_tambang->id,
            'is_active' => true,
        ]);

        // Booking
        $booking = Booking::create([
            'code' => 'BO-2025-07-03-0001',
            'user_id' => $user2->id,
            'vehicle_id' => $vehicle1->id,
            'driver_id' => $driver4->id,
            'start_datetime' => now()->addDay(),
            'end_datetime' => now()->addDays(2),
            'destination' => 'Bandung',
            'reason' => 'Dinas Luar Kota',
            'status' => 'pending',
        ]);

        // Booking Approval
        BookingApproval::create([
            'booking_id' => $booking->id,
            'approver_id' => $approver->id,
            'level' => 1,
            'status' => 'pending',
        ]);

        // Booking Log
        BookingLog::create([
            'booking_id' => $booking->id,
            'event' => 'start',
            'datetime' => now(),
            'odometer' => 10000,
            'notes' => 'Mulai perjalanan',
        ]);

        // Fuel Log
        FuelLog::create([
            'vehicle_id' => $vehicle1->id,
            'booking_id' => $booking->id,
            'date' => now(),
            'fuel_amount' => 20,
            'fuel_cost' => 300000,
            'km_before' => 10000,
            'km_after' => 10200,
        ]);

        // Service Log
        ServiceLog::create([
            'vehicle_id' => $vehicle1->id,
            'service_date' => now()->subMonth(),
            'description' => 'Service rutin',
            'km' => 9500,
            'cost' => 500000,
        ]);

        // Document
        Document::create([
            'booking_id' => $booking->id,
            'file_path' => 'documents/sample.pdf',
        ]);

    }
}