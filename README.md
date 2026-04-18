# 🎮 GameHub – Premium Video Game E-commerce Platform

## 📖 Project Overview

**GameHub** is a high-performance web application developed with **Symfony**, designed for gamers to discover, manage, and purchase digital titles. Originally inspired by an image gallery architecture, this project has evolved into a robust E-commerce ecosystem with automated **email notifications**, advanced **filtering systems**, and a professional **back-office**.

The platform provides a seamless experience for both buyers and administrators, ensuring security and data integrity at every step.

---

## 🧩 Project Structure

The application is architecturally divided into two specialized environments:

### 🔓 Front-office (Public Storefront)
Accessible to everyone. It functions as the main marketplace where users can browse the catalog and view game details.

### 🔐 Back-office (Private Dashboard)
Accessible only to authenticated users, with specific features and permissions based on the user's role.

---

## 👥 User Roles

### 👤 Guest User (Anonymous)
- Access to the Home Page and game catalog.
- User registration with **numeric CAPTCHA**.
- Secure Login system.

### 👤 Gamer (Standard User)
- Access to the Back-office.
- **My Collection:** View and manage purchased games or interactions.
- **Game Management:** Create, edit, and delete **their own** game listings.
- **Profile Management:** Update security credentials and personal avatar.
- **Automated Notifications:** Receive email confirmations after purchases.

### 🛡️ Administrator
- All standard user capabilities.
- **Global Management:** Full CRUD access to all games on the platform.
- **User Administration:**
  - Change user roles (Promote/Demote).
  - Delete users (restricted if they have linked operational data).

---

## 🧭 Dynamic Navigation

The menu adapts in real-time to the user's session state:

### Before Login
- Home
- Login
- Register

### Registered User
- Home
- My Games (Inventory)
- My Purchases
- My Profile
- Logout (displays username)

### Administrator
- All User options
- User Management Dashboard

---

## 🌐 Front-office Features

### 🔑 Authentication
- Email and password-based login.
- Automatic redirection to the Back-office upon success.
- Protection against re-accessing login/register pages while authenticated.

### 📝 Registration
- Secure sign-up for new gamers.
- Fields: Username, Email, Password (with verification), and **Numeric CAPTCHA**.
- Automatic login after successful registration.

### 🏠 Marketplace (Home)
- Catalog of games sorted by release date.
- **Game Cards:** - Visual cover (or default placeholder).
  - Title, Date, and Developer (Creator).
  - "View Details" CTA.
- **Advanced Filters:**
  - By Category/Genre.
  - Date range filtering.
  - Full-text search (Title and Description).

### 📄 Product Details
- High-resolution game cover.
- Full description and technical details.
- Developer profile link (View more games by this creator).

### 🛒 Transactions & Interaction
- Secure purchase/interaction flow (requires login).
- User-Game relational data persistence.
- **Email System:** The developer receives an automated email notification when a user interacts with or buys their game.

---

## 🧑‍💼 Back-office (Management)

### 📋 My Inventory
- Management table for the user's own games.
- Actions: View, Edit, and Delete (only if no active transactions exist).

### 📦 My Operations
- A historical log of games the user has purchased or interacted with.

### ➕ Add New Game
- Comprehensive form for game publishing.
- Integrated image upload system.

### 👤 My Profile
- Private data visualization.
- **Independent Security Modules:**
  - Password update.
  - Avatar management:
    - Max size: **10KB**.
    - Resolution: **100x100 px**.
    - Format: **JPG/PNG**.

### 🛠️ User Management (Admin Only)
- Global user database table.
- Features: Role switching and secure account deletion.
- Filters by user type.

---

## 🔐 Security & Access Control

- **Session Guard:** All private routes are protected by Symfony security voters.
- **Encryption:** All passwords hashed using **bcrypt**.
- **Data Integrity:** Used **PDO** with **Prepared Statements** to prevent SQL Injection.
- **Input Validation:** Full server-side validation for all forms.

---

## 🗄️ Database

- Managed with **MariaDB**.
- Includes a full SQL script with:
  - Database and User creation.
  - Table structures and relationships.
  - Seed data (Sample games and categories).
- **Default Admin:**
  - **User:** `admin`
  - **Password:** `admin`

---

## 🚀 Technologies Used

- **PHP / Symfony** (Backend Framework)
- **Twig** (Templating Engine)
- **MariaDB** (Database)
- **Tailwind CSS / Bootstrap** (UI Design)
- **SwiftMailer / Mailer** (Email Services)
- **JavaScript** (Frontend Logic)

---

## 📂 Delivery Contents

The repository contains:
- Full Source Code.
- Database SQL Script.
- Admin credentials.
- This README.md file.
