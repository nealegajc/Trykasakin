# 🚕 TrycKaSaken - Tricycle Booking Platform

A web-based platform for tricycle booking and ride-sharing services, connecting passengers with tricycle drivers in real-time.

## 📋 Overview

**TrycKaSaken** is a comprehensive booking system designed to facilitate tricycle transportation services. The platform allows passengers to book rides and drivers to accept and manage bookings efficiently.

## ✨ Features

- **User Authentication**: Secure login and registration for passengers and drivers
- **Driver Verification**: Admin verification system for driver documents
- **Real-time Bookings**: Instant booking creation and status updates
- **Admin Dashboard**: Comprehensive user management interface
- **Document Management**: Secure upload and storage of driver credentials
- **Booking Status Tracking**: Track rides from pending to completed
- **Responsive Design**: Mobile-friendly Bootstrap interface

## 🛠️ Technology Stack

- **Frontend**: HTML5, CSS3, Bootstrap 5.3.3, JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL (MariaDB)
- **Server**: Apache (XAMPP)

## 📁 Project Structure

```
Trykasakin/
├── config/                      # Configuration files
│   └── dbConnection.php        # Database connection class
├── includes/                    # Reusable PHP components
├── assets/
│   ├── css/                    # Stylesheets
│   │   ├── login.css
│   │   └── register.css
│   └── uploads/                # Driver document uploads
│       ├── or_cr/              # OR/CR documents
│       ├── licenses/           # Driver licenses
│       └── pictures/           # Driver photos
├── docs/
│   └── documentation.pdf       # PDF documentation
├── db files/
│   └── tric_db.sql            # Database schema
├── admin.php                   # Admin dashboard
├── book.php                    # Booking interface
├── login.php                   # User/Driver login
├── loginDriver.php             # Driver dashboard
├── loginUser.php               # Passenger dashboard
├── register.php                # Registration form
├── request.php                 # Booking request handler
├── logout.php                  # Session logout
├── documentation.php           # Web documentation
└── README.md                   # This file
```

## ⚙️ Installation

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
   - Main page: `http://localhost/Trykasakin/login.php`
   - Register: `http://localhost/Trykasakin/register.php`
   - Documentation: `http://localhost/Trykasakin/documentation.php`

## 👥 User Roles

### Passenger
- Create and manage bookings
- View booking status
- Update profile information

### Driver
- View and accept booking requests
- Upload required documents (OR/CR, License, Photo)
- Update booking status to completed
- Requires admin verification before accepting rides

### Administrator
- Manage all users (passengers and drivers)
- Verify driver documents
- View all bookings
- Activate/Deactivate user accounts

## 🔄 Workflow

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

## 🔒 Security Features

- Password hashing using PHP `password_hash()` with bcrypt
- SQL injection prevention via prepared statements
- Session management and authentication
- XSS prevention using `htmlspecialchars()`
- Input validation (server-side and client-side)
- Secure file upload with type validation

## 📊 Database Schema

### Main Tables

**users**
- user_id (Primary Key)
- name
- email
- phone
- password (hashed)
- user_type (passenger/driver)
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

## 🚀 Future Enhancements

- [ ] Real-time GPS tracking integration
- [ ] Push notifications for booking updates
- [ ] Payment gateway integration
- [ ] Rating and review system
- [ ] Mobile application (Android/iOS)
- [ ] Multi-language support
- [ ] Ride history and analytics dashboard
- [ ] Driver earnings tracking

## 📝 Development Notes

### File Organization (Updated Structure)
- Configuration files moved to `config/`
- CSS files organized in `assets/css/`
- Upload directory: `assets/uploads/`
- Documentation moved to `docs/`

### Key Changes
- Centralized database connection in `config/dbConnection.php`
- Updated all file references to use new structure
- Created web-accessible documentation page

## 🐛 Troubleshooting

**Database Connection Issues:**
- Verify MySQL is running in XAMPP
- Check database credentials in `config/dbConnection.php`
- Ensure database `tric_db` exists and is imported

**File Upload Issues:**
- Check folder permissions for `assets/uploads/`
- Verify folder structure exists (or_cr, licenses, pictures)

**Session Issues:**
- Clear browser cookies/cache
- Check PHP session configuration

## 📄 License

This project is developed for educational and community transportation purposes.

## 👨‍💻 Support

For issues or questions, refer to:
- Web Documentation: `http://localhost/Trykasakin/documentation.php`
- PDF Documentation: `docs/documentation.pdf`

---

**© 2025 TrycKaSaken - Tricycle Booking Platform**
