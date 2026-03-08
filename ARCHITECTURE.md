# Project Sarthi: Architecture & Workflow

## Overview
**Sarthi** is an enterprise multi-role service management platform built with Laravel 12, React 18, and Inertia.js. It is designed to facilitate seamless interaction between customers, staff, affiliates, and administrators.

---

## 🏗️ Backend Architecture (Domain-Driven Design)
The project follows strict **Domain-Driven Design (DDD)** principles to ensure scalability and maintainability.

### 1. Thin Controllers
Controllers in `app/Http/Controllers` are kept intentionally thin. They handle request validation, call domain services, and return Inertia responses. No business logic resides here.

### 2. Domain Services
All business logic is encapsulated within `app/Domain/Services`.
- **ServiceRequestService:** Manages request creation and state transitions.
- **RequestChatService:** Handles real-time messaging and chat permissions.
- **AssignmentService:** Manages the assignment of staff members to requests.

### 3. Models & Database
- **Eloquent Models:** Located in `app/Models`.
- **Database Schema:** Uses strict naming conventions. Tables often have prefixes (e.g., `cab_`) and use abbreviations (e.g., `custmr`, `prfl`, `stau`).
- **UUIDs/UINs:** Domain-specific tables utilize UUID strings as primary keys for enhanced security and distributed system compatibility.
- **SQLite/MySQL:** SQLite is used for development/testing, while the system is architected for MySQL in production with strict foreign key enforcement.

---

## 🔐 Security & Access Control

### 1. Role-Based Access Control (RBAC)
The system supports four distinct roles:
- **Admin:** Full system access, staff assignment, and monitoring.
- **Staff:** Management of assigned service requests and task fulfillment.
- **Customer:** Requesting services and tracking progress.
- **Affiliate:** Referral and partner-specific functionalities.

### 2. Middleware & Policies
- **EnsureRole Middleware:** Enforces role-level access at the route layer.
- **Authorization:** Handled through a combination of manual checks in controllers (for critical security fixes) and Laravel Policies to ensure users can only access data they own or are assigned to.

---

## 🖥️ Frontend Architecture

### 1. The Stack
- **React 18+:** Functional components and hooks.
- **Inertia.js:** Serves as the bridge between Laravel and React, providing a single-page app (SPA) experience without the complexity of a client-side API.
- **Tailwind CSS:** Utility-first styling for a consistent and responsive UI.

### 2. State Management
- **Inertia `useForm`:** Used for form handling and server-side synchronization.
- **Independent Actions:** Complex views use multiple `useForm` instances to manage individual processing states (e.g., toggling chat independently of status updates).

---

## 💬 Communication Workflow

### 1. Real-time Messaging
- **Laravel Reverb:** Powers the WebSocket server for low-latency communication.
- **Laravel Echo:** Used on the frontend to listen for chat events and update the UI in real-time.
- **Chat Attachments:** Stored in `storage/app/public/chat_attachments` with support for PDFs, images, Office docs, and ZIP files.

### 2. Service Request Lifecycle
1. **Creation:** A Customer creates a request via `CustomerController`.
2. **Assignment:** An Admin assigns a Staff member via `AdminController`.
3. **Execution:** The Staff member transitions the status (e.g., `assigned` -> `in_progress`) via `StaffController`.
4. **Communication:** Both parties communicate via the shared `ChatController` and domain services.
5. **Completion:** The Staff member marks the request as `completed` after review.

---

## 🛠️ Development & Tooling
- **Testing:** `php artisan test` (Backend) and Playwright (Frontend).
- **Asset Building:** `npm run dev` and `npm run build` via Vite.
- **Linting:** Laravel Pint and standard PHP linting (`php -l`).
