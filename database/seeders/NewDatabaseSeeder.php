<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Region;
use App\Models\User;
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

class NewDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data first
        AppLog::truncate();
        Document::truncate();
        BookingLog::truncate();
        BookingApproval::truncate();
        Booking::truncate();
        Driver::truncate();
        Vehicle::truncate();
        VehicleType::truncate();
        User::truncate();
        Region::truncate();
        Role::truncate();
        FuelLog::truncate();
        ServiceLog::truncate();
        Setting::truncate();

        // Roles
        $adminRole = Role::create(['name' => 'admin']);
        $approverRole = Role::create(['name' => 'approver']);
        $userRole = Role::create(['name' => 'user']);

        // Regions
        $regions = [];
        foreach (range(1, 5) as $i) {
            $regions[] = Region::create([
                'name' => 'Region ' . $i,
                'type' => ['pusat', 'cabang', 'tambang'][($i-1)%3],
                'address' => 'Jl. Contoh No.'.$i.', Kota Contoh',
            ]);
        }

        // Users - Create specific authentication users first
        $users = [];
        
        // Admin user
        $users[] = User::create([
            'name' => 'Admin User',
            'email' => 'admin@company.com',
            'password' => Hash::make('Admin123'),
            'role_id' => $adminRole->id,
            'region_id' => $regions[0]->id,
            'is_active' => true,
        ]);

        // Approver users
        $users[] = User::create([
            'name' => 'Approver 1',
            'email' => 'approver1@company.com',
            'password' => Hash::make('Approver123'),
            'role_id' => $approverRole->id,
            'region_id' => $regions[1]->id,
            'is_active' => true,
        ]);

        $users[] = User::create([
            'name' => 'Approver 2',
            'email' => 'approver2@company.com',
            'password' => Hash::make('Approver123'),
            'role_id' => $approverRole->id,
            'region_id' => $regions[2]->id,
            'is_active' => true,
        ]);

        // Regular users
        $users[] = User::create([
            'name' => 'Regular User 1',
            'email' => 'user1@company.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
            'region_id' => $regions[3]->id,
            'is_active' => true,
        ]);

        $users[] = User::create([
            'name' => 'Regular User 2',
            'email' => 'user2@company.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
            'region_id' => $regions[4]->id,
            'is_active' => true,
        ]);

        // Additional users for testing
        foreach (range(3, 8) as $i) {
            $users[] = User::create([
                'name' => 'User '.$i,
                'email' => 'user'.$i.'@company.com',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
                'region_id' => $regions[($i-1)%5]->id,
                'is_active' => true,
            ]);
        }

        // Vehicle Types
        $vehicleTypes = [];
        foreach (['Sedan', 'SUV', 'Truck', 'Pickup', 'Bus', 'Van'] as $typeName) {
            $vehicleTypes[] = VehicleType::create(['name' => $typeName]);
        }

        // Vehicles
        $vehicles = [];
        foreach (range(1, 8) as $i) {
            $vehicles[] = Vehicle::create([
                'name' => 'Vehicle '.$i,
                'plate_number' => 'N '.str_pad($i,4,'0',STR_PAD_LEFT).' AB',
                'type_id' => $vehicleTypes[($i-1)%6]->id,
                'is_rented' => false,
                'fuel_type' => ['Diesel','Bensin','Electric'][($i-1)%3],
                'region_id' => $regions[($i-1)%5]->id,
                'is_available' => true,
            ]);
        }

        // Drivers
        $drivers = [];
        foreach (range(1, 8) as $i) {
            $drivers[] = Driver::create([
                'name' => 'Driver '.$i,
                'license_number' => 'SIM'.str_pad($i,3,'0',STR_PAD_LEFT),
                'phone' => '0812'.str_pad($i,8,'0',STR_PAD_LEFT),
                'region_id' => $regions[($i-1)%5]->id,
                'is_active' => true,
            ]);
        }

        // Bookings
        $bookings = [];
        foreach (range(1, 8) as $i) {
            $date = sprintf('2025-07-%02d', $i);
            $bookingCode = 'BO-' . $date . '-' . str_pad($i, 4, '0', STR_PAD_LEFT);
            $bookings[] = Booking::create([
                'code' => $bookingCode,
                'user_id' => $users[($i+2)%10]->id, // Use regular users for bookings
                'vehicle_id' => $vehicles[($i-1)%8]->id,
                'driver_id' => $drivers[($i-1)%8]->id,
                'start_datetime' => now()->addDays($i),
                'end_datetime' => now()->addDays($i+1),
                'destination' => 'Destination '.$i,
                'reason' => 'Reason for booking '.$i,
                'status' => ['draft','pending','approved','rejected','onuse','finish'][($i-1)%6],
            ]);
        }

        // Booking Approvals - Assign approvers to bookings
        foreach ($bookings as $i => $booking) { 
            // Assign approver 1 (index 1 in users array)
            BookingApproval::create([
                'booking_id' => $booking->id,
                'approver_id' => $users[1]->id, // Approver 1
                'level' => 1,
                'status' => $booking->status == 'approved' ? 'approved' : 'pending',
                'note' => 'Approval level 1 for booking '.$booking->code,
                'approved_at' => $booking->status == 'approved' ? now() : null,
            ]);

            // Assign approver 2 (index 2 in users array)
            BookingApproval::create([
                'booking_id' => $booking->id,
                'approver_id' => $users[2]->id, // Approver 2
                'level' => 2,
                'status' => $booking->status == 'approved' ? 'approved' : 'pending',
                'note' => 'Approval level 2 for booking '.$booking->code,
                'approved_at' => $booking->status == 'approved' ? now() : null,
            ]);
        }

        // Booking Logs
        foreach ($bookings as $i => $booking) {
            foreach (['start','stop','pause'] as $j => $event) {
                BookingLog::create([
                    'booking_id' => $booking->id,
                    'event' => $event,
                    'datetime' => now()->addDays($i)->addHours($j),
                    'odometer' => 10000 + $i*100 + $j*10,
                    'notes' => 'Log '.$event.' for booking '.$booking->id,
                ]);
            }
        }

        // Fuel Logs
        foreach ($bookings as $i => $booking) {
            FuelLog::create([
                'vehicle_id' => $booking->vehicle_id,
                'booking_id' => $booking->id,
                'date' => now()->addDays($i),
                'fuel_amount' => 10 + $i,
                'fuel_cost' => 200000 + $i*10000,
                'km_before' => 10000 + $i*100,
                'km_after' => 10100 + $i*100,
            ]);
        }

        // Service Logs
        foreach ($vehicles as $i => $vehicle) {
            ServiceLog::create([
                'vehicle_id' => $vehicle->id,
                'service_date' => now()->subDays($i),
                'description' => 'Service for vehicle '.$vehicle->name,
                'km' => 9000 + $i*100,
                'cost' => 500000 + $i*5000,
            ]);
        }

        // Documents
        foreach ($bookings as $i => $booking) {
            Document::create([
                'booking_id' => $booking->id,
                'file_path' => 'documents/sample'.($i+1).'.pdf',
            ]);
        }

        // Settings
        Setting::create(['key' => 'company_name', 'value' => 'Vehicle Tracker Company']);
        Setting::create(['key' => 'system_version', 'value' => '1.0.0']);
        Setting::create(['key' => 'max_booking_days', 'value' => '30']);
        Setting::create(['key' => 'approval_required', 'value' => 'true']);

        // App Logs
        foreach (range(1, 10) as $i) {
            AppLog::create([
                'user_id' => $users[($i-1)%10]->id,
                'action' => ['login','logout','create','update','delete'][($i-1)%5],
                'module' => ['user','vehicle','booking','fuel','service'][($i-1)%5],
                'ip_address' => '192.168.1.'.($i),
            ]);
        }

        $this->command->info('NewDatabaseSeeder completed successfully!');
        $this->command->info('Test users created:');
        $this->command->info('- Admin: admin@company.com / Admin123');
        $this->command->info('- Approver 1: approver1@company.com / Approver123');
        $this->command->info('- Approver 2: approver2@company.com / Approver123');
        $this->command->info('- User 1: user1@company.com / password');
        $this->command->info('- User 2: user2@company.com / password');
    }
} 