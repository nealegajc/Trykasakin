# TrycKaSaken - Tricycle Booking Platform

A modern web-based platform for tricycle booking and ride-sharing services, connecting passengers with tricycle drivers in real-time.

## Overview

**TrycKaSaken** is a comprehensive booking system designed to facilitate tricycle transportation services. The platform allows passengers to book rides and drivers to accept and manage bookings efficiently.

## Features

- **User Authentication**: Secure login and registration for passengers and drivers
- **Driver Verification**: Admin verification system for driver documents
- **Real-time Bookings**: Instant booking creation and status updates
- **Admin Dashboard**: Comprehensive user management interface
- **Document Management**: Secure upload and storage of driver credentials
- **Booking Status Tracking**: Track rides from pending to completed
- **Responsive Design**: Mobile-friendly Bootstrap 5 interface
- **Modern UI/UX**: Bootstrap Icons integration throughout the application

## Technology Stack

- **Frontend**: HTML5, CSS3, Bootstrap 5.3.2, JavaScript
- **Icons**: Bootstrap Icons 1.11.1
- **Backend**: PHP 7.4+
- **Database**: MySQL (MariaDB)
- **Server**: Apache (XAMPP)

## Project Structure

```
Trykasakin/
├── config/                          # Configuration files
│   └── dbConnection.php            # Database connection class with PDO/MySQLi wrapper
├── includes/                        # Reusable PHP components
│   └── get_available_drivers.php   # Fetches count of available/active drivers
├── assets/
│   ├── css/                        # Custom stylesheets
│   │   ├── admin.css              # Admin dashboard styling with stats cards
│   │   ├── book.css               # Booking form and status table styles
│   │   ├── dashboard.css          # Driver/Passenger dashboard with navbar and cards
│   │   ├── index.css              # Landing page hero section and features grid
│   │   ├── login.css              # Login form with gradient background
│   │   ├── register.css           # Registration form with driver document uploads
│   │   └── request.css            # Driver request cards and action buttons
│   └── uploads/                    # Driver document uploads (auto-created)
│       ├── or_cr/                 # Official Receipt/Certificate of Registration docs
│       ├── licenses/              # Driver's license images/PDFs
│       └── pictures/              # Driver profile pictures
├── db files/
│   └── tric_db.sql                # MySQL database schema with tables and sample data
├── docs/                           # Documentation files (if any)
├── admin.php                       # Admin dashboard - manage users, view statistics
├── book.php                        # Passenger booking form - create/view ride requests
├── index.php                       # Landing page with features, CTA buttons, driver count
├── login.php                       # Universal login page with role-based redirection
├── loginDriver.php                 # Driver dashboard - view requests, go online
├── loginUser.php                   # Passenger dashboard - book rides, track status
├── logout.php                      # Session termination and redirect to login
├── register.php                    # User registration - passenger or driver with docs
├── request.php                     # Driver request management - accept/complete rides
└── README.md                       # Project documentation (this file)
```

### File Descriptions

#### **Core Pages**

- **`index.php`**: Landing page showcasing platform features, available drivers badge, and call-to-action buttons for registration/login. Displays hero section with emoji icons and feature cards.

- **`login.php`**: Universal authentication page for both passengers and drivers. Validates credentials, checks account status, and redirects users to appropriate dashboards based on their role.

- **`register.php`**: User registration with dual-mode interface - simple form for passengers, extended form for drivers requiring document uploads (OR/CR, license, photo). Includes password confirmation and email validation.

- **`logout.php`**: Handles session destruction and redirects users back to login page. Ensures secure logout process.

#### **User Dashboards**

- **`loginDriver.php`**: Driver dashboard displaying welcome message and service cards. Shows "View Requests" and "Accept Rides" options. Features horizontal navbar with navigation links.

- **`loginUser.php`**: Passenger dashboard with "Book a Ride" and "Track Your Ride" service cards. Clean interface for quick access to booking functionality.

- **`admin.php`**: Administrative control panel showing user statistics (total passengers, drivers, users), displaying tables of all registered users with action buttons (View, Edit, Delete).

#### **Functional Pages**

- **`book.php`**: Booking interface where passengers input their name, pickup location, and destination. Displays latest booking status in a table. Hides form when active booking exists.

- **`request.php`**: Driver-side request management system. Shows pending ride requests and accepted rides. Includes "Accept Ride" and "Complete Ride" action buttons with confirmation dialogs.

#### **Configuration & Includes**

- **`config/dbConnection.php`**: Database connection class handling MySQL connections with error handling, connection management, and query execution methods.

- **`includes/get_available_drivers.php`**: PHP script that queries the database to count active drivers with verified status for display on the landing page.

#### **Stylesheets**

- **`assets/css/admin.css`**: Styles for admin dashboard including stat cards with emoji icons, responsive tables, and Bootstrap card layouts.

- **`assets/css/book.css`**: Booking page styles featuring form sections, status badges (Pending, Accepted, Completed), table styling, and empty state designs.

- **`assets/css/dashboard.css`**: Shared dashboard styles for both driver and passenger dashboards. Includes horizontal navbar, service cards, gradient backgrounds, and responsive breakpoints.

- **`assets/css/index.css`**: Landing page styles with hero section, features grid, gradient backgrounds, call-to-action buttons, and driver availability badge.

- **`assets/css/login.css`**: Login page styles featuring centered form, gradient background, password toggle button, and alert message styling.

- **`assets/css/register.css`**: Registration form styles with user type selector (passenger/driver toggle), file upload sections, conditional driver fields, and form validation styling.

- **`assets/css/request.css`**: Request management page styles including ride request cards, status badges with emoji icons, action buttons (Accept/Complete), and empty state displays.

#### **Database**

- **`db files/tric_db.sql`**: MySQL database schema containing table definitions for users, drivers, and tricycle_bookings. Includes relationships, constraints, and initial configuration.

#### **Assets**

- **`assets/uploads/`**: Directory for storing uploaded driver documents with organized subdirectories:
  - `or_cr/`: Vehicle registration documents
  - `licenses/`: Driver's license scans
  - `pictures/`: Driver profile photos

## Installation

### Prerequisites

- XAMPP (Apache + MySQL + PHP)
- Web Browser (Chrome, Firefox, or Edge)
- Text Editor (VS Code, Sublime Text, etc.)

### Setup Steps

1. **Install XAMPP**
   - Download from [apachefriends.org](https://www.apachefriends.org/)
   - Install and run XAMPP Control Panel

2. **Copy Project Files**
   ```
   Copy the Trykasakin folder to: C:\xampp\htdocs\Trykasakin
   ```

3. **Start Services**
   - Open XAMPP Control Panel
   - Start Apache and MySQL modules

4. **Create Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create new database: `tric_db`
   - Import SQL file: `db files/tric_db.sql`

5. **Configure Database Connection** (if needed)
   - Edit `config/dbConnection.php`
   - Update credentials (default: root with no password)

6. **Set Permissions**
   - Ensure `assets/uploads/` folder has write permissions

7. **Access Application**
   - Landing page: `http://localhost/Trykasakin/`
   - Login: `http://localhost/Trykasakin/login.php`
   - Register: `http://localhost/Trykasakin/register.php`
   - Admin: `http://localhost/Trykasakin/admin.php`

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

### For Passengers:
1. Register as a Passenger
2. Login to the system
3. Book a tricycle (provide pickup location and destination)
4. Wait for driver to accept
5. Track booking status (Pending → Accepted → Completed)

### For Drivers:
1. Register as a Driver
2. Upload required documents (OR/CR, License, Photo)
3. Wait for admin verification
4. Login after approval
5. View and accept booking requests
6. Complete rides and update status

### For Administrators:
1. Login with admin credentials
2. Review driver verification requests
3. Manage user accounts
4. Monitor booking statistics
5. Handle system configurations

## Security Features

- Password hashing using PHP `password_hash()` with bcrypt
- SQL injection prevention via prepared statements
- Session management and authentication
- XSS prevention using `htmlspecialchars()`
- Input validation (server-side and client-side)
- Secure file upload with type validation
- CSRF protection ready

## Database Schema

### Main Tables

**users**
- user_id (Primary Key)
- name
- email
- phone
- password (hashed)
- user_type (passenger/driver/admin)
- status (active/inactive)
- created_at

**drivers**
- driver_id (Primary Key)
- user_id (Foreign Key → users)
- or_cr_path
- license_path
- picture_path
- verification_status
- created_at

**tricycle_bookings**
- booking_id (Primary Key)
- name
- location
- destination
- status (pending/accepted/completed)
- driver_id (Foreign Key → drivers)
- booking_time

## Design Features

### Color Scheme
- Primary: #37517e (Blue-purple)
- Secondary: #4a6396
- Tertiary: #5d75ae
- Background: #e8edf5 to #d4dde9 gradient
- Success: #2E7D32
- Danger: #D32F2F
- Warning: #F57C00

### Bootstrap Integration
- Bootstrap 5.3.2 for responsive layout
- Bootstrap Icons 1.11.1 for modern iconography
- Custom CSS for brand-specific styling
- Mobile-first responsive design
- Smooth animations and transitions

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Future Enhancements

- Real-time GPS tracking integration
- Push notifications for booking updates
- Payment gateway integration
- Rating and review system
- Mobile application (Android/iOS)
- Multi-language support
- Ride history and analytics dashboard
- Driver earnings tracking
- Advanced search and filtering
- Export reports functionality

## Troubleshooting

**Database Connection Issues:**
- Verify MySQL is running in XAMPP
- Check database credentials in `config/dbConnection.php`
- Ensure database `tric_db` exists and is imported

**File Upload Issues:**
- Check folder permissions for `assets/uploads/`
- Verify folder structure exists (or_cr, licenses, pictures)
- Ensure PHP upload settings allow file uploads

**Session Issues:**
- Clear browser cookies/cache
- Check PHP session configuration
- Verify session directory permissions

**Bootstrap Not Loading:**
- Check internet connection (CDN-based)
- Verify CDN URLs are accessible
- Clear browser cache

## Development Notes

### Recent Updates
- Integrated Bootstrap 5.3.2 across all pages
- Added Bootstrap Icons for better UX
- Implemented password visibility toggle
- Enhanced alert messages with dismissible functionality
- Improved mobile responsiveness
- Updated color scheme to blue-purple (#37517e)
- Removed unnecessary features for cleaner interface

### File Organization
- Configuration files in `config/`
- CSS files organized in `assets/css/`
- Upload directory: `assets/uploads/`
- Consistent naming conventions
- Modular code structure
