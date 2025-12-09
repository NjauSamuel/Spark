# Mini Operations CRM - Demo Project

## Overview

This is a **Mini Operations CRM** built with Laravel, Inertia.js, and Vue 3. It demonstrates internal tooling capabilities including dashboard design, CRM functionality, task management, and trigger-based automations.

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Vue 3 with Inertia.js
- **Styling**: Tailwind CSS + Flowbite
- **Database**: SQLite (can be configured for MySQL/PostgreSQL)
- **Authentication**: Laravel Breeze

## Features Implemented

### 1. Dashboard
- Real-time statistics showing:
  - Total contacts count
  - Total tasks count
  - Pending tasks count
  - Completed tasks count
- Recent activity feed displaying:
  - Latest 5 contacts
  - Latest 5 tasks with associated contacts
- Quick navigation links to Contacts and Tasks modules

### 2. Contacts Module (CRM)
Full CRUD operations for managing contacts:
- **Create**: Add new contacts with name, email, and status
- **Read**: List all contacts with search and filter capabilities
- **Update**: Edit contact information
- **Delete**: Remove contacts
- **Search**: Filter by name or email
- **Status Filter**: Filter by status (new, active, lost)
- **Pagination**: Efficient handling of large contact lists

**Contact Fields:**
- Name (required)
- Email (required, validated)
- Status (new, active, lost)

### 3. Tasks Module
Full CRUD operations for managing tasks linked to contacts:
- **Create**: Add tasks with title, due date, status, and associated contact
- **Read**: List all tasks with filtering options
- **Update**: Edit task details
- **Delete**: Remove tasks
- **Contact Filter**: Filter tasks by associated contact
- **Status Filter**: Filter by status (pending, in_progress, completed)
- **Search**: Search tasks by title
- **Pagination**: Efficient handling of large task lists

**Task Fields:**
- Title (required)
- Contact (required, dropdown selection)
- Due Date (required, date picker)
- Status (pending, in_progress, completed)

### 4. Trigger-Based Automation

The system includes a webhook-based automation system that triggers when contacts are created or updated.

#### How It Works

1. **Events**: When a contact is created or updated, Laravel fires an event:
   - `ContactCreated` - Fired when a new contact is created
   - `ContactUpdated` - Fired when an existing contact is updated

2. **Listener**: The `SendContactWebhook` listener catches these events and calls the `WebhookService`.

3. **Webhook Service**: The service sends an HTTP POST request to a configured webhook URL with the contact data.

#### Webhook Payload

```json
{
  "event": "contact.created" | "contact.updated",
  "contact": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "status": "active",
    "created_at": "2024-01-01T12:00:00Z",
    "updated_at": "2024-01-01T12:00:00Z"
  },
  "timestamp": "2024-01-01T12:00:00Z"
}
```

#### Configuration

Add the webhook URL to your `.env` file:

```env
WEBHOOK_URL=https://your-webhook-endpoint.com/api/webhook
```

If no webhook URL is configured, the system will log the event but skip the HTTP call (graceful degradation).

#### Logging

All webhook attempts are logged to `storage/logs/laravel.log`:
- Successful webhook calls include status code
- Failed webhook calls include error messages
- Events without webhook URL configuration are logged as info

#### Use Cases

This automation system can be used to:
- Integrate with external CRM systems
- Send notifications to Slack/Discord
- Trigger email campaigns
- Sync data with third-party services
- Implement Zapier-like integrations

## API Integration Summary

The webhook system demonstrates API integration capabilities:

1. **Outbound API Calls**: Uses Laravel's HTTP client to send POST requests
2. **Error Handling**: Gracefully handles failures without breaking the main workflow
3. **Logging**: Comprehensive logging for debugging and monitoring
4. **Configuration**: Environment-based configuration for flexibility
5. **Event-Driven**: Decoupled architecture using Laravel events

## Setup Instructions

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm
- SQLite (or MySQL/PostgreSQL)

### Installation

1. **Clone the repository** (if applicable) or navigate to the project directory

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**:
   ```bash
   npm install
   ```

4. **Set up environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database** (if using SQLite, ensure `database/database.sqlite` exists):
   ```bash
   touch database/database.sqlite
   ```

6. **Run migrations**:
   ```bash
   php artisan migrate
   ```

7. **Build frontend assets**:
   ```bash
   npm run build
   ```

8. **Start the development server**:
   ```bash
   php artisan serve
   ```

   In another terminal, start Vite:
   ```bash
   npm run dev
   ```

9. **Create a user account**:
   - Visit `http://localhost:8000/register`
   - Create your account
   - Log in and start using the CRM

### Optional: Configure Webhook

To enable webhook automation:

1. Add to `.env`:
   ```env
   WEBHOOK_URL=https://your-webhook-endpoint.com/api/webhook
   ```

2. Test by creating or updating a contact - check `storage/logs/laravel.log` for webhook activity

## Project Structure

```
app/
├── Events/
│   ├── ContactCreated.php
│   └── ContactUpdated.php
├── Http/
│   ├── Controllers/
│   │   ├── ContactController.php
│   │   ├── DashboardController.php
│   │   └── TaskController.php
│   └── Requests/
│       ├── StoreContactRequest.php
│       ├── UpdateContactRequest.php
│       ├── StoreTaskRequest.php
│       └── UpdateTaskRequest.php
├── Listeners/
│   └── SendContactWebhook.php
├── Models/
│   ├── Contact.php
│   ├── Task.php
│   └── User.php
├── Providers/
│   └── AppServiceProvider.php
└── Services/
    └── WebhookService.php

resources/js/
├── Pages/
│   ├── Contacts/
│   │   ├── Index.vue
│   │   ├── Create.vue
│   │   └── Edit.vue
│   ├── Tasks/
│   │   ├── Index.vue
│   │   ├── Create.vue
│   │   └── Edit.vue
│   └── Dashboard.vue
└── Layouts/
    └── AuthenticatedLayout.vue

database/migrations/
├── create_contacts_table.php
└── create_tasks_table.php
```

## Key Design Decisions

1. **User Scoping**: All contacts and tasks are scoped to the authenticated user for data isolation
2. **Event-Driven Architecture**: Webhooks are triggered via events for loose coupling
3. **Graceful Degradation**: Webhook failures don't break contact creation/updates
4. **Responsive Design**: Mobile-friendly interface using Tailwind CSS
5. **Form Validation**: Server-side validation with Inertia.js form helpers for client-side feedback

## Future Enhancements (Not Implemented)

- Email notifications
- Task reminders
- Contact import/export (CSV)
- Advanced reporting and analytics
- Multi-user collaboration features
- Activity timeline
- Custom fields for contacts and tasks

## License

This is a demo project for MVP purposes.

