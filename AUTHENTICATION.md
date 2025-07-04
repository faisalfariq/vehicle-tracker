# Authentication System

## Overview
The Vehicle Tracker application now includes a complete authentication system that protects all routes and provides user-specific functionality.

## Features

### 1. User Authentication
- Login/logout functionality
- Session-based authentication
- Remember me functionality
- Automatic redirection for unauthenticated users

### 2. User Roles
- **Admin**: Full access to all features
- **Approver**: Can approve/reject bookings
- **User**: Regular user with limited access

### 3. Booking Approval System
- Two-level approval system (Approver 1 and Approver 2)
- Only approvers assigned to a booking can approve/reject it
- Approver Level 2 can change booking status to approved
- Approver Level 1 can only approve their level, not the booking status
- Auto-approval of Level 1 when Level 2 approves

## Default Users

After running the seeder, the following users are available:

### Admin User
- Email: `admin@company.com`
- Password: `Admin123`
- Role: Admin

### Approver User
- Email: `approver@company.com`
- Password: `Approver123`
- Role: Approver

### Regular Users
- Email: `user@example.com`
- Password: `password`
- Role: User

- Email: `user2@example.com`
- Password: `password`
- Role: User

## How to Use

### 1. Login
1. Navigate to `/login`
2. Enter your email and password
3. Optionally check "Remember me"
4. Click Login

### 2. Booking Approval Process
1. Login as an approver user
2. Navigate to a booking detail page
3. If you are an approver for that booking, you'll see Approve/Reject buttons
4. Click the appropriate button to approve or reject

### 3. Logout
1. Click on your username in the top-right corner
2. Select "Logout" from the dropdown menu

## Security Features

### 1. Route Protection
- All application routes are protected by authentication middleware
- Unauthenticated users are redirected to login page
- Authenticated users are redirected to dashboard when accessing login page

### 2. Session Management
- Secure session handling
- CSRF protection on all forms
- Session regeneration on login

### 3. Activity Logging
- All login/logout attempts are logged
- All booking approval actions are logged with user information
- Failed login attempts are tracked

## Technical Implementation

### Middleware
- `Authenticate`: Protects routes requiring authentication
- `RedirectIfAuthenticated`: Redirects authenticated users away from guest pages

### Controllers
- `LoginController`: Handles login/logout functionality
- `BookingController`: Updated to use authenticated user for approvals

### Views
- Login form with error handling
- Updated header to show authenticated user
- Booking detail page shows approval buttons only for assigned approvers

## Database Structure

### Users Table
- `id`: Primary key
- `name`: User's full name
- `email`: Unique email address
- `password`: Hashed password
- `role_id`: Foreign key to roles table
- `region_id`: Foreign key to regions table
- `is_active`: Boolean flag for active status

### Roles Table
- `id`: Primary key
- `name`: Role name (admin, approver, user)

### App Logs Table
- Tracks all authentication and approval activities
- Includes user ID, action, module, and IP address

## Configuration

The authentication system uses Laravel's default session-based authentication with the following configuration:

- **Guard**: `web` (session-based)
- **Provider**: `users` (Eloquent)
- **Password Broker**: `users`

## Troubleshooting

### Common Issues

1. **"Email atau password salah"**
   - Verify you're using the correct email and password
   - Check that the user exists and is active

2. **"Anda tidak memiliki izin untuk menyetujui booking ini"**
   - Only users assigned as approvers for a specific booking can approve/reject it
   - Check the booking approval assignments

3. **Session timeout**
   - Sessions expire after a period of inactivity
   - Simply log in again

### Development Notes

- All passwords in the seeder are hashed using `Hash::make()`
- The system uses Laravel's built-in authentication features
- Session configuration can be modified in `config/session.php`
- Authentication configuration is in `config/auth.php` 