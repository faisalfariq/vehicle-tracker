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
        // Roles
        $roles = [];
        foreach (['admin', 'approver', 'user', 'manager', 'staff', 'operator', 'supervisor', 'guest', 'auditor', 'support'] as $roleName) {
            $roles[] = Role::create(['name' => $roleName]);
        }

        // Regions
        $regions = [];
        foreach (range(1, 10) as $i) {
            $regions[] = Region::create([
                'name' => 'Region ' . $i,
                'type' => ['pusat', 'cabang', 'tambang'][($i-1)%3],
                'address' => 'Jl. Contoh No.'.$i.', Kota Contoh',
            ]);
        }

        // Users
        $users = [];
        foreach (range(1, 10) as $i) {
            $users[] = User::create([
                'name' => 'User '.$i,
                'email' => 'user'.$i.'@example.com',
                'password' => Hash::make('Password'.$i.'!'),
                'role_id' => $roles[($i-1)%10]->id,
                'region_id' => $regions[($i-1)%10]->id,
                'is_active' => true,
            ]);
        }

        // Vehicle Types
        $vehicleTypes = [];
        foreach (['Sedan', 'SUV', 'Truck', 'Pickup', 'Bus', 'Van', 'Minibus', 'Motorcycle', 'Electric', 'Hybrid'] as $typeName) {
            $vehicleTypes[] = VehicleType::create(['name' => $typeName]);
        }

        // Vehicles
        $vehicles = [];
        foreach (range(1, 10) as $i) {
            $vehicles[] = Vehicle::create([
                'name' => 'Vehicle '.$i,
                'plate_number' => 'N '.str_pad($i,4,'0',STR_PAD_LEFT).' AB',
                'type_id' => $vehicleTypes[($i-1)%10]->id,
                'is_rented' => false,
                'fuel_type' => ['Diesel','Bensin','Electric'][($i-1)%3],
                'region_id' => $regions[($i-1)%10]->id,
                'is_available' => true,
            ]);
        }

        // Drivers
        $drivers = [];
        foreach (range(1, 10) as $i) {
            $drivers[] = Driver::create([
                'name' => 'Driver '.$i,
                'license_number' => 'SIM'.str_pad($i,3,'0',STR_PAD_LEFT),
                'phone' => '0812'.str_pad($i,8,'0',STR_PAD_LEFT),
                'region_id' => $regions[($i-1)%10]->id,
                'is_active' => true,
            ]);
        }

        // Bookings
        $bookings = [];
        foreach (range(1, 10) as $i) {
            $date = sprintf('2025-07-%02d', $i); // 2025-07-01, 2025-07-02, ...
            $bookingCode = 'BO-' . $date . '-' . str_pad($i, 4, '0', STR_PAD_LEFT); // max 18 char
            $bookings[] = Booking::create([
                'code' => $bookingCode,
                'user_id' => $users[($i-1)%10]->id,
                'vehicle_id' => $vehicles[($i-1)%10]->id,
                'driver_id' => $drivers[($i-1)%10]->id,
                'start_datetime' => now()->addDays($i),
                'end_datetime' => now()->addDays($i+1),
                'destination' => 'Destination '.$i,
                'reason' => 'Reason for booking '.$i,
                'status' => ['pending','approved','rejected','ongoing','completed'][($i-1)%5],
            ]);
        }

        // Booking Approvals
        foreach ($bookings as $i => $booking) {
            foreach ([1,2] as $level) {
                BookingApproval::create([
                    'booking_id' => $booking->id,
                    'approver_id' => $users[($i+$level)%10]->id,
                    'level' => $level,
                    'status' => ['pending','approved','rejected'][($level-1)%3],
                    'note' => 'Approval note '.$level.' for booking '.$booking->id,
                    'approved_at' => now()->addHours($level),
                ]);
            }
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
        foreach (range(1, 10) as $i) {
            Setting::create([
                'key' => 'setting_key_'.$i,
                'value' => 'Setting value '.$i,
            ]);
        }

        // App Logs
        foreach (range(1, 10) as $i) {
            AppLog::create([
                'user_id' => $users[($i-1)%10]->id,
                'action' => ['login','logout','create','update','delete'][($i-1)%5],
                'module' => ['user','vehicle','booking','fuel','service'][($i-1)%5],
                'ip_address' => '192.168.1.'.($i),
            ]);
        }
    }
} 