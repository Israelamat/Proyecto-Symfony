# 🎮 GameHub – Symfony Video Game Marketplace

**GameHub** is a robust E-commerce solution built with **Symfony**, focused on high-performance game management and secure transaction logic. It features a dual-layer architecture (Front/Back-office) and an automated event-driven mailing system.

---

## 🛠️ Technical Stack & Logic

### **Core Backend**
* **Framework:** Symfony (MVC Architecture).
* **Templating:** Twig with inheritance for dynamic UI rendering.
* **Database:** MariaDB using **PDO** with **Prepared Statements** to ensure immunity against SQL Injection.
* **Security:** * Authentication via Symfony Security Component.
    * Password hashing using **bcrypt**.
    * Role-Based Access Control (RBAC) with custom **Security Voters**.

### **Key Logic Features**
* **Automated Mailing:** Integrated **SwiftMailer/Mailer** logic that triggers custom notifications to developers upon user purchase or interaction.
* **Image Processing:** Backend validation for avatars (strict 10KB, 100x100px, JPG/PNG constraints).
* **Search Engine:** Complex SQL querying for multi-parameter filtering (Category, Date Range, and Full-text search).
* **State Management:** Intelligent navigation menus that react to User Roles and Session states.

---

## 🧩 Functional Structure

### 🔓 Front-office (Public Store)
* **Marketplace:** Real-time filtered game catalog.
* **Product Engine:** Detailed game views with developer attribution.
* **Onboarding:** Secure registration with numeric **CAPTCHA** to prevent bot spam.

### 🔐 Back-office (Management)
* **User Dashboard:** Manage personal inventory, track purchases, and update security profiles.
* **Admin Suite:** Global control over the user database and full catalog CRUD capabilities.
* **Transactions:** Relational data persistence between users and game entities.

---

## 🔐 Access Control

| Role | Permissions |
| :--- | :--- |
| **Guest** | Browse, Search, Register. |
| **Gamer** | Own Inventory CRUD, Profile Management, Buy Games. |
| **Admin** | Full Platform CRUD, Role Management, User Deletion. |

*Default Admin Credentials:* `admin` / `admin`

---

## 📸 Preview

[![Game-Hub.jpg](https://i.postimg.cc/zXZQ3RPp/Game-Hub.jpg)](https://postimg.cc/yWjjbWKS)
---
