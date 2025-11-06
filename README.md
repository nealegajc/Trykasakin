# TrycKaSaken - Tricycle Booking Platform

A secure and user-friendly tricycle booking system built with PHP, MySQL, and Bootstrap 5.

4. **Access Application**
   - Open browser and visit: `http://localhost/Trykasakin/`
   - Database will be created automatically on first visit
   - Register as a new user or login with demo accounts

### Demo Accounts

After automatic setup, you can login with:
- **Passenger**: `passenger@demo.com` / `password123`
- **Driver**: `driver@demo.com` / `password123`

## Features

- **Secure Authentication** - User login with session management
- **Dual User Types** - Separate portals for Passengers and Drivers
- **Booking System** - Users can only view their own bookings
- **Dashboard Analytics** - Real-time booking statistics
- **Driver Management** - Document verification system
- **Responsive Design** - Works on all devices
- **Data Isolation** - Each user sees only their own data
- **Automatic Setup** - No manual database configuration needed

## Project Structure

```
Trykasakin/
├── index.php                        # Landing page with auto-setup
├── config/                          # Configuration files
│   └── dbConnection.php            # Database connection class
├── database/                        # Database files
│   └── schema.php                  # Pure PHP schema definition
├── pages/                           # Application pages
│   ├── auth/                       # Authentication
│   │   ├── login.php              # User login
│   │   ├── register.php           # User registration
│   │   └── logout.php             # Logout handler
│   ├── passenger/                  # Passenger pages
│   │   ├── loginUser.php          # Passenger dashboard
│   │   ├── book.php               # Create new booking
│   │   └── trip_history.php       # View booking history
│   ├── driver/                     # Driver pages
│   │   ├── loginDriver.php        # Driver dashboard
│   │   └── request.php            # View/manage ride requests
│   └── admin/                      # Admin pages
│       └── admin.php              # Admin dashboard
└── public/                          # Public assets
    ├── css/                        # Stylesheets
    └── uploads/                    # User uploaded files
```

## Configuration

Database settings are in `config/dbConnection.php`:

```php
private $host = "localhost";
private $db_name = "tric_db";
private $username = "root";
private $password = "";
```

Default settings work with standard XAMPP installation.

## User Roles

### Passengers
- Book tricycle rides
- View booking history
- Track ride status
- Dashboard with statistics

### Drivers
- Accept ride requests
- Upload verification documents
- Manage ride assignments

### Admin
- Verify driver documents
- Manage users and bookings
- System oversight

### File Upload Issues
- Ensure `public\uploads\` folder exists
- Check folder permissions (should be writable)
- Verify PHP upload settings in `php.ini`

## Documentation

Additional documentation available in:
- `database/SCHEMA_INFO.md` - Schema-as-code pattern explanation

- **User Authentication**: Secure login and registration for passengers and drivers
- **Driver Verification**: Admin verification system for driver documents
- **Real-time Bookings**: Instant booking creation and status updates
- **Admin Dashboard**: Comprehensive user management interface
- **Document Management**: Secure upload and storage of driver credentials
- **Booking Status Tracking**: Track rides from pending to completed
- **Responsive Design**: Mobile-friendly Bootstrap 5 interface
- **Modern UI/UX**: Bootstrap Icons integration throughout the application

## File Descriptions

### Core Pages
- **index.php**: Landing page with automatic database setup on first visit
- **pages/auth/login.php**: Universal authentication with role-based routing
- **pages/auth/register.php**: User registration for passengers and drivers
- **pages/auth/logout.php**: Session termination handler

### Dashboards
- **pages/passenger/loginUser.php**: Passenger dashboard with statistics
- **pages/driver/loginDriver.php**: Driver dashboard with trip management
- **pages/admin/admin.php**: Administrative control panel

### Functional Pages
- **pages/passenger/book.php**: Create new ride bookings
- **pages/passenger/trip_history.php**: View booking history
- **pages/driver/request.php**: Manage ride requests and active trips

### Configuration & Database
- **config/dbConnection.php**: Database connection handler
- **database/schema.php**: Pure PHP schema definition (no .sql files)

## User Roles

### Passenger
- Create and manage bookings
- View booking status
- Track ride progress in real-time
- Update profile information

### Driver
- View and accept booking requests
- Upload required documents (OR/CR, License, Photo)
- Update booking status to completed
- Requires admin verification before accepting rides
- Manage accepted rides

### Administrator
- Manage all users (passengers and drivers)
- Verify driver documents
- View all bookings and statistics
- Activate/Deactivate user accounts
- System monitoring and analytics

## Workflow

### For Passengers
1. Register as a Passenger
2. Login to the system
3. Book a tricycle (provide pickup location and destination)
4. Wait for driver to accept
5. Track booking status (Pending to Accepted to Completed)

### For Drivers
1. Register as a Driver
2. Upload required documents (OR/CR, License, Photo)
3. Wait for admin verification
4. Login after approval
5. View and accept booking requests
6. Complete rides and update status

### For Administrators
1. Login with admin credentials
2. Review driver verification requests
3. Manage user accounts
4. Monitor booking statistics
5. Handle system configurations

## Advanced Security

- Password hashing using bcrypt algorithm
- SQL injection prevention via prepared statements
- Session management and authentication
- XSS prevention using htmlspecialchars
- Input validation (server-side and client-side)
- Secure file upload with type validation
- User-specific data isolation
- Foreign key constraints for data integrity

## Database Schema

### Main Tables

**users**
- user_id (Primary Key)
- name, email, phone
- password (bcrypt hashed)
- user_type (passenger/driver)
- status (active/inactive/suspended)
- created_at

**drivers**
- driver_id (Primary Key)
- user_id (Foreign Key to users)
- or_cr_path, license_path, picture_path
- verification_status (pending/verified/rejected)
- created_at

**tricycle_bookings**
- id (Primary Key)
- user_id (Foreign Key to users)
- name, location, destination
- status (pending/accepted/completed)
- driver_id (Foreign Key to drivers)
- booking_time
