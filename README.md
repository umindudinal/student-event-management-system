# Student Event Management System
A web‑based application for managing student events, registrations, and participant data.

## Table of Contents
- [About](#about)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Setup & Installation](#setup--installation)
- [Folder Structure](#folder-structure)
- [Usage](#usage)
- [Implementation Details](#implementation-details)
- [Future Enhancements](#future-enhancements)
- [License](#license)

## About
The Student Event Management System is designed to enable event administrators (e.g., at a university) to
- create and publish events,
- allow students to view events and register,
- manage participants and event details.
It consolidates event management processes into a single web application, thereby reducing manual work, improving accessibility, and keeping data consistent.

## Features
- **Event listing**: Display upcoming events with title, date/time, location, and description.
- **Student registration**: Students can register for events, and their information is stored in the system.
- **Administration dashboard**: Admins can log in, create/edit/delete events, and view registered participants.
- **File uploads**: Ability to upload event‑related images/files.
- **Responsive UI**: Works on desktop and mobile.
- **Basic contact & info pages**: e.g., About, Contact.
- **Data persistence**: Stores event and participant data in a back‑end database (via PHP & MySQL).
- **Separation of concerns**: Front‑end files (CSS/JS) and back‑end logic (PHP) organized into folders.

## Technology Stack
- **Backend**: PHP (server‑side scripting)
- **Frontend**: HTML5, CSS, JavaScript
- **Database**: MySQL (or compatible)
- **Server Requirements**:
  - PHP version 7.x (or higher)
  - MySQL or MariaDB
  - A web‑server supporting PHP (e.g., Apache or Nginx)

## Setup & Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/umindudinal/student-event-management-system.git
   ```
2. Create a MySQL database, e.g., `event_db`.
3. Import the SQL schema if provided (look for a `.sql` file in the root or `API/` folder).
4. Adjust database credentials in the configuration file (e.g., `config.php`, or in `API/connection.php`).
5. Upload the project to your web‑server's document root (e.g., `htdocs/` or `www/`).
6. Ensure folder permissions: `uploads/` may need write permission for file uploads.
7. Visit `http://localhost/index.php` in your browser and test the application.

## Folder Structure
```
/student-event-management-system
  /API
     – PHP endpoints and database connection
  /CSS
     – stylesheets
  /Dashboard
     – admin interface files
  /Images
     – event images & static graphics
  /JS
     – JavaScript scripts
  /uploads
     – uploaded event/participant files
  about.php
  contact.php
  event.php
  index.php
  README.md
```

## Usage
- **For Students / Participants:**
  - Navigate to the home page (`index.php`) to browse events.
  - Click an event to view details.
  - Register by filling in your information and submitting.

- **For Administrators:**
  - Log in via the admin dashboard (`Dashboard/` folder).
  - Use the dashboard to create a new event (title, description, date, location, image).
  - Upload supporting files or images.
  - View lists of registered participants and export if needed.
  - Manage (edit/delete) past events, and update their status.

## Implementation Details
- **Event CRUD operations** (Create, Read, Update, Delete) use PHP scripts in the `API/` folder.
- **Database tables** typically include: `events`, `participants`, and `admins`.
- **Uploads**: Images/files uploaded by admins are saved in the `uploads/` folder; the file path is stored in the database.
- **Frontend‑back end interaction**: On the event page (`event.php`), the event ID is passed (via GET parameter) to fetch details.
- **Security Note**: Basic input validation is included; however, for production use, more robust measures (prepared statements, CSRF protection, sanitization) should be added.

## Future Enhancements
- Add **user authentication** for students (login/logout), so participants can view their registrations and history.
- Include **role‑based access control** (student vs organizer vs admin).
- Add **email notifications** (registration confirmation, event reminders).
- Implement a **dashboard analytics view**: number of registrations per event, popular events.
- Add **payment integration** for paid events.
- Support **mobile app or PWA** mode for easier access by students.
- Improve UI/UX with modern frameworks (React, Vue) and responsive design frameworks (Bootstrap or Tailwind CSS).

## License
This project is open‑source under the [MIT License](LICENSE).  
Feel free to fork, modify, and use the system for educational or organizational purposes.

---
**Author:** Umindu Dinal  
**GitHub:** [umindudinal](https://github.com/umindudinal)
