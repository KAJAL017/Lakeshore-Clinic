# AGENTS.md

## Project Overview

Laravel 12 clinic management app (Lakeshore-Clinic). Uses MySQL in production, SQLite in-memory for tests.

## Quick Reference

### Setup (first time)
```bash
composer setup
```
Runs: `composer install`, creates `.env`, generates app key, runs migrations, `npm install`, `npm run build`.

### Development
```bash
composer dev
```
Runs three processes concurrently: `php artisan serve`, `php artisan queue:listen`, `npm run dev` (Vite HMR).

### Testing
```bash
composer test
```
Clears config cache then runs `php artisan test`. Tests use Pest (not raw PHPUnit) with SQLite in-memory database.

Run a single test file:
```bash
php artisan test tests/Feature/ExampleTest.php
```

### Code Quality
- **Formatter**: Laravel Pint (`./vendor/bin/pint`). No config file; uses Laravel defaults.
- **Linting/Typecheck**: None configured. No PHPStan, Psalm, or ESLint.

### Frontend
- Vite + Tailwind CSS v4
- Entry points: `resources/css/app.css`, `resources/js/app.js`
- Build: `npm run build`

## Architecture

### Directory Structure
```
app/
  Http/Controllers/    # Route controllers (only base Controller.php exists)
  Models/              # Eloquent models (only User.php)
  Providers/           # AppServiceProvider
config/                # Standard Laravel config files
database/
  migrations/          # 3 default migrations (users, cache, jobs)
  factories/           # Model factories
  seeders/             # Database seeders
resources/
  views/               # Blade templates (only welcome.blade.php)
  css/                 # Tailwind entry (app.css)
  js/                  # JS entry (app.js, bootstrap.js)
routes/
  web.php              # Web routes (only welcome page)
  console.php          # Console commands
tests/
  Feature/             # Feature tests (Pest)
  Unit/                # Unit tests (Pest)
```

### Key Conventions
- **PHP**: 8.2+ required, PSR-4 autoloading under `App\` namespace
- **Testing**: Pest PHP, `Tests\TestCase` base class, `RefreshDatabase` trait commented out by default
- **Database**: MySQL (production), SQLite `:memory:` (tests via phpunit.xml env)
- **Editor**: 4 spaces, LF line endings, UTF-8 (`.editorconfig`)
- **Session/Cache/Queue**: Database-backed by default (not Redis)
- **Environment**: Copy `.env.example` to `.env`, generate key with `php artisan key:generate`

## Gotchas

- Tests always use SQLite in-memory regardless of `.env` DB settings (configured in `phpunit.xml`).
- `composer dev` uses `concurrently` npm package — requires `node_modules` installed.
- Vite ignores `storage/framework/views/` in file watching.



# PHASE 1 - PROJECT FOUNDATION & DESIGN SYSTEM

## ROLE

You are a Senior Laravel Software Architect and Senior Full Stack Developer.

Your task is to create ONLY the foundation for a Clinic & Telemedicine Appointment Management System.

This is Phase 1 only.

DO NOT implement future phases.

---

# MOST IMPORTANT RULE

Before making any changes:

1. Analyze the entire project.
2. Understand existing structure.
3. Never break existing functionality.
4. Never redesign existing components unnecessarily.
5. Build only Phase 1 requirements.
6. Prepare architecture for future phases.

---

# TECHNOLOGY

Backend:

* Laravel Latest

Database:

* MySQL

Frontend:

* Laravel Blade
* Tailwind CSS CDN
* Pure Vanilla JavaScript

STRICTLY FORBIDDEN:

* Bootstrap
* jQuery
* React
* Vue
* Alpine
* Livewire
* Flowbite
* DaisyUI
* AdminLTE
* Metronic
* Any third-party UI library

---

# OBJECTIVE

Build the project's base architecture.

The system should be scalable.

Future modules should integrate without refactoring.

---

# FOLDER STRUCTURE

Organize the project properly.

Create clean structure for:

Controllers

Models

Middleware

Requests

Services

Helpers

Traits

Blade Layouts

Blade Components

Assets

JavaScript

CSS

Images

Uploads

Configurations

Policies

Providers

Future modules ready.

---

# MASTER LAYOUT

Create one global dashboard layout.

Include:

Sidebar placeholder

Header

Footer

Breadcrumb

Content section

Notification placeholder

Profile placeholder

Responsive mobile drawer

Sticky header

Main content wrapper

Future dark mode architecture

---

# DESIGN SYSTEM

Create reusable UI foundation.

Create component structure for future use.

Buttons

Cards

Inputs

Textarea

Select

Checkbox

Radio

Switch

Badges

Alerts

Tables

Pagination

Dropdown

Modal

Avatar

Breadcrumb

Toast

Loader

Skeleton Loader

Empty State

Status Badge

Profile Card

Stat Card

Upload Card

Calendar Card

Search Box

Filter Box

Action Menu

Confirmation Dialog

Do not implement business logic.

Create reusable design system only.

---

# SIDEBAR FOUNDATION

Create sidebar structure.

Support:

Icons

Nested menus

Collapsible state

Responsive drawer

Active state

Smooth animation

Role based support architecture

Dynamic menu architecture

Future expansion ready.

Use placeholder items only.

---

# HEADER FOUNDATION

Sticky header.

Include:

Breadcrumb

Page title

Search placeholder

Notification placeholder

Profile placeholder

Mobile menu button

Responsive layout

Future dropdown architecture.

---

# FOOTER

Simple professional footer.

---

# DASHBOARD PLACEHOLDER

Create generic dashboard page.

Do NOT implement actual data.

Use placeholders.

Statistic cards.

Quick actions.

Recent activities.

Upcoming events.

Notifications.

Calendar placeholder.

Future widgets ready.

---

# RESPONSIVE DESIGN

Support:

Desktop

Laptop

Tablet

Mobile

Small Mobile

No broken layout.

No horizontal scroll.

---

# TAILWIND DESIGN

Create consistent spacing.

Consistent typography.

Consistent card design.

Consistent button design.

Consistent input design.

Consistent color palette.

Healthcare SaaS appearance.

Modern and premium.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

Sidebar

Mobile drawer

Dropdown architecture

Toast architecture

Modal architecture

Responsive behavior

Theme architecture

No third-party libraries.

---

# FILES

Create reusable Blade layouts.

Reusable Blade components.

Reusable JavaScript functions.

Reusable helper utilities.

Organized asset structure.

---

# DATABASE

Do NOT create business tables.

Create only:

migrations infrastructure if necessary.

Keep future modules in mind.

No appointment tables.

No doctor tables.

No patient tables.

No payment tables.

No insurance tables.

No Teams tables.

These will come later.

---

# SECURITY FOUNDATION

Prepare architecture for:

CSRF

Middleware

Role middleware

Authentication

Authorization

Audit logs

Secure uploads

Do not implement business logic.

---

# CODE QUALITY

Use Laravel best practices.

Clean naming.

Reusable code.

SOLID principles.

Maintainable structure.

Avoid duplication.

Scalable architecture.

---

# UI REQUIREMENTS

Premium healthcare SaaS.

Custom design.

Unique interface.

Not template based.

Professional.

Minimal.

Elegant.

Fast.

Responsive.

---

# DO NOT BUILD

Authentication

Roles

Permissions

Doctor CRUD

Patient CRUD

Appointments

Calendar logic

Telemedicine

Stripe

Insurance

Microsoft Teams

Notifications

Prescriptions

Consultation Notes

Reports

Settings

Profile management

Any business feature

---

# FINAL DELIVERABLE

At the end of Phase 1 the project should have:

✅ Clean Laravel architecture

✅ Organized folder structure

✅ Master layout

✅ Shared design system

✅ Shared Blade components

✅ Shared JavaScript utilities

✅ Responsive sidebar foundation

✅ Responsive header foundation

✅ Footer

✅ Generic dashboard placeholder

✅ Mobile responsive architecture

✅ Future module ready structure

Build ONLY the foundation. Stop after Phase 1 is complete. Do not implement future phases.



# PHASE 2 – AUTHENTICATION SYSTEM

## ROLE

You are a Senior Laravel Architect and Full Stack Developer.

Continue from Phase 1.

Analyze the existing codebase before making changes.

Never break existing functionality.

Implement ONLY Phase 2.

---

# OBJECTIVE

Build the complete authentication system.

Future modules must integrate without refactoring.

---

# TECHNOLOGY

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

MySQL

---

# VERY IMPORTANT

ALL FORMS MUST USE AJAX.

NO FULL PAGE RELOADS.

Future project architecture should also support AJAX-first development.

Every form should have:

Loading State

Disabled Submit Button

Inline Validation

Success Toast

Error Toast

Graceful Error Handling

---

# AUTHENTICATION FEATURES

Implement:

Login

Forgot Password

Reset Password

Logout

Remember Me

Session Management

Password Hashing

Account Status Checking

Guest Middleware

Auth Middleware

Secure Authentication

---

# LOGIN PAGE

Modern UI.

Responsive.

Email

Password

Remember Me

Forgot Password

Login Button

AJAX Submission

Validation

Loading State

Toast Messages

Error Handling

---

# FORGOT PASSWORD

Email Field

AJAX Submission

Validation

Success Response

Error Response

Loading State

---

# RESET PASSWORD

Token

Email

New Password

Confirm Password

AJAX Submission

Validation

Password Rules

Success Response

---

# LOGOUT

Secure Logout

Session Destroy

CSRF Protection

Redirect Handling

---

# SESSION MANAGEMENT

Remember Me

Session Regeneration

Session Security

Logout All Future Ready

---

# ACCOUNT STATUS

Prepare architecture for:

Active

Inactive

Pending

Blocked

Suspended

Prevent unauthorized login.

Display proper messages.

---

# MIDDLEWARE

Guest

Authenticated

Future Role Ready

Secure Route Protection

---

# VALIDATION

Use Form Requests.

Strong password validation.

Email validation.

Error messages.

AJAX response format.

---

# DATABASE

Create only authentication-related requirements.

Update users table if needed.

Do not create business tables.

---

# UI

Premium healthcare SaaS.

Responsive.

Modern.

Minimal.

Reusable components.

Consistent with Phase 1.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX Forms

Loading Buttons

Toast Messages

Validation Display

Error Handling

Request Handling

Success Handling

No third-party libraries.

---

# TOAST SYSTEM

Success

Error

Warning

Info

Auto Close

Manual Close

Reusable.

---

# BUTTON STATES

Normal

Loading

Disabled

Success

Error

Prevent duplicate submissions.

---

# SECURITY

CSRF

Password Hashing

Rate Limiting Ready

Session Regeneration

Secure Authentication

Input Validation

Secure Error Messages

---

# FILE STRUCTURE

Keep code organized.

Controllers

Requests

Services

Blade Views

JavaScript

Reusable Helpers

---

# ROUTES

Guest Routes

Authenticated Routes

Clean Naming

Future Role Support

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

---

# CODE QUALITY

Laravel Best Practices

SOLID

Reusable Code

Clean Architecture

Scalable Design

Avoid Duplication

---

# DO NOT BUILD

Roles

Permissions

Admin CRUD

Doctor CRUD

Patient CRUD

Appointments

Telemedicine

Stripe

Insurance

Microsoft Teams

Calendar

Notifications

Prescriptions

Reports

Settings

Business Modules

---

# FINAL DELIVERABLE

At the end of Phase 2:

✅ Login

✅ Forgot Password

✅ Reset Password

✅ Logout

✅ Session Management

✅ Account Status Architecture

✅ AJAX Authentication

✅ Toast System

✅ Loading States

✅ Validation

✅ Responsive Authentication UI

✅ Secure Authentication Foundation

Build ONLY Phase 2 and stop after completion.


# PHASE 3 – ROLE & PERMISSION SYSTEM

## ROLE

You are a Senior Laravel Architect and Full Stack Developer.

Continue from Phase 2.

Analyze the entire existing project before making changes.

Never break existing functionality.

Implement ONLY Phase 3.

---

# OBJECTIVE

Build the Role & Permission foundation.

This phase should prepare the application for:

Admin

Doctor

Patient

Future roles if required.

This is architecture only.

Do NOT build business modules.

---

# PROJECT RULES

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first forms

Reusable components

Clean architecture

---

# ROLE SYSTEM

Create role architecture.

Default roles:

Admin

Doctor

Patient

Future roles should be easy to add.

---

# USER ROLE ASSIGNMENT

Every user must belong to a role.

Support:

Assign Role

View Role

Update Role

Future multiple roles ready if needed.

---

# PERMISSION ARCHITECTURE

Create permission foundation.

Prepare for:

View

Create

Edit

Delete

Approve

Reject

Assign

Manage

Export

Settings

Future permissions should be easy to add.

Do not hardcode permissions.

---

# DATABASE

Create only required tables.

Example architecture:

roles

permissions

role_permissions

user_roles

or any scalable design.

Create proper relationships.

Foreign keys.

Indexes.

Seeders.

Default roles.

Default permissions.

---

# DEFAULT DATA

Automatically create:

Admin Role

Doctor Role

Patient Role

Basic permission groups.

---

# MIDDLEWARE

Create:

Role Middleware

Permission Middleware

Unauthorized access handling.

Future module ready.

---

# ROUTE PROTECTION

Prepare routes for:

Admin

Doctor

Patient

Guest

Authenticated

Unauthorized access page.

---

# DASHBOARD REDIRECTION

After login:

Admin → Admin Dashboard

Doctor → Doctor Dashboard

Patient → Patient Dashboard

Use role checking.

---

# ACCESS CONTROL

Prepare architecture.

Example:

Admin can access admin routes.

Doctor cannot access admin routes.

Patient cannot access doctor routes.

Unauthorized access should be handled gracefully.

---

# AJAX

Continue AJAX-first architecture.

Any role assignment form should support:

AJAX submit

Loading state

Validation

Success toast

Error toast

No page reload.

---

# ADMIN ROLE MANAGEMENT PAGE

Create basic role management UI.

View Roles

View Permissions

Assign Permissions

Assign Roles

Simple clean interface.

Future expansion ready.

---

# UI

Maintain Phase 1 and Phase 2 design language.

Premium healthcare SaaS appearance.

Responsive.

Minimal.

Professional.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX Forms

Permission Selection

Loading States

Toast Messages

Validation

Error Handling

Reusable Functions

---

# SECURITY

Middleware

Authorization

Permission Checks

Validation

Secure Route Access

Prevent unauthorized actions.

---

# FILE STRUCTURE

Keep clean architecture.

Controllers

Models

Middleware

Policies

Services

Requests

Blade Views

JavaScript

Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Maintain responsiveness.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication

---

# DO NOT BUILD

Doctor CRUD

Patient CRUD

Appointments

Specializations

Telemedicine

Stripe

Insurance

Microsoft Teams

Calendar

Prescriptions

Consultation Notes

Notifications

Reports

Settings Business Logic

Any appointment workflow

---

# FINAL DELIVERABLE

At the end of Phase 3:

✅ Role System

✅ Permission Architecture

✅ Default Roles

✅ Default Permissions

✅ Role Middleware

✅ Permission Middleware

✅ Route Protection

✅ Dashboard Redirection

✅ User Role Assignment

✅ Basic Role Management UI

✅ AJAX Role Management

✅ Responsive Interface

✅ Secure Access Control

Build ONLY the Role & Permission System.

Stop after Phase 3 is complete.

Do not implement future business modules.
# PHASE 4 – ADMIN PANEL FOUNDATION & CORE ADMIN DASHBOARD

## ROLE

You are a Senior Laravel Architect and Full Stack Developer.

Continue from Phase 3.

Before making changes:

* Analyze the existing codebase.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing layouts and components.
* Implement ONLY Phase 4.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first forms

Responsive design

Reusable components

Premium healthcare SaaS UI

---

# OBJECTIVE

Build the Admin Panel foundation.

Create a functional Admin workspace.

Prepare infrastructure for future modules.

Do NOT build business CRUD operations.

---

# ADMIN PANEL

Create authenticated Admin area.

Only Admin users can access.

Unauthorized users should be redirected properly.

---

# ADMIN MASTER LAYOUT

Create reusable admin layout.

Include:

Sidebar

Header

Footer

Breadcrumb

Content Area

Profile Dropdown

Notification Placeholder

Responsive Mobile Drawer

Sticky Header

Future Widget Area

---

# ADMIN SIDEBAR

Create navigation.

Dashboard

Patients

Doctors

Specializations

Appointments

Telemedicine

Payments

Insurance

Reports

Settings

Profile

Logout

Future modules should use these menu items.

For unfinished modules create placeholder pages.

Do not implement business logic.

---

# ADMIN HEADER

Sticky.

Include:

Page Title

Breadcrumb

Search Placeholder

Notification Placeholder

Profile Dropdown

Mobile Menu

Responsive Layout

---

# PROFILE DROPDOWN

Profile

Account

Change Password

Logout

Responsive.

Reusable.

---

# ADMIN DASHBOARD

Create dashboard page.

Use placeholder information.

No business logic.

Create sections:

Statistics Cards

Quick Actions

Recent Activity

Pending Items

Upcoming Activities

System Overview

Calendar Placeholder

Chart Placeholder

Notification Area

---

# STAT CARDS

Create reusable cards.

Total Patients

Total Doctors

Today's Appointments

Pending Reviews

Revenue

Insurance Cases

Placeholder values only.

---

# QUICK ACTIONS

Placeholder buttons.

Future ready.

Responsive.

---

# RECENT ACTIVITY

Placeholder timeline.

Future AJAX ready.

---

# NOTIFICATIONS

Placeholder panel.

Future notification system ready.

---

# CALENDAR

Placeholder calendar card.

No booking logic.

---

# CHART AREA

Placeholder analytics card.

Future charts ready.

---

# PLACEHOLDER PAGES

Create placeholder pages for:

Patients

Doctors

Specializations

Appointments

Telemedicine

Payments

Insurance

Reports

Settings

Each page should have:

Page Header

Breadcrumb

Description

Coming Soon Area

Consistent layout

---

# SHARED ADMIN COMPONENTS

Create reusable:

Page Header

Stat Card

Information Card

Dashboard Card

Search Box

Filter Box

Action Button

Empty State

Status Badge

Table Container

Timeline Card

Notification Card

Profile Card

Calendar Card

Chart Card

Loading Spinner

Skeleton Loader

Toast

Modal Foundation

Confirmation Dialog

---

# AJAX FOUNDATION

Prepare reusable AJAX helpers.

Future forms should integrate easily.

No business form implementation.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

Sidebar

Mobile Drawer

Profile Dropdown

Toast

Modal

Responsive Navigation

Loading States

Future AJAX Helpers

Reusable Utilities

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive sidebar.

Responsive cards.

Responsive dashboard.

No horizontal scrolling.

---

# UI

Maintain previous design language.

Modern.

Professional.

Premium healthcare SaaS.

Clean.

Minimal.

Consistent.

---

# FILE STRUCTURE

Create reusable admin structure.

Layouts

Components

JavaScript

Helpers

Assets

Maintain clean architecture.

---

# SECURITY

Admin authentication required.

Route protection.

Session validation.

Prevent unauthorized access.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Scalable Architecture

Maintainability

Avoid Duplication

---

# DO NOT BUILD

Doctor CRUD

Patient CRUD

Specialization CRUD

Appointments Logic

Telemedicine Logic

Stripe

Insurance Workflow

Microsoft Teams

Reports Logic

Notification Logic

Settings Logic

Calendar Logic

Any business CRUD

Any business workflow

---

# FINAL DELIVERABLE

At the end of Phase 4:

✅ Admin Panel Foundation

✅ Admin Master Layout

✅ Admin Sidebar

✅ Admin Header

✅ Admin Footer

✅ Profile Dropdown

✅ Admin Dashboard

✅ Statistics Cards

✅ Quick Actions

✅ Recent Activity Placeholder

✅ Calendar Placeholder

✅ Notification Placeholder

✅ Placeholder Pages

✅ Shared Admin Components

✅ AJAX Helper Foundation

✅ Responsive Admin UI

✅ Premium Healthcare Dashboard

Build ONLY the Admin Panel Foundation and Core Admin Dashboard.

Stop after Phase 4 is complete.

Do not implement future business modules.




# PHASE 5 – ADMIN PROFILE & CLINIC SETTINGS FOUNDATION

## ROLE

You are a Senior Laravel Architect and Full Stack Developer.

Continue from Phase 4.

Before making any changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing layouts and components.
* Implement ONLY Phase 5.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first forms

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Admin Profile and Clinic Settings Foundation.

Create configuration architecture for future modules.

Do NOT implement business modules.

---

# ADMIN PROFILE

Create Admin Profile section.

Admin should be able to:

View Profile

Edit Profile

Update Profile Photo

Update Contact Information

Change Password

View Account Information

All forms must use AJAX.

---

# PROFILE INFORMATION

Support:

Full Name

Email

Phone

Profile Photo

Basic Information

Account Status Display

Created Date

Last Login Placeholder

---

# CHANGE PASSWORD

Current Password

New Password

Confirm Password

Validation

AJAX Submit

Loading State

Success Toast

Error Toast

Secure Password Update

---

# PROFILE PHOTO

Upload

Preview

Replace

Remove

Validation

Responsive UI

AJAX Upload

Future image optimization ready.

---

# CLINIC SETTINGS

Create settings foundation.

Support:

Clinic Name

Clinic Email

Clinic Phone

Clinic Address

Clinic Logo

Clinic Favicon

Timezone

Default Language Placeholder

Future settings ready.

---

# LOGO MANAGEMENT

Upload Logo

Preview

Replace

Remove

AJAX Upload

Validation

---

# FAVICON MANAGEMENT

Upload

Preview

Replace

Remove

Validation

AJAX

---

# SETTINGS STORAGE

Create scalable settings architecture.

Future modules should easily store configuration values.

Keep implementation simple and maintainable.

---

# SETTINGS PAGE

Create sections:

General Information

Clinic Branding

Contact Information

System Preferences Placeholder

Future Integrations Placeholder

Maintain clean layout.

---

# SHARED COMPONENTS

Create reusable:

Settings Card

Profile Card

Information Card

Upload Card

Preview Card

Action Buttons

Save Button

Cancel Button

Status Badge

Page Header

Section Header

Empty State

Loading State

Toast

Confirmation Dialog

---

# AJAX

ALL FORMS MUST USE AJAX.

Support:

Save

Update

Upload

Remove

Validation

Loading

Success Toast

Error Toast

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX Forms

Image Preview

Uploads

Loading States

Toast Messages

Validation

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive forms.

Responsive cards.

Responsive uploads.

No horizontal scrolling.

---

# UI

Maintain previous design language.

Premium.

Professional.

Minimal.

Healthcare SaaS.

Consistent.

---

# SECURITY

Admin authentication required.

Validate uploads.

Protect settings routes.

Secure password updates.

CSRF protection.

Input validation.

---

# FILE STRUCTURE

Keep architecture clean.

Controllers

Requests

Services

Blade Views

JavaScript

Helpers

Reusable Components

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Scalable Structure

Maintainability

Avoid Duplication

---

# DO NOT BUILD

Doctor CRUD

Patient CRUD

Appointments

Specializations

Telemedicine

Stripe

Insurance

Microsoft Teams

Reports

Notifications

Calendar Logic

Business Workflows

Any CRUD unrelated to Admin Profile and Clinic Settings

---

# FINAL DELIVERABLE

At the end of Phase 5:

✅ Admin Profile

✅ Profile Update

✅ Profile Photo Management

✅ Change Password

✅ Clinic Settings Foundation

✅ Logo Management

✅ Favicon Management

✅ Settings Architecture

✅ Shared Settings Components

✅ AJAX Forms

✅ AJAX Uploads

✅ Responsive UI

✅ Premium Healthcare SaaS Design

Build ONLY the Admin Profile & Clinic Settings Foundation.

Stop after Phase 5 is complete.

Do not implement future business modules.


# PHASE 6 – DOCTOR MANAGEMENT SYSTEM

## ROLE

You are a Senior Laravel Architect and Full Stack Developer.

Continue from previous phases.

Before making any changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing layouts and components.
* Implement ONLY Phase 6.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Doctor Management System.

This phase is ONLY for Admin Doctor Management.

Future modules will extend this structure.

---

# DOCTOR MANAGEMENT

Admin should be able to:

View Doctors

Add Doctor

Edit Doctor

View Doctor Details

Activate Doctor

Deactivate Doctor

Approve Doctor

Reject Doctor

Search Doctors

Filter Doctors

View Doctor Profile

---

# DOCTOR INFORMATION

Support:

Profile Photo

Full Name

Email

Phone

Medical License Number

Qualification

Years of Experience

Specialization Placeholder

Gender

Date of Birth

Address

Biography

Status

Approval Status

Created Date

Updated Date

---

# DOCTOR STATUS

Support:

Pending

Approved

Rejected

Active

Inactive

Future expansion ready.

---

# DOCTOR LIST

Create modern data table.

Support:

Search

Filter

Pagination

Status Badge

Action Buttons

Responsive Table

AJAX Updates

---

# ADD DOCTOR

Create AJAX form.

Validation

Loading State

Success Toast

Error Toast

Responsive Layout

Profile Photo Upload

---

# EDIT DOCTOR

AJAX Update

Validation

Profile Update

Photo Update

Status Update

Loading State

Toast Messages

---

# VIEW DOCTOR

Create profile page.

Display:

Basic Information

Professional Information

Status

Approval

Profile Photo

Timeline Placeholder

Future Appointment Placeholder

---

# APPROVAL SYSTEM

Admin can:

Approve

Reject

Activate

Deactivate

Use AJAX.

Show confirmation dialog.

Show success message.

---

# SEARCH

Support AJAX search.

Search by:

Name

Email

Phone

License Number

---

# FILTERS

Status

Approval

Future Specialization Ready

Responsive UI

AJAX Updates

---

# PROFILE PHOTO

Upload

Preview

Replace

Remove

Validation

AJAX

Responsive

---

# PLACEHOLDER SECTIONS

Create placeholders for future:

Availability

Schedule

Appointments

Telemedicine

Consultations

Prescriptions

Performance

Keep architecture ready.

---

# SHARED COMPONENTS

Create reusable:

Doctor Card

Doctor Profile Card

Doctor Table

Status Badge

Search Box

Filter Box

Action Button

Profile Card

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

Upload Card

---

# AJAX

ALL FORMS MUST USE AJAX.

Support:

Create

Update

Approve

Reject

Activate

Deactivate

Upload

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX Forms

Search

Filters

Uploads

Preview

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive table.

Responsive forms.

Responsive cards.

No horizontal scrolling.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication required.

Validate uploads.

Protect routes.

CSRF protection.

Input validation.

Secure AJAX requests.

---

# DATABASE

Create only Doctor Management requirements.

Prepare for future expansion.

Maintain relationships.

Do not create appointment logic.

---

# FILE STRUCTURE

Maintain clean architecture.

Controllers

Models

Requests

Services

Blade Views

JavaScript

Helpers

Reusable Components

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication

---

# DO NOT BUILD

Doctor Availability

Doctor Schedule

Appointments

Appointment Assignment

Telemedicine

Microsoft Teams

Stripe

Insurance

Calendar Logic

Consultation Notes

Prescriptions

Notifications

Reports

Business Analytics

Any future workflow

---

# FINAL DELIVERABLE

At the end of Phase 6:

✅ Doctor Management

✅ Doctor List

✅ Add Doctor

✅ Edit Doctor

✅ View Doctor

✅ Doctor Approval

✅ Activate/Deactivate

✅ Search

✅ Filters

✅ AJAX CRUD

✅ Profile Photo Upload

✅ Shared Doctor Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Module Ready Architecture

Build ONLY the Doctor Management System.

Stop after Phase 6 is complete.

Do not implement future business modules.



# PHASE 7 – PATIENT MANAGEMENT SYSTEM

## ROLE

You are a Senior Laravel Architect and Full Stack Developer.

Continue from previous phases.

Before making any changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing layouts and components.
* Implement ONLY Phase 7.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Patient Management System.

This phase is primarily for Admin Patient Management while maintaining compatibility with Patient authentication.

Future appointment and medical modules will extend this structure.

---

# PATIENT MANAGEMENT

Admin should be able to:

View Patients

View Patient Details

Edit Patient

Activate Patient

Deactivate Patient

Search Patients

Filter Patients

View Patient Profile

Do NOT build appointment history logic yet.

---

# PATIENT INFORMATION

Support:

Profile Photo

First Name

Last Name

Email

Mobile Number

Gender

Date of Birth

Address

Emergency Contact

Account Status

Created Date

Updated Date

---

# ACCOUNT STATUS

Support:

Active

Inactive

Blocked (future ready)

Patient self-registration should remain compatible with previous authentication phases.

---

# PATIENT LIST

Create modern responsive table.

Support:

Search

Filter

Pagination

Status Badge

Action Buttons

Responsive Layout

AJAX Updates

---

# EDIT PATIENT

AJAX Update

Validation

Profile Update

Photo Update

Status Update

Loading State

Toast Messages

---

# VIEW PATIENT

Create profile page.

Display:

Basic Information

Emergency Contact

Profile Photo

Status

Timeline Placeholder

Future Medical History Placeholder

Future Appointment Placeholder

Future Prescription Placeholder

---

# SEARCH

AJAX Search.

Search by:

Name

Email

Mobile Number

---

# FILTERS

Status

Future appointment status ready

Responsive

AJAX updates

---

# PROFILE PHOTO

Upload

Preview

Replace

Remove

Validation

AJAX

Responsive

---

# PLACEHOLDER SECTIONS

Prepare placeholders for future:

Appointments

Medical Reports

Prescriptions

Consultation History

Payments

Insurance

Telemedicine

Notifications

Keep architecture ready.

---

# SHARED COMPONENTS

Create reusable:

Patient Card

Patient Profile Card

Patient Table

Status Badge

Search Box

Filter Box

Action Button

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

Upload Card

---

# AJAX

ALL FORMS MUST USE AJAX.

Support:

Update

Activate

Deactivate

Upload

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX Forms

Search

Filters

Uploads

Preview

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive tables.

Responsive forms.

Responsive cards.

No horizontal scrolling.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication required.

Protect routes.

Validate uploads.

CSRF protection.

Secure AJAX requests.

Input validation.

---

# DATABASE

Create only Patient Management requirements.

Maintain compatibility with existing authentication structure.

Prepare for future modules.

Do not implement appointment logic.

---

# FILE STRUCTURE

Maintain clean architecture.

Controllers

Models

Requests

Services

Blade Views

JavaScript

Helpers

Reusable Components

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication

---

# DO NOT BUILD

Appointments

Appointment History Logic

Medical Reports Logic

Telemedicine

Microsoft Teams

Stripe

Insurance

Calendar

Consultation Notes

Prescriptions Logic

Notifications Logic

Reports

Business Analytics

Any future workflow

---

# FINAL DELIVERABLE

At the end of Phase 7:

✅ Patient Management

✅ Patient List

✅ View Patient

✅ Edit Patient

✅ Activate/Deactivate Patient

✅ Search

✅ Filters

✅ AJAX Operations

✅ Profile Photo Management

✅ Shared Patient Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Module Ready Architecture

Build ONLY the Patient Management System.

Stop after Phase 7 is complete.

Do not implement future business modules.


# PHASE 8 – SPECIALIZATION MANAGEMENT SYSTEM

## ROLE

You are a Senior Laravel Architect and Full Stack Developer.

Continue from previous phases.

Before making any changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing layouts and components.
* Implement ONLY Phase 8.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Specialization Management System.

This module will be managed by Admin.

Future Doctor and Appointment modules will use this data.

Keep architecture scalable.

---

# ADMIN SPECIALIZATION MANAGEMENT

Admin should be able to:

View Specializations

Add Specialization

Edit Specialization

Activate

Deactivate

Search

Filter

View Details

---

# SPECIALIZATION INFORMATION

Support:

Specialization Name

Short Description

Icon Placeholder

Status

Created Date

Updated Date

Future doctor count placeholder

Future appointment count placeholder

---

# STATUS

Support:

Active

Inactive

Only Active specializations should be available for future modules.

---

# SPECIALIZATION LIST

Create modern responsive table.

Support:

Search

Filter

Pagination

Status Badge

Action Buttons

Responsive Layout

AJAX Updates

---

# ADD SPECIALIZATION

AJAX Form

Validation

Loading State

Success Toast

Error Toast

Responsive Layout

---

# EDIT SPECIALIZATION

AJAX Update

Validation

Status Update

Loading State

Toast Messages

---

# VIEW SPECIALIZATION

Create details page.

Display:

Basic Information

Status

Created Date

Updated Date

Future Doctor Placeholder

Future Appointment Placeholder

---

# SEARCH

AJAX Search

Search by:

Specialization Name

---

# FILTERS

Status

Responsive

AJAX Updates

---

# PLACEHOLDER SECTIONS

Prepare placeholders for future:

Doctors

Appointments

Telemedicine

Calendar

Analytics

Keep architecture ready.

---

# SHARED COMPONENTS

Create reusable:

Specialization Card

Specialization Table

Status Badge

Search Box

Filter Box

Action Button

Information Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL FORMS MUST USE AJAX.

Support:

Create

Update

Activate

Deactivate

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX Forms

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive tables.

Responsive forms.

Responsive cards.

No horizontal scrolling.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication required.

Protect routes.

CSRF protection.

Secure AJAX requests.

Input validation.

---

# DATABASE

Create specialization management structure.

Maintain compatibility with Doctor and Appointment future modules.

Do not implement relationships with appointments yet.

---

# FILE STRUCTURE

Maintain clean architecture.

Controllers

Models

Requests

Services

Blade Views

JavaScript

Helpers

Reusable Components

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication

---

# DO NOT BUILD

Doctor Availability

Doctor Schedule

Appointments

Appointment Booking

Doctor Assignment

Telemedicine

Microsoft Teams

Stripe

Insurance

Calendar Logic

Consultation Notes

Prescriptions

Notifications

Reports

Business Analytics

Any future workflow

---

# FINAL DELIVERABLE

At the end of Phase 8:

✅ Specialization Management

✅ Specialization List

✅ Add Specialization

✅ Edit Specialization

✅ View Specialization

✅ Activate/Deactivate

✅ Search

✅ Filters

✅ AJAX CRUD

✅ Shared Specialization Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Module Ready Architecture

Build ONLY the Specialization Management System.

Stop after Phase 8 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so that:

* One specialization can have multiple doctors.
* Future appointment booking can use active specializations.
* Future telemedicine and clinic visit modules can reuse this data.
* Existing phases must remain fully functional and unchanged.



# PHASE 9 – DOCTOR AVAILABILITY & SCHEDULE MANAGEMENT

## ROLE

You are a Senior Laravel Architect and Full Stack Developer.

Continue from previous phases.

Before making any changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing layouts and components.
* Implement ONLY Phase 9.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Doctor Availability and Schedule Management module.

Future appointment booking will depend on this module.

Keep implementation simple and scalable.

---

# DOCTOR AVAILABILITY

Doctor should be able to manage:

Working Days

Start Time

End Time

Availability Status

Break Placeholder

Future Leave Placeholder

---

# ADMIN

Admin should be able to:

View Doctor Availability

Edit Availability

Activate

Deactivate

Search

Filter

---

# WORKING DAYS

Support:

Monday

Tuesday

Wednesday

Thursday

Friday

Saturday

Sunday

Multiple day selection.

---

# TIME MANAGEMENT

Support:

Start Time

End Time

Validation

Future slot generation ready.

---

# STATUS

Support:

Available

Unavailable

Active

Inactive

---

# DOCTOR PANEL

Create Availability page.

Doctor can:

View

Add

Edit

Update

Manage schedule

AJAX only.

---

# ADMIN PANEL

Create Availability Management.

View schedules.

Search.

Filter.

Manage.

No appointment logic.

---

# AVAILABILITY LIST

Responsive table.

Search

Filter

Pagination

Status Badge

Action Buttons

AJAX updates.

---

# SEARCH

AJAX Search.

Support:

Doctor Name

Specialization

Status

---

# FILTER

Status

Working Day

Future ready.

---

# PLACEHOLDER

Prepare for future:

Appointment Slots

Calendar

Leaves

Telemedicine

Clinic Visits

Analytics

---

# SHARED COMPONENTS

Create:

Schedule Card

Availability Card

Time Card

Status Badge

Search Box

Filter Box

Action Button

Information Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Create

Update

Activate

Deactivate

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX Forms

Time Selection

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive forms.

Responsive tables.

Responsive cards.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Consistent with previous phases.

---

# SECURITY

Doctor authentication.

Admin authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

---

# DATABASE

Create only schedule and availability requirements.

Future appointment module should reuse this structure.

Do not implement booking logic.

---

# FILE STRUCTURE

Controllers

Models

Requests

Services

Blade Views

JavaScript

Helpers

Reusable Components

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Scalable Architecture

Maintainability

Avoid Duplication

---

# DO NOT BUILD

Appointment Booking

Appointment Assignment

Calendar Booking

Stripe

Insurance

Microsoft Teams

Consultation Notes

Prescriptions

Notifications

Reports

Business Analytics

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 9:

✅ Doctor Availability

✅ Doctor Schedule

✅ Working Days

✅ Time Management

✅ Admin Schedule Management

✅ Doctor Schedule Management

✅ Search

✅ Filters

✅ AJAX Operations

✅ Responsive UI

✅ Shared Components

✅ Future Appointment Ready Architecture

Build ONLY the Doctor Availability & Schedule Management module.

Stop after Phase 9 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Clinic Appointments
* Telemedicine Appointments
* Doctor Assignment
* Calendar
* Time Slots
* Reports

Without major refactoring.


# PHASE 10 – APPOINTMENT CORE FOUNDATION

## ROLE

You are a Senior Laravel Architect and Full Stack Developer.

Continue from previous phases.

Analyze the existing project before making changes.

Never break existing functionality.

Implement ONLY Phase 10.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Appointment Core Foundation.

This phase prepares the complete appointment architecture.

Do NOT build patient booking workflow.

Do NOT build telemedicine meetings.

Do NOT build payments.

---

# APPOINTMENT MODEL

Create appointment architecture.

Future modules should extend it.

Support:

Patient

Doctor

Specialization

Appointment Type

Appointment Date

Appointment Time

Status

Notes Placeholder

Created Date

Updated Date

---

# APPOINTMENT TYPES

Support:

Clinic Visit

Telemedicine

Future modules will use these values.

---

# APPOINTMENT STATUS

Support:

Pending

Approved

Rejected

Doctor Assigned

Scheduled

Cancelled

Rescheduled

Completed

No Show

Keep architecture scalable.

---

# ADMIN PANEL

Create Appointment Management.

Admin can:

View Appointments

View Details

Search

Filter

Update Status

No booking creation.

No doctor assignment logic.

---

# DOCTOR PANEL

Doctor can:

View Appointment List Placeholder

View Details Placeholder

Future consultation placeholder

No business workflow.

---

# PATIENT PANEL

Patient can:

View Appointment Placeholder

Future booking placeholder

No booking implementation.

---

# APPOINTMENT LIST

Responsive table.

Search

Filter

Pagination

Status Badge

Action Buttons

AJAX updates.

---

# APPOINTMENT DETAILS

Display:

Patient Placeholder

Doctor Placeholder

Specialization

Type

Date

Time

Status

Future consultation placeholder

---

# SEARCH

AJAX Search.

Support:

Patient

Doctor

Status

Appointment Type

---

# FILTERS

Status

Type

Date

Future ready.

---

# PLACEHOLDER

Prepare architecture for:

Booking

Doctor Assignment

Calendar

Telemedicine

Payments

Insurance

Teams

Consultation

Prescription

Notifications

Reports

---

# SHARED COMPONENTS

Create:

Appointment Card

Appointment Table

Status Badge

Search Box

Filter Box

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

View

Status Update

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Search

Filters

Status Updates

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive UI.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Consistent with previous phases.

---

# SECURITY

Admin authentication.

Doctor authentication.

Patient authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

---

# DATABASE

Create appointment foundation only.

Future booking modules should reuse this structure.

Do not implement booking logic.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Patient Booking

Doctor Assignment

Calendar Booking

Time Slot Reservation

Stripe

Insurance

Microsoft Teams

Consultation Notes

Prescriptions

Notifications

Reports

Business Analytics

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 10:

✅ Appointment Architecture

✅ Appointment Management

✅ Appointment Types

✅ Appointment Status

✅ Admin Appointment Module

✅ Doctor Appointment Placeholder

✅ Patient Appointment Placeholder

✅ Search

✅ Filters

✅ AJAX Operations

✅ Responsive UI

✅ Shared Components

✅ Future Booking Ready Architecture

Build ONLY the Appointment Core Foundation.

Stop after Phase 10 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Patient Booking
* Clinic Visits
* Telemedicine
* Doctor Assignment
* Calendar
* Time Slots
* Stripe
* Insurance
* Microsoft Teams
* Consultation Notes
* Prescriptions

without major refactoring.
# PHASE 11 – TIME SLOT MANAGEMENT SYSTEM

## ROLE

You are a Senior Laravel Architect and Full Stack Developer.

Continue from previous phases.

Before making any changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing layouts and components.
* Implement ONLY Phase 11.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Time Slot Management System.

This module will connect Doctor Availability with Future Appointment Booking.

Do NOT build patient booking.

Do NOT reserve slots.

Do NOT implement payment workflows.

---

# TIME SLOT FOUNDATION

Create reusable slot architecture.

Future modules should reuse it.

Support:

Doctor

Working Day

Start Time

End Time

Slot Duration

Status

Created Date

Updated Date

---

# SLOT DURATION

Support common durations.

Examples:

15 Minutes

20 Minutes

30 Minutes

45 Minutes

60 Minutes

Future configurable.

---

# DOCTOR PANEL

Doctor can:

View Slots

Create Slots

Edit Slots

Activate

Deactivate

Search

Filter

AJAX operations only.

---

# ADMIN PANEL

Admin can:

View Doctor Slots

Manage Slots

Search

Filter

Activate

Deactivate

Future override ready.

---

# SLOT STATUS

Support:

Active

Inactive

Available

Unavailable

Future Booked placeholder

---

# SLOT LIST

Responsive table.

Search

Filter

Pagination

Status Badge

Action Buttons

AJAX updates.

---

# SLOT DETAILS

Display:

Doctor

Working Day

Start Time

End Time

Duration

Status

Future Booking Placeholder

---

# SEARCH

AJAX Search.

Support:

Doctor

Day

Status

---

# FILTERS

Doctor

Status

Working Day

Responsive.

---

# PLACEHOLDER

Prepare for future:

Clinic Booking

Telemedicine Booking

Capacity

Booked Slots

Calendar

Analytics

Appointment Assignment

---

# SHARED COMPONENTS

Create:

Time Slot Card

Schedule Card

Status Badge

Search Box

Filter Box

Information Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Create

Update

Activate

Deactivate

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Search

Filters

Time Validation

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive UI.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Consistent with previous phases.

---

# SECURITY

Doctor authentication.

Admin authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

---

# DATABASE

Create time slot structure.

Reuse Doctor Availability.

Future Appointment modules should integrate directly.

Do not implement booking logic.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Patient Booking

Clinic Booking

Telemedicine Booking

Slot Reservation

Doctor Assignment

Stripe

Insurance

Microsoft Teams

Consultation Notes

Prescriptions

Notifications

Reports

Business Analytics

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 11:

✅ Time Slot Management

✅ Doctor Slot Management

✅ Admin Slot Management

✅ Slot Duration

✅ Slot Status

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Booking Ready Architecture

Build ONLY the Time Slot Management System.

Stop after Phase 11 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Clinic Appointment Booking
* Telemedicine Booking
* Calendar
* Capacity Management
* Doctor Assignment
* Appointment Approval

without major refactoring.
# PHASE 12 – CLINIC APPOINTMENT BOOKING SYSTEM

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing components and layouts.
* Implement ONLY Phase 12.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Clinic Appointment Booking System.

This phase is ONLY for Clinic Visit appointments.

Do NOT implement Telemedicine.

Do NOT implement Microsoft Teams.

Do NOT implement payments.

---

# CLINIC BOOKING

Patient should be able to:

Select Clinic Visit

Select Specialization

Select Doctor

Select Date

Select Available Time Slot

Enter Reason For Visit

Enter Symptoms

Enter Additional Notes

Submit Appointment

AJAX only.

---

# BOOKING FLOW

Patient

↓

Clinic Visit

↓

Specialization

↓

Doctor

↓

Available Date

↓

Available Time Slot

↓

Reason

↓

Symptoms

↓

Additional Notes

↓

Submit

↓

Pending Review

---

# SLOT VALIDATION

Only active doctors.

Only active specializations.

Only available dates.

Only available slots.

Prevent duplicate booking.

Prevent invalid selection.

---

# APPOINTMENT STATUS

New appointments:

Pending Review

Future phases will handle:

Approval

Doctor Assignment

Reschedule

Cancellation

Completion

---

# PATIENT PANEL

Create:

Book Clinic Appointment

Appointment Confirmation

Appointment List

Appointment Details

Future payment placeholder

---

# ADMIN PANEL

Create:

Clinic Appointments

View Details

Search

Filter

Approve Placeholder

Reject Placeholder

Status Update

No payment logic.

---

# DOCTOR PANEL

Create:

Clinic Appointment List

Appointment Details

Future consultation placeholder

---

# APPOINTMENT DETAILS

Display:

Patient

Doctor

Specialization

Date

Time

Reason

Symptoms

Additional Notes

Status

---

# SEARCH

AJAX Search.

Support:

Patient

Doctor

Date

Status

---

# FILTERS

Status

Date

Doctor

Specialization

---

# PLACEHOLDER

Prepare for future:

Payments

Insurance

Telemedicine

Teams

Consultation

Prescription

Notifications

Reports

---

# SHARED COMPONENTS

Create:

Booking Form

Appointment Card

Appointment Table

Status Badge

Search Box

Filter Box

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Booking

Update

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Booking Form

Search

Filters

Slot Validation

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive forms.

Responsive booking flow.

Responsive tables.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Consistent with previous phases.

---

# SECURITY

Patient authentication.

Admin authentication.

Doctor authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

Prevent duplicate submissions.

---

# DATABASE

Reuse existing appointment architecture.

Reuse doctor availability.

Reuse time slots.

Reuse specializations.

Do not duplicate structures.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Telemedicine Booking

Microsoft Teams

Stripe

Insurance

Online Payments

Consultation Notes

Prescriptions

Email Notifications

SMS Notifications

Reports

Business Analytics

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 12:

✅ Clinic Appointment Booking

✅ Patient Booking Flow

✅ Admin Clinic Appointment Management

✅ Doctor Clinic Appointment View

✅ Slot Validation

✅ Appointment Details

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Payment & Telemedicine Ready Architecture

Build ONLY the Clinic Appointment Booking System.

Stop after Phase 12 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Telemedicine Booking
* Stripe Payments
* Insurance
* Doctor Assignment
* Notifications
* Consultation Notes
* Prescriptions
* Reports

without major refactoring.
# PHASE 13 – TELEMEDICINE APPOINTMENT BOOKING

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing components and workflows.
* Implement ONLY Phase 13.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Telemedicine Appointment Booking System.

Reuse the existing appointment architecture.

Reuse doctors.

Reuse patients.

Reuse specializations.

Reuse availability.

Reuse time slots.

Do NOT implement Microsoft Teams.

Do NOT implement payments.

---

# PATIENT PANEL

Create Telemedicine Booking.

Patient should be able to:

Select Telemedicine

Choose Specialization

Choose Doctor

Choose Date

Choose Available Time Slot

Enter Reason For Consultation

Enter Symptoms

Enter Existing Conditions

Enter Current Medications

Upload Medical Documents (Optional)

Submit Appointment

AJAX only.

---

# BOOKING FLOW

Patient

↓

Telemedicine

↓

Specialization

↓

Doctor

↓

Date

↓

Available Time Slot

↓

Reason

↓

Symptoms

↓

Existing Conditions

↓

Current Medications

↓

Upload Documents

↓

Submit

↓

Pending Review

---

# DOCUMENTS

Allow optional upload.

Support:

PDF

JPG

JPEG

PNG

Validation required.

AJAX upload.

Future medical record ready.

---

# ADMIN PANEL

Create Telemedicine Appointment Management.

View

Search

Filter

View Details

Approve Placeholder

Reject Placeholder

Status Update

No Teams integration yet.

---

# DOCTOR PANEL

Create Telemedicine Appointment View.

View List

View Details

Future Meeting Placeholder

Future Consultation Placeholder

---

# APPOINTMENT DETAILS

Display:

Patient

Doctor

Specialization

Date

Time

Reason

Symptoms

Existing Conditions

Current Medications

Uploaded Documents

Status

---

# SEARCH

AJAX Search.

Support:

Patient

Doctor

Status

Date

---

# FILTERS

Status

Doctor

Specialization

Date

---

# PLACEHOLDER

Prepare for future:

Microsoft Teams

Stripe

Insurance

Consultation Notes

Prescriptions

Notifications

Reports

Meeting Links

---

# SHARED COMPONENTS

Create:

Telemedicine Card

Booking Form

Appointment Table

Document Card

Status Badge

Search Box

Filter Box

Information Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

Upload Component

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Booking

Upload

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Booking

Uploads

Preview

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive forms.

Responsive booking flow.

Responsive tables.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Patient authentication.

Doctor authentication.

Admin authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

Secure uploads.

Prevent duplicate submissions.

---

# DATABASE

Reuse existing appointment structure.

Reuse patient structure.

Reuse doctor structure.

Reuse specializations.

Reuse availability.

Reuse time slots.

Do not duplicate architecture.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Microsoft Teams

Meeting Links

Stripe

Insurance

Online Payments

Consultation Notes

Prescriptions

Email Notifications

SMS Notifications

Reports

Business Analytics

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 13:

✅ Telemedicine Booking

✅ Patient Telemedicine Flow

✅ Admin Telemedicine Management

✅ Doctor Telemedicine View

✅ Medical Document Upload

✅ Appointment Details

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Teams & Payment Ready Architecture

Build ONLY the Telemedicine Appointment Booking System.

Stop after Phase 13 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Microsoft Teams
* Stripe
* Insurance
* Doctor Assignment
* Notifications
* Consultation Notes
* Prescriptions
* Reports

without major refactoring.
# PHASE 14 – APPOINTMENT REVIEW & DOCTOR ASSIGNMENT

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing appointment architecture.
* Implement ONLY Phase 14.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Appointment Review and Doctor Assignment module.

Reuse existing Clinic and Telemedicine appointments.

Do NOT implement Microsoft Teams.

Do NOT implement payments.

---

# ADMIN PANEL

Create Appointment Review Management.

Admin should be able to:

View Pending Appointments

View Appointment Details

Approve

Reject

Assign Doctor

Reassign Doctor

Cancel

Reschedule Placeholder

Search

Filter

AJAX operations only.

---

# APPOINTMENT REVIEW

Support:

Pending Review

Approved

Rejected

Doctor Assigned

Cancelled

Future Rescheduled placeholder.

---

# DOCTOR ASSIGNMENT

Admin should be able to:

Select Doctor

Assign Doctor

Change Doctor

Reassign Doctor

Validate specialization compatibility.

Use AJAX.

---

# VALIDATION

Assigned doctor should:

Be Active

Be Approved

Match specialization

Be Available

Have valid schedule

---

# ADMIN APPOINTMENT DETAILS

Display:

Patient

Appointment Type

Clinic / Telemedicine

Specialization

Preferred Doctor Placeholder

Assigned Doctor

Date

Time

Reason

Symptoms

Documents Placeholder

Status

Assignment History Placeholder

---

# DOCTOR PANEL

Doctor can:

View Assigned Appointments

View Details

Future Consultation Placeholder

No consultation logic yet.

---

# PATIENT PANEL

Patient can:

View Appointment Status

View Assigned Doctor

View Appointment Details

Future Meeting Placeholder

---

# SEARCH

AJAX Search.

Support:

Patient

Doctor

Specialization

Status

Appointment Type

---

# FILTERS

Status

Doctor

Specialization

Appointment Type

Date

---

# PLACEHOLDER

Prepare architecture for:

Microsoft Teams

Stripe

Insurance

Consultation Notes

Prescriptions

Notifications

Reports

Meeting Links

---

# SHARED COMPONENTS

Create:

Appointment Card

Assignment Card

Doctor Card

Status Badge

Search Box

Filter Box

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Approve

Reject

Assign

Reassign

Cancel

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Assignment

Status Update

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive tables.

Responsive forms.

Responsive cards.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication.

Doctor authentication.

Patient authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

Prevent invalid assignments.

---

# DATABASE

Reuse existing appointment structure.

Reuse doctor structure.

Reuse specialization structure.

Reuse availability.

Reuse time slots.

Do not duplicate architecture.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Microsoft Teams

Meeting Creation

Stripe

Insurance

Online Payments

Consultation Notes

Prescriptions

Email Notifications

SMS Notifications

Reports

Business Analytics

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 14:

✅ Appointment Review

✅ Appointment Approval

✅ Appointment Rejection

✅ Doctor Assignment

✅ Doctor Reassignment

✅ Admin Management

✅ Doctor Assigned Appointments

✅ Patient Status Tracking

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Teams & Payment Ready Architecture

Build ONLY the Appointment Review & Doctor Assignment module.

Stop after Phase 14 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Microsoft Teams
* Stripe
* Insurance
* Consultation Notes
* Prescriptions
* Notifications
* Reports

without major refactoring.
# PHASE 15 – MICROSOFT TEAMS INTEGRATION & MEETING MANAGEMENT

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing appointment architecture.
* Implement ONLY Phase 15.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build Microsoft Teams integration for Telemedicine appointments.

Reuse existing Telemedicine appointments.

Reuse Doctor Assignment.

Do NOT implement consultation workflow.

Do NOT implement payments.

---

# APPLICABLE APPOINTMENTS

ONLY:

Telemedicine Appointments

Do not generate meetings for Clinic Visits.

---

# MICROSOFT TEAMS

Support:

Meeting ID

Meeting URL

Meeting Status

Meeting Creation Time

Meeting Placeholder Data

Future Meeting Recording Placeholder

---

# MEETING CREATION

After:

Telemedicine Appointment

↓

Approved

↓

Doctor Assigned

↓

Generate Teams Meeting

Store meeting information.

Avoid duplicates.

---

# ADMIN PANEL

Create Teams Management.

Admin can:

View Meetings

View Details

Regenerate Meeting Placeholder

Search

Filter

Manage Status

---

# DOCTOR PANEL

Doctor can:

View Assigned Meetings

View Meeting Details

Join Meeting Placeholder

Future Consultation Placeholder

---

# PATIENT PANEL

Patient can:

View Telemedicine Meeting

View Meeting Details

Join Meeting Placeholder

Meeting Status

---

# MEETING DETAILS

Display:

Patient

Doctor

Appointment

Specialization

Meeting ID

Meeting URL

Date

Time

Status

Created Date

---

# MEETING STATUS

Support:

Pending

Created

Active

Completed

Cancelled

---

# SEARCH

AJAX Search.

Support:

Patient

Doctor

Meeting ID

Status

Date

---

# FILTERS

Status

Doctor

Patient

Appointment Type

Date

---

# PLACEHOLDER

Prepare architecture for:

Email Notifications

SMS Notifications

Meeting Reminders

Consultation Notes

Prescriptions

Meeting Recordings

Reports

---

# SHARED COMPONENTS

Create:

Meeting Card

Meeting Table

Status Badge

Search Box

Filter Box

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

Join Button Placeholder

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Generate

Update

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Search

Filters

Meeting Updates

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive UI.

Responsive tables.

Responsive cards.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication.

Doctor authentication.

Patient authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

Protect meeting information.

---

# DATABASE

Reuse appointment structure.

Reuse doctor structure.

Reuse patient structure.

Reuse telemedicine appointments.

Create meeting structure only.

Avoid duplicate architecture.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Consultation Notes

Prescriptions

Stripe

Insurance

Online Payments

Email Notifications

SMS Notifications

Reports

Business Analytics

Meeting Recordings

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 15:

✅ Microsoft Teams Meeting Management

✅ Telemedicine Meeting Generation

✅ Admin Meeting Management

✅ Doctor Meeting View

✅ Patient Meeting View

✅ Meeting Status

✅ Meeting Details

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Consultation Ready Architecture

Build ONLY the Microsoft Teams Integration & Meeting Management module.

Stop after Phase 15 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Email Notifications
* SMS Notifications
* Consultation Notes
* Prescriptions
* Reports
* Meeting Reminders
* Meeting Recordings

without major refactoring.
# PHASE 16 – CONSULTATION MANAGEMENT & DOCTOR NOTES

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing appointment architecture.
* Implement ONLY Phase 16.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Consultation Management System.

Support:

Clinic Visits

Telemedicine

Reuse existing appointments.

Reuse doctors.

Reuse patients.

Do NOT implement prescriptions.

Do NOT implement payments.

---

# DOCTOR PANEL

Doctor can:

View Assigned Consultations

Open Consultation

View Patient Details

View Uploaded Documents

Add Consultation Notes

Update Consultation Notes

Mark Consultation Complete

AJAX only.

---

# CONSULTATION NOTES

Support:

Chief Complaint

Symptoms

Clinical Findings

Diagnosis Placeholder

Doctor Notes

Recommendations

Follow Up Placeholder

Private Notes Placeholder

Created Date

Updated Date

---

# CONSULTATION STATUS

Support:

Pending

In Consultation

Completed

---

# ADMIN PANEL

Admin can:

View Consultations

View Details

Search

Filter

View Status

Read Notes

No editing required.

---

# PATIENT PANEL

Patient can:

View Consultation Status

View Consultation Summary Placeholder

Future Prescription Placeholder

---

# CONSULTATION DETAILS

Display:

Patient

Doctor

Appointment

Clinic/Telemedicine

Date

Time

Symptoms

Uploaded Documents

Consultation Notes

Status

---

# DOCUMENT VIEW

Doctor should be able to view:

PDF

JPG

JPEG

PNG

Previously uploaded reports.

Do not duplicate uploads.

Reuse existing records.

---

# SEARCH

AJAX Search.

Support:

Patient

Doctor

Status

Date

---

# FILTERS

Status

Doctor

Appointment Type

Date

---

# PLACEHOLDER

Prepare architecture for:

Prescriptions

Notifications

Reports

Medical History

Follow Up

Future Attachments

---

# SHARED COMPONENTS

Create:

Consultation Card

Notes Card

Patient Summary Card

Document Card

Status Badge

Search Box

Filter Box

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Create

Update

Status Update

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Notes

Status Updates

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive forms.

Responsive cards.

Responsive tables.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Doctor authentication.

Admin authentication.

Patient authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

Doctors should only access assigned consultations.

---

# DATABASE

Reuse:

Appointments

Patients

Doctors

Telemedicine

Clinic Visits

Uploaded Documents

Create consultation notes structure only.

Avoid duplicate architecture.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Prescriptions

Stripe

Insurance

Email Notifications

SMS Notifications

Reports

Business Analytics

Medical History Module

Future Workflows

---

# FINAL DELIVERABLE

At the end of Phase 16:

✅ Consultation Management

✅ Doctor Consultation Notes

✅ Consultation Status

✅ Doctor Consultation Screen

✅ Admin Consultation View

✅ Patient Consultation Status

✅ Uploaded Document Viewing

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Prescription Ready Architecture

Build ONLY the Consultation Management & Doctor Notes module.

Stop after Phase 16 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Prescriptions
* Notifications
* Medical History
* Reports
* Follow Up Visits

without major refactoring.
# PHASE 17 – PRESCRIPTION MANAGEMENT SYSTEM

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing appointment and consultation architecture.
* Implement ONLY Phase 17.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Prescription Management System.

Support:

Clinic Consultations

Telemedicine Consultations

Reuse existing consultations.

Reuse patients.

Reuse doctors.

---

# DOCTOR PANEL

Doctor can:

Create Prescription

Update Prescription

View Prescription

Upload Optional PDF

Mark Prescription Ready

AJAX only.

---

# PRESCRIPTION

Support:

Patient

Doctor

Appointment

Consultation

Prescription Date

Diagnosis Placeholder

Medicine Instructions

General Advice

Follow Up Placeholder

Status

Created Date

Updated Date

---

# MEDICINE SECTION

Support multiple medicines.

Each medicine:

Medicine Name

Dosage

Frequency

Duration

Instructions

Future medicine database ready.

---

# PDF

Optional PDF Upload.

Support:

PDF

Preview Placeholder

Replace

Download

Validation

AJAX Upload

---

# PRESCRIPTION STATUS

Support:

Draft

Ready

Issued

---

# ADMIN PANEL

Admin can:

View Prescriptions

View Details

Search

Filter

Download PDF

No editing required.

---

# PATIENT PANEL

Patient can:

View Prescription

Download Prescription

View Medicine Details

View Doctor Information

View Consultation Information

---

# PRESCRIPTION DETAILS

Display:

Patient

Doctor

Appointment

Consultation

Medicines

Advice

Instructions

PDF

Status

Created Date

---

# SEARCH

AJAX Search.

Support:

Patient

Doctor

Date

Status

---

# FILTERS

Status

Doctor

Patient

Date

---

# PLACEHOLDER

Prepare architecture for:

Medical History

Refills

Pharmacy Integration

Reports

Future Attachments

---

# SHARED COMPONENTS

Create:

Prescription Card

Medicine Card

Patient Summary

Doctor Summary

Status Badge

Search Box

Filter Box

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

PDF Card

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Create

Update

Upload

Download

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Prescription Forms

Medicine Management

PDF Upload

Preview

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive forms.

Responsive cards.

Responsive tables.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Doctor authentication.

Admin authentication.

Patient authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

Doctors should only manage their assigned prescriptions.

---

# DATABASE

Reuse:

Consultations

Appointments

Doctors

Patients

Create prescription structure.

Support multiple medicines.

Avoid duplicate architecture.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Email Notifications

SMS Notifications

Stripe

Insurance

Reports

Business Analytics

Pharmacy Integration

Medical History Module

Future Workflows

---

# FINAL DELIVERABLE

At the end of Phase 17:

✅ Prescription Management

✅ Doctor Prescription Creation

✅ Medicine Management

✅ Optional PDF Upload

✅ Prescription Status

✅ Admin Prescription View

✅ Patient Prescription View

✅ Patient Prescription Download

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Medical History Ready Architecture

Build ONLY the Prescription Management System.

Stop after Phase 17 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Medical History
* Notifications
* Reports
* Pharmacy Integration
* Follow Up Visits

without major refactoring.
# PHASE 18 – MEDICAL DOCUMENTS & PATIENT RECORDS MANAGEMENT

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing patient and appointment architecture.
* Implement ONLY Phase 18.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Medical Documents and Patient Records Management module.

Reuse existing uploaded reports.

Reuse consultation documents.

Reuse prescriptions.

Do NOT create a separate EMR system.

---

# PATIENT RECORDS

Centralize patient records.

Display:

Patient Information

Appointments

Consultations

Prescriptions

Uploaded Medical Documents

Timeline Placeholder

---

# MEDICAL DOCUMENTS

Support:

PDF

JPG

JPEG

PNG

Reuse previously uploaded documents.

Avoid duplicate storage.

---

# DOCTOR PANEL

Doctor can:

View Patient Records

View Documents

View Prescriptions

View Consultation History

View Appointment History

No editing of historical records.

---

# ADMIN PANEL

Admin can:

View Patient Records

View Medical Documents

Search

Filter

View Details

Download Documents

---

# PATIENT PANEL

Patient can:

View Records

View Documents

Download Documents

View Previous Consultations

View Previous Prescriptions

---

# DOCUMENT DETAILS

Display:

Patient

Document Type

Upload Date

Associated Appointment

Associated Consultation

Associated Prescription Placeholder

File

---

# SEARCH

AJAX Search.

Support:

Patient

Document Type

Date

---

# FILTERS

Document Type

Patient

Date

---

# PLACEHOLDER

Prepare architecture for:

Medical History

Insurance

Reports

Future Attachments

Analytics

---

# SHARED COMPONENTS

Create:

Patient Record Card

Medical Document Card

Timeline Card

Prescription Card

Consultation Card

Status Badge

Search Box

Filter Box

Information Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

Download Card

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

View

Search

Filter

Download

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Search

Filters

Preview

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive UI.

Responsive tables.

Responsive cards.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Doctor authentication.

Admin authentication.

Patient authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

Doctors should access only authorized patient records.

---

# DATABASE

Reuse:

Patients

Appointments

Consultations

Prescriptions

Uploaded Documents

Do not duplicate existing records.

Create only required relationships.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Separate EMR

Insurance Workflow

Stripe

Notifications

Reports

Analytics

Pharmacy

Business Intelligence

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 18:

✅ Patient Records

✅ Medical Documents

✅ Doctor Record View

✅ Admin Record View

✅ Patient Record View

✅ Document Download

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Medical History Ready Architecture

Build ONLY the Medical Documents & Patient Records Management module.

Stop after Phase 18 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Insurance
* Reports
* Notifications
* Medical History
* Analytics

without major refactoring.
# PHASE 19 – STRIPE PAYMENT INTEGRATION

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing appointment architecture.
* Implement ONLY Phase 19.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Stripe Payment Integration.

Reuse existing Clinic and Telemedicine appointments.

Do NOT implement Provincial Insurance.

Do NOT implement refunds.

---

# PAYMENT METHOD

Support:

Stripe

Future Insurance Placeholder

---

# PATIENT PANEL

Patient can:

View Payment Summary

Pay Appointment Fee

View Payment Status

View Payment History

AJAX operations only.

---

# PAYMENT FLOW

Appointment

↓

Payment Summary

↓

Stripe Checkout

↓

Success

↓

Payment Recorded

↓

Appointment Updated

---

# PAYMENT DETAILS

Support:

Appointment

Patient

Amount

Currency

Transaction ID

Payment Status

Payment Date

Payment Method

---

# PAYMENT STATUS

Support:

Pending

Paid

Failed

Cancelled

---

# ADMIN PANEL

Admin can:

View Payments

View Details

Search

Filter

View Transactions

Payment Status

No refund workflow.

---

# DOCTOR PANEL

Doctor can:

View Payment Status Placeholder

No payment management.

---

# PAYMENT HISTORY

Patient:

View Transactions

View Status

View Details

---

# SEARCH

AJAX Search.

Support:

Patient

Transaction ID

Status

Date

---

# FILTERS

Status

Payment Method

Date

---

# PLACEHOLDER

Prepare architecture for:

Insurance

Refunds

Invoices

Reports

Analytics

---

# SHARED COMPONENTS

Create:

Payment Card

Transaction Card

Payment Summary

Status Badge

Search Box

Filter Box

Information Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Payment

Status Update

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Stripe Workflow

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive payment pages.

Responsive tables.

Responsive cards.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Patient authentication.

Admin authentication.

Doctor authentication.

Route protection.

CSRF.

Validation.

Secure Stripe integration.

Secure AJAX requests.

Protect transaction information.

---

# DATABASE

Reuse appointments.

Reuse patients.

Create payment structure.

Support future insurance integration.

Avoid duplicate architecture.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Provincial Insurance

Refund Workflow

Invoices

Analytics

Reports

Email Notifications

SMS Notifications

Business Intelligence

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 19:

✅ Stripe Payment Integration

✅ Payment Summary

✅ Payment History

✅ Payment Status

✅ Admin Payment Management

✅ Patient Payment Management

✅ Transaction Details

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Insurance Ready Architecture

Build ONLY the Stripe Payment Integration module.

Stop after Phase 19 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Provincial Insurance
* Refunds
* Invoices
* Reports
* Analytics

without major refactoring.
# PHASE 20 – PROVINCIAL INSURANCE MANAGEMENT

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing appointment and payment architecture.
* Implement ONLY Phase 20.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Provincial Insurance Management module.

Reuse existing appointments.

Reuse patients.

Reuse payments.

Do NOT build external insurance API integration.

Do NOT build automatic verification.

---

# PATIENT PANEL

Patient can:

Select Insurance Payment Option

Enter Insurance Number

View Insurance Status

View Submitted Insurance Requests

AJAX operations only.

---

# INSURANCE INFORMATION

Support:

Patient

Appointment

Insurance Number

Insurance Provider Placeholder

Submission Date

Status

Notes Placeholder

---

# INSURANCE STATUS

Support:

Pending

Approved

Rejected

Cancelled

Keep workflow simple.

---

# INSURANCE FLOW

Appointment

↓

Insurance Selected

↓

Insurance Number Submitted

↓

Pending Review

↓

Admin Review

↓

Approved / Rejected

---

# ADMIN PANEL

Admin can:

View Insurance Requests

View Details

Approve

Reject

Search

Filter

Add Review Notes

AJAX operations.

---

# DOCTOR PANEL

Doctor can:

View Insurance Status Placeholder

No insurance management.

---

# INSURANCE DETAILS

Display:

Patient

Appointment

Insurance Number

Submission Date

Status

Admin Notes

---

# SEARCH

AJAX Search.

Support:

Patient

Insurance Number

Status

Date

---

# FILTERS

Status

Date

Patient

---

# PLACEHOLDER

Prepare architecture for:

Insurance API

Claim Processing

Reports

Analytics

Future Integrations

---

# SHARED COMPONENTS

Create:

Insurance Card

Insurance Request Card

Status Badge

Search Box

Filter Box

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Submit

Approve

Reject

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Insurance Forms

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive forms.

Responsive tables.

Responsive cards.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Patient authentication.

Admin authentication.

Doctor authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

Protect insurance information.

---

# DATABASE

Reuse:

Patients

Appointments

Payments

Create insurance request structure only.

Support future API integration.

Avoid duplicate architecture.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Insurance API

Automatic Verification

Claim Settlement

Stripe Refunds

Analytics

Reports

Email Notifications

SMS Notifications

Business Intelligence

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 20:

✅ Insurance Selection

✅ Insurance Number Submission

✅ Insurance Request Management

✅ Admin Insurance Review

✅ Insurance Status

✅ Patient Insurance Tracking

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Insurance API Ready Architecture

Build ONLY the Provincial Insurance Management module.

Stop after Phase 20 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Insurance APIs
* Claim Processing
* Reports
* Analytics
* Future Government Verification Systems

without major refactoring.
# PHASE 21 – NOTIFICATION MANAGEMENT SYSTEM

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing modules.
* Implement ONLY Phase 21.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Notification Management System.

Create a centralized notification architecture.

Do NOT integrate actual Email providers.

Do NOT integrate actual SMS providers.

---

# NOTIFICATION TYPES

Support:

System Notification

Appointment Notification

Payment Notification

Insurance Notification

Prescription Notification

Telemedicine Notification

General Notification

---

# RECIPIENTS

Support:

Admin

Doctor

Patient

---

# NOTIFICATION STATUS

Support:

Unread

Read

Archived

---

# NOTIFICATION EVENTS

Prepare support for:

Registration

Doctor Approval

Appointment Submission

Appointment Approval

Appointment Rejection

Doctor Assignment

Payment Confirmation

Insurance Update

Prescription Ready

Meeting Ready

Cancellation

Reschedule

Reminder Placeholder

---

# ADMIN PANEL

Admin can:

View Notifications

Search

Filter

Mark Read

Mark Unread

Archive

View Details

---

# DOCTOR PANEL

Doctor can:

View Notifications

Read Notifications

Archive

View Details

---

# PATIENT PANEL

Patient can:

View Notifications

Read Notifications

Archive

View Details

---

# NOTIFICATION DETAILS

Display:

Title

Message

Type

Recipient

Status

Created Date

Associated Module Placeholder

---

# SEARCH

AJAX Search.

Support:

Recipient

Type

Status

Date

---

# FILTERS

Type

Status

Recipient

Date

---

# PLACEHOLDER

Prepare architecture for:

Email

SMS

Push Notifications

WhatsApp

Reminder Engine

Reports

Analytics

---

# SHARED COMPONENTS

Create:

Notification Card

Notification List

Status Badge

Search Box

Filter Box

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Read

Unread

Archive

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Notifications

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive UI.

Responsive notification lists.

Responsive cards.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication.

Doctor authentication.

Patient authentication.

Route protection.

CSRF.

Validation.

Secure AJAX requests.

Users should only access their own notifications.

---

# DATABASE

Reuse:

Appointments

Payments

Insurance

Prescriptions

Meetings

Create notification structure only.

Avoid duplicate architecture.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

SMTP Integration

SMS Gateway

WhatsApp

Push Notifications

Reminder Scheduler

Reports

Analytics

Business Intelligence

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 21:

✅ Notification Center

✅ Admin Notifications

✅ Doctor Notifications

✅ Patient Notifications

✅ Notification Status

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Email & SMS Ready Architecture

Build ONLY the Notification Management System.

Stop after Phase 21 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Email Notifications
* SMS Notifications
* WhatsApp
* Push Notifications
* Reminder Scheduler
* Reports
* Analytics

without major refactoring.
# PHASE 22 – DASHBOARD ANALYTICS & REPORTING

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing modules.
* Implement ONLY Phase 22.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Dashboard Analytics and Reporting module.

Reuse existing system data.

Do NOT build Business Intelligence.

Do NOT build PDF exports.

---

# ADMIN DASHBOARD

Display:

Total Patients

Total Doctors

Today's Appointments

Pending Reviews

Clinic Appointments

Telemedicine Appointments

Revenue Summary

Insurance Cases

Recent Activities

Quick Actions

---

# DOCTOR DASHBOARD

Display:

Upcoming Appointments

Today's Consultations

Telemedicine Sessions

Pending Notes

Completed Consultations

Recent Activity

Quick Actions

---

# PATIENT DASHBOARD

Display:

Upcoming Appointments

Consultation History

Prescriptions

Notifications

Recent Activity

Quick Actions

---

# DASHBOARD CARDS

Create reusable cards.

Support:

Title

Value

Icon Placeholder

Status Placeholder

Trend Placeholder

Future analytics ready.

---

# RECENT ACTIVITIES

Display recent system activities.

Reuse existing modules.

---

# QUICK ACTIONS

Create reusable quick actions.

Maintain panel consistency.

---

# REPORTING

Create basic reporting views.

Support:

Appointments

Payments

Insurance

Prescriptions

Consultations

Use existing data.

---

# SEARCH

AJAX Search.

Support:

Reports

Activities

Dashboard Data

---

# FILTERS

Date

Appointment Type

Status

User Type

---

# PLACEHOLDER

Prepare architecture for:

Advanced Reports

Charts

Analytics

Export

Business Intelligence

---

# SHARED COMPONENTS

Create:

Dashboard Card

Analytics Card

Activity Card

Report Card

Status Badge

Search Box

Filter Box

Information Card

Empty State

Loading Spinner

Skeleton Loader

Toast

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Refresh

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Dashboard Refresh

Search

Filters

Loading

Toast

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive dashboards.

Responsive cards.

Responsive reports.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication.

Doctor authentication.

Patient authentication.

Route protection.

Users should only access their own dashboard data.

---

# DATABASE

Reuse all existing modules.

Do not duplicate records.

Generate dashboard data from existing structures.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

PDF Export

Excel Export

Advanced Charts

Business Intelligence

Email Reports

SMS Reports

Advanced Analytics

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 22:

✅ Admin Dashboard Analytics

✅ Doctor Dashboard Analytics

✅ Patient Dashboard Analytics

✅ Dashboard Widgets

✅ Basic Reporting

✅ Recent Activities

✅ Quick Actions

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Analytics Ready Architecture

Build ONLY the Dashboard Analytics & Reporting module.

Stop after Phase 22 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Advanced Reports
* PDF Export
* Excel Export
* Charts
* Business Intelligence
* Advanced Analytics

without major refactoring.
# PHASE 23 – EMAIL, SMS & REMINDER DELIVERY SYSTEM

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing Notification architecture.
* Implement ONLY Phase 23.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Queue-ready architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build Email, SMS and Reminder delivery infrastructure.

Reuse Notification Center.

Reuse Appointments.

Reuse Payments.

Reuse Insurance.

Do not duplicate notification logic.

---

# EMAIL EVENTS

Support:

Registration

Doctor Approval

Appointment Submission

Appointment Approval

Appointment Rejection

Doctor Assignment

Payment Confirmation

Insurance Update

Prescription Ready

Telemedicine Meeting Ready

Appointment Cancellation

Appointment Reschedule

24 Hour Reminder

1 Hour Reminder

---

# SMS EVENTS

Support same events.

Keep architecture reusable.

---

# REMINDERS

Support:

24 Hour Reminder

1 Hour Reminder

Future reminder expansion ready.

---

# ADMIN PANEL

Create Notification Delivery Management.

Admin can:

View Delivery Logs

View Status

Search

Filter

Retry Failed Placeholder

View Details

---

# DOCTOR PANEL

Doctor can:

View Email/SMS History Placeholder

View Reminder Status

---

# PATIENT PANEL

Patient can:

View Reminder History Placeholder

View Delivery Status Placeholder

---

# DELIVERY STATUS

Support:

Pending

Queued

Sent

Delivered Placeholder

Failed

Cancelled

---

# DELIVERY DETAILS

Display:

Recipient

Channel

Event

Status

Date

Associated Module

---

# SEARCH

AJAX Search.

Support:

Recipient

Event

Status

Date

Channel

---

# FILTERS

Status

Channel

Event

Date

---

# PLACEHOLDER

Prepare architecture for:

WhatsApp

Push Notifications

Mobile Apps

Advanced Reminder Rules

Analytics

---

# SHARED COMPONENTS

Create:

Delivery Card

Reminder Card

Status Badge

Search Box

Filter Box

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Search

Filter

Retry Placeholder

Refresh

Validation

Loading

Success

Error

No page reload.

---

# QUEUE ARCHITECTURE

Prepare queue-based delivery.

Support failed job retry architecture.

Future scaling ready.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Search

Filters

Refresh

Loading

Toast

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive UI.

Responsive tables.

Responsive cards.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication.

Doctor authentication.

Patient authentication.

Route protection.

Protect notification history.

Secure delivery logs.

---

# DATABASE

Reuse:

Notifications

Appointments

Payments

Insurance

Meetings

Prescriptions

Create delivery log structure only.

Avoid duplicate architecture.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

WhatsApp Integration

Push Notifications

Mobile Notification SDK

Advanced Analytics

Marketing Messages

Business Intelligence

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 23:

✅ Email Delivery Architecture

✅ SMS Delivery Architecture

✅ Reminder System

✅ 24 Hour Reminder

✅ 1 Hour Reminder

✅ Delivery Logs

✅ Admin Delivery Management

✅ Queue Foundation

✅ Search

✅ Filters

✅ AJAX Operations

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future WhatsApp & Push Ready Architecture

Build ONLY the Email, SMS & Reminder Delivery System.

Stop after Phase 23 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* WhatsApp
* Push Notifications
* Mobile Apps
* Advanced Reminder Rules
* Analytics

without major refactoring.
# PHASE 24 – APPOINTMENT LIFECYCLE & STATUS MANAGEMENT

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing appointment modules.
* Implement ONLY Phase 24.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Appointment Lifecycle and Status Management module.

Reuse all existing appointment functionality.

Centralize appointment state transitions.

Do not duplicate booking logic.

---

# APPOINTMENT STATUS

Support:

Pending Payment

Pending Review

Approved

Rejected

Doctor Assigned

Teams Scheduled

Scheduled

Cancelled

Rescheduled

In Consultation

Completed

No Show

---

# STATUS WORKFLOW

Manage valid status transitions.

Prevent invalid updates.

Maintain consistency.

---

# ADMIN PANEL

Admin can:

View Status History

Update Status

Cancel Appointment

Reschedule Appointment

Mark No Show

Search

Filter

View Timeline

---

# DOCTOR PANEL

Doctor can:

View Appointment Status

Update Consultation Status

Mark Completed

Mark No Show

View Timeline

---

# PATIENT PANEL

Patient can:

View Appointment Status

View Timeline

View Reschedule Information

View Cancellation Information

---

# STATUS HISTORY

Maintain appointment history.

Display:

Previous Status

New Status

Updated By

Date

Reason Placeholder

---

# RESCHEDULE

Support:

New Date

New Time

Status Update

Timeline Update

Reuse existing slots.

---

# CANCELLATION

Support:

Cancellation Status

Reason Placeholder

Timeline Update

---

# NO SHOW

Support:

Doctor No Show Placeholder

Patient No Show

Status Update

History Update

---

# SEARCH

AJAX Search.

Support:

Patient

Doctor

Appointment

Status

Date

---

# FILTERS

Status

Appointment Type

Doctor

Patient

Date

---

# PLACEHOLDER

Prepare architecture for:

Refund Workflow

Advanced Scheduling

Analytics

Future Policies

---

# SHARED COMPONENTS

Create:

Status Timeline

Appointment Timeline

Status Badge

Search Box

Filter Box

Information Card

Activity Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Status Update

Cancel

Reschedule

No Show

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Status Updates

Timeline

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive UI.

Responsive timelines.

Responsive tables.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication.

Doctor authentication.

Patient authentication.

Route protection.

Secure AJAX requests.

Protect appointment history.

---

# DATABASE

Reuse existing appointments.

Reuse existing status structures.

Create status history relationships only where required.

Avoid duplicate architecture.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

New Booking System

Stripe Refunds

Insurance Claims

Advanced Scheduling Engine

Analytics

Reports

Business Intelligence

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 24:

✅ Appointment Lifecycle

✅ Status Management

✅ Status Timeline

✅ Reschedule Management

✅ Cancellation Management

✅ No Show Management

✅ Admin Controls

✅ Doctor Controls

✅ Patient Status Tracking

✅ Search

✅ Filters

✅ AJAX Operations

✅ Responsive UI

✅ Premium Healthcare SaaS Design

Build ONLY the Appointment Lifecycle & Status Management module.

Stop after Phase 24 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Refund Policies
* Advanced Scheduling
* Analytics
* Future Appointment Policies

without major refactoring.
# PHASE 25 – AUDIT LOGS & ACTIVITY TRACKING

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing modules.
* Implement ONLY Phase 25.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Audit Log and Activity Tracking module.

Create centralized activity history.

Reuse existing modules.

Do not duplicate business logic.

---

# AUDIT EVENTS

Track important system actions.

Examples:

Login

Logout

Doctor Registration

Doctor Approval

Patient Registration

Appointment Booking

Appointment Approval

Doctor Assignment

Teams Meeting Creation

Consultation Completion

Prescription Creation

Payment Status Update

Insurance Review

Status Changes

Profile Updates

Settings Updates

---

# USER TYPES

Support:

Admin

Doctor

Patient

---

# AUDIT DETAILS

Store:

User

Action

Module

Reference

Date

Status Placeholder

Description

---

# ADMIN PANEL

Admin can:

View Audit Logs

Search

Filter

View Details

Activity Timeline

---

# DOCTOR PANEL

Doctor can:

View Own Activity History

---

# PATIENT PANEL

Patient can:

View Own Activity History Placeholder

---

# ACTIVITY TIMELINE

Display:

Action

User

Module

Date

Description

---

# SEARCH

AJAX Search.

Support:

User

Module

Action

Date

---

# FILTERS

User Type

Module

Action

Date

---

# PLACEHOLDER

Prepare architecture for:

Compliance Reports

Analytics

Security Alerts

Future Monitoring

---

# SHARED COMPONENTS

Create:

Audit Card

Timeline Card

Activity Card

Status Badge

Search Box

Filter Box

Information Card

Empty State

Loading Spinner

Skeleton Loader

Toast

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Search

Filter

Refresh

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Search

Filters

Refresh

Loading

Toast

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive UI.

Responsive tables.

Responsive timelines.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication.

Doctor authentication.

Patient authentication.

Route protection.

Secure activity access.

Users should only see authorized logs.

---

# DATABASE

Reuse existing modules.

Create centralized audit structure.

Avoid duplicate records.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Advanced Analytics

Business Intelligence

Employee Monitoring

Security AI

Compliance Engine

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 25:

✅ Audit Logging

✅ Activity Tracking

✅ Admin Audit Center

✅ Doctor Activity History

✅ Patient Activity History

✅ Activity Timeline

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Compliance Ready Architecture

Build ONLY the Audit Logs & Activity Tracking module.

Stop after Phase 25 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Compliance Reports
* Security Monitoring
* Analytics
* Future Healthcare Regulations

without major refactoring.
# PHASE 26 – SYSTEM BACKUP & RECOVERY MANAGEMENT

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing modules.
* Implement ONLY Phase 26.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the System Backup and Recovery Management module.

Support PRD backup requirements.

Create backup monitoring architecture.

Do not duplicate existing data.

---

# BACKUP TYPES

Support:

Database Backup

System Backup Placeholder

Configuration Backup Placeholder

---

# BACKUP STATUS

Support:

Pending

Running

Completed

Failed

---

# BACKUP HISTORY

Store:

Backup Type

Status

Date

File Placeholder

Size Placeholder

Duration Placeholder

---

# ADMIN PANEL

Admin can:

View Backup History

View Backup Status

Search

Filter

View Details

Manual Backup Placeholder

---

# BACKUP DETAILS

Display:

Backup Type

Status

Date

Duration

File Information Placeholder

Notes Placeholder

---

# SEARCH

AJAX Search.

Support:

Backup Type

Status

Date

---

# FILTERS

Status

Type

Date

---

# SCHEDULE

Prepare architecture for:

Daily Database Backup

Future automatic scheduling

---

# PLACEHOLDER

Prepare architecture for:

Cloud Storage

Remote Backup

Disaster Recovery

Restore Operations

Backup Verification

---

# SHARED COMPONENTS

Create:

Backup Card

Backup History Card

Status Badge

Search Box

Filter Box

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Search

Filter

Refresh

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Search

Filters

Refresh

Loading

Toast

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive UI.

Responsive tables.

Responsive cards.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication required.

Route protection.

Secure backup information.

Protect backup history.

---

# DATABASE

Reuse existing structures.

Create backup history structure only where required.

Avoid duplicate architecture.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

Cloud Backup Providers

Automatic Restore

Disaster Recovery Automation

Remote Storage

Advanced Monitoring

Business Analytics

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 26:

✅ Backup Management

✅ Backup History

✅ Backup Status

✅ Admin Backup Center

✅ Daily Backup Architecture

✅ Search

✅ Filters

✅ AJAX Operations

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Disaster Recovery Ready Architecture

Build ONLY the System Backup & Recovery Management module.

Stop after Phase 26 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Cloud Backups
* Remote Storage
* Restore Operations
* Disaster Recovery
* Backup Verification

without major refactoring.
# PHASE 27 – DOCTOR SELF REGISTRATION & APPROVAL WORKFLOW

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing Doctor Management.
* Implement ONLY Phase 27.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the Doctor Self Registration and Approval Workflow.

Reuse Doctor Management.

Do not duplicate doctor records.

---

# DOCTOR REGISTRATION

Doctor can:

Register

Submit Profile

Submit Professional Information

Upload Required Information Placeholder

Track Registration Status

---

# REGISTRATION INFORMATION

Support:

Full Name

Email

Phone

Medical License Number

Qualification

Years of Experience

Specialization

Password

---

# REGISTRATION STATUS

Support:

Pending

Approved

Rejected

---

# DOCTOR PANEL

Doctor can:

View Registration Status

Update Pending Information Placeholder

View Approval Status

---

# ADMIN PANEL

Admin can:

View Registration Requests

Approve

Reject

Search

Filter

View Details

---

# APPROVAL

Support:

Approve

Reject

Status History Placeholder

Review Notes Placeholder

---

# SEARCH

AJAX Search.

Support:

Doctor

License Number

Status

Date

---

# FILTERS

Status

Specialization

Date

---

# PLACEHOLDER

Prepare architecture for:

Document Verification

External Verification

Future Licensing APIs

---

# SHARED COMPONENTS

Create:

Registration Card

Approval Card

Status Badge

Search Box

Filter Box

Information Card

Timeline Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Register

Approve

Reject

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Registration

Approval

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive UI.

Responsive forms.

Responsive tables.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Doctor authentication.

Admin authentication.

Route protection.

Secure AJAX requests.

Protect registration information.

---

# DATABASE

Reuse existing doctor structures.

Avoid duplicate records.

Create only required workflow relationships.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

External License Verification

Government APIs

Advanced Background Checks

Business Analytics

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 27:

✅ Doctor Self Registration

✅ Registration Status

✅ Admin Approval Workflow

✅ Admin Rejection Workflow

✅ Registration Tracking

✅ Search

✅ Filters

✅ AJAX Operations

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Verification Ready Architecture

Build ONLY the Doctor Self Registration & Approval Workflow.

Stop after Phase 27 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* License Verification
* External APIs
* Document Verification
* Healthcare Compliance

without major refactoring.
# PHASE 28 – SYSTEM CONFIGURATION & MASTER SETTINGS

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing Admin Settings.
* Implement ONLY Phase 28.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Build the System Configuration and Master Settings module.

Reuse existing Admin Settings.

Centralize configurable options.

Do not duplicate settings logic.

---

# GENERAL SETTINGS

Support:

System Name

System Email Placeholder

System Phone Placeholder

Timezone

Default Language Placeholder

Currency Placeholder

---

# APPOINTMENT SETTINGS

Support:

Default Appointment Status Placeholder

Future Booking Rules Placeholder

Cancellation Placeholder

Reschedule Placeholder

---

# TELEMEDICINE SETTINGS

Support:

Microsoft Teams Placeholder

Meeting Rules Placeholder

Future Recording Placeholder

---

# PAYMENT SETTINGS

Support:

Stripe Placeholder

Insurance Placeholder

Future Refund Placeholder

---

# NOTIFICATION SETTINGS

Support:

Email Placeholder

SMS Placeholder

Reminder Placeholder

Future WhatsApp Placeholder

---

# DOCTOR SETTINGS

Support:

Approval Placeholder

Registration Placeholder

Future Verification Placeholder

---

# ADMIN PANEL

Admin can:

View Settings

Update Settings

Search

Filter

View Sections

AJAX operations.

---

# SEARCH

AJAX Search.

Support:

Setting Name

Section

---

# FILTERS

Section

Status Placeholder

---

# PLACEHOLDER

Prepare architecture for:

Future Integrations

External APIs

Advanced Rules

Compliance

---

# SHARED COMPONENTS

Create:

Settings Card

Configuration Card

Status Badge

Search Box

Filter Box

Information Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Update

Search

Filter

Validation

Loading

Success

Error

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Settings

Search

Filters

Loading

Toast

Confirmation Dialog

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Responsive settings UI.

Responsive cards.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Admin authentication required.

Route protection.

Secure AJAX requests.

Protect system configuration.

---

# DATABASE

Reuse existing settings architecture.

Avoid duplicate structures.

Create only required configuration relationships.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

Avoid Duplication.

---

# DO NOT BUILD

External APIs

Refund Engine

WhatsApp Integration

Business Analytics

Advanced Compliance

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 28:

✅ System Configuration

✅ Master Settings

✅ Appointment Settings

✅ Telemedicine Settings

✅ Payment Settings

✅ Notification Settings

✅ Doctor Settings

✅ Search

✅ Filters

✅ AJAX Operations

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ Future Integration Ready Architecture

Build ONLY the System Configuration & Master Settings module.

Stop after Phase 28 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* External APIs
* WhatsApp
* Refund Policies
* Compliance Rules
* Future Healthcare Integrations

without major refactoring.
# PHASE 29 – PERFORMANCE, CONCURRENT BOOKING & SYSTEM RELIABILITY

## ROLE

You are a Senior Laravel Architect and Senior Full Stack Developer.

Continue from previous phases.

Before making changes:

* Analyze the existing project.
* Maintain compatibility with previous phases.
* Never break existing functionality.
* Reuse existing appointment architecture.
* Implement ONLY Phase 29.

---

# PROJECT STANDARDS

Continue using:

Laravel

Blade

Tailwind CSS CDN

Pure Vanilla JavaScript

AJAX-first architecture

Queue-ready architecture

Responsive UI

Reusable components

Premium healthcare SaaS design

---

# OBJECTIVE

Improve system performance and reliability.

Support concurrent appointment bookings.

Protect system data consistency.

Reuse existing modules.

Do not duplicate business logic.

---

# CONCURRENT BOOKINGS

Protect appointment booking process.

Support:

Simultaneous booking requests

Slot validation

Race condition prevention

Duplicate booking prevention

Transaction safety

Reuse existing appointment and slot modules.

---

# APPOINTMENT VALIDATION

Ensure:

Doctor availability

Time slot availability

Appointment status consistency

Payment consistency placeholder

Insurance consistency placeholder

---

# RELIABILITY

Support:

Queue architecture reuse

Failed job placeholder

Retry placeholder

Transaction logging placeholder

Graceful error handling

---

# PERFORMANCE

Optimize:

Appointment queries

Dashboard queries

Patient records

Doctor schedules

Notification loading

Search operations

---

# ADMIN PANEL

Admin can:

View System Health Placeholder

View Booking Conflicts Placeholder

View Queue Status Placeholder

Search

Filter

---

# DOCTOR PANEL

Doctor experience should remain responsive.

Reuse existing modules.

No additional business workflow.

---

# PATIENT PANEL

Prevent:

Duplicate appointment submissions

Multiple payment submissions

Invalid booking attempts

AJAX validation only.

---

# SYSTEM VALIDATION

Support:

Duplicate prevention

Concurrent request handling

Data integrity

Safe updates

Consistent status transitions

---

# SEARCH

AJAX Search.

Support:

Booking Status

System Events Placeholder

Date

---

# FILTERS

Status

Module

Date

---

# PLACEHOLDER

Prepare architecture for:

Advanced Monitoring

Queue Dashboard

Performance Metrics

System Analytics

Scaling

---

# SHARED COMPONENTS

Create:

System Status Card

Performance Card

Status Badge

Search Box

Filter Box

Information Card

Empty State

Loading Spinner

Skeleton Loader

Toast

Confirmation Dialog

---

# AJAX

ALL OPERATIONS MUST USE AJAX.

Validation

Search

Filter

Refresh

Loading

Success

Error

Prevent duplicate submissions.

No page reload.

---

# JAVASCRIPT

Pure Vanilla JS.

Handle:

AJAX

Duplicate prevention

Loading states

Search

Filters

Toast

Reusable Helpers

---

# RESPONSIVE

Desktop

Laptop

Tablet

Mobile

Small Mobile

Maintain responsive experience.

---

# UI

Premium healthcare SaaS.

Modern.

Professional.

Minimal.

Maintain consistency with previous phases.

---

# SECURITY

Protect concurrent updates.

Secure AJAX requests.

Maintain transaction integrity.

Protect critical booking operations.

---

# DATABASE

Reuse existing structures.

Use safe transaction architecture.

Avoid duplicate records.

Maintain consistency.

---

# CODE QUALITY

Laravel Best Practices

SOLID Principles

Reusable Code

Maintainable Structure

Scalable Architecture

API-ready design

Avoid Duplication.

---

# DO NOT BUILD

New Appointment Module

New Payment Gateway

New Insurance System

Business Analytics

Advanced Monitoring Dashboards

Infrastructure-specific Scaling

Future workflows

---

# FINAL DELIVERABLE

At the end of Phase 29:

✅ Concurrent Booking Protection

✅ Duplicate Booking Prevention

✅ Slot Protection

✅ Transaction Safety

✅ System Reliability Improvements

✅ Performance Optimizations

✅ AJAX Validation

✅ Shared Components

✅ Responsive UI

✅ Premium Healthcare SaaS Design

✅ API-ready Architecture

Build ONLY the Performance, Concurrent Booking & System Reliability module.

Stop after Phase 29 is complete.

Do not implement future business modules.

## IMPORTANT FUTURE COMPATIBILITY

Design this module so future phases can directly integrate:

* Advanced Monitoring
* Queue Dashboards
* Performance Metrics
* Horizontal Scaling
* Future Mobile Applications

without major refactoring.
