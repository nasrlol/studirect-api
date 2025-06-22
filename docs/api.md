# Studirect API Documentation

This documentation describes all available API endpoints for the Studirect platform, grouped by resource and function. Each endpoint includes the HTTP method, route, required authentication/authorization, parameters, and a brief description of its purpose.

---

## Authentication & Authorization

- **Students, companies, and admins authenticate via login endpoints.**
- **Sanctum tokens are used for session management.**
- **Some routes require specific abilities (`student`, `company`, `admin`).**
- **Some routes use signed URLs for verification and password resets.**
- **Rate limiting is applied via throttle middleware.**

---

## Table of Contents

1. [Student Endpoints](#student-endpoints)
2. [Company Endpoints](#company-endpoints)
3. [Admin Endpoints](#admin-endpoints)
4. [Logs](#logs)
5. [Appointments](#appointments)
6. [Connections](#connections)
7. [Authentication](#authentication)
8. [Password Reset](#password-reset)
9. [Messages](#messages)
10. [Skills](#skills)
11. [Diplomas](#diplomas)
12. [Skill Match](#skill-match)

---

## 1. Student Endpoints

### Register New Student
- **POST** `/students`
- **Body:** Student registration data
- **Auth:** None
- **Description:** Register a new student.

### Verify Student Email
- **GET** `/students/{id}/verify`
- **Auth:** Signed URL
- **Description:** Verify a student's email address.

### List Students
- **GET** `/students`
- **Auth:** `auth:sanctum`, `ability:student,admin`
- **Description:** Get a list of students.

### Get Student Detail
- **GET** `/students/{id}`
- **Auth:** `auth:sanctum`, `ability:student,admin`
- **Description:** Get details for a specific student.

### Update Student
- **PUT** `/students/{id}`
- **PATCH** `/students/{id}`
- **Auth:** `auth:sanctum`, `ability:student,admin`
- **Description:** Update all or part of a student's details.

### Delete Student
- **DELETE** `/students/{id}`
- **Auth:** `auth:sanctum`, `ability:student,admin`
- **Description:** Remove a student account.

---

## 2. Company Endpoints

### List Companies
- **GET** `/companies`
- **Auth:** `auth:sanctum`
- **Description:** List all companies.

### Register New Company
- **POST** `/companies`
- **Auth:** `auth:sanctum`, `ability:company,admin`
- **Description:** Register a new company.

### Get Company Detail
- **GET** `/companies/{id}`
- **Auth:** `auth:sanctum`, `ability:company,admin`
- **Description:** Get a company's details.

### Update Company
- **PUT** `/companies/{id}`
- **PATCH** `/companies/{id}`
- **Auth:** `auth:sanctum`, `ability:company,admin`
- **Description:** Update all or part of a company's details.

### Delete Company
- **DELETE** `/companies/{id}`
- **Auth:** `auth:sanctum`, `ability:company,admin`
- **Description:** Remove a company account.

---

## 3. Admin Endpoints

### List Admins
- **GET** `/admins`
- **Auth:** `auth:sanctum`, `ability:admin`
- **Description:** List all admins.

### Register New Admin
- **POST** `/admins`
- **Auth:** `auth:sanctum`, `ability:admin`
- **Description:** Register a new admin.

### Get Admin Detail
- **GET** `/admins/{id}`
- **Auth:** `auth:sanctum`, `ability:admin`
- **Description:** Get admin details.

### Update Admin
- **PUT** `/admins/{id}`
- **Auth:** `auth:sanctum`, `ability:admin`
- **Description:** Update admin details.

### Delete Admin
- **DELETE** `/admins/{id}`
- **Auth:** `auth:sanctum`, `ability:admin`
- **Description:** Remove an admin account.

---

## 4. Logs

- **GET** `/admin/logs`
  - List all logs (admin only)
- **GET** `/admin/logs/students/{id}`
  - Get logs for a specific student
- **GET** `/admin/logs/companies/{id}`
  - Get logs for a specific company
- **GET** `/admin/logs/admins/{id}`
  - Get logs for a specific admin
- **Auth:** `auth:sanctum`, `ability:admin`

---

## 5. Appointments

### List Appointments
- **GET** `/appointments`
- **Auth:** `auth:sanctum`
- **Description:** List all appointments.

### Create Appointment
- **POST** `/appointments`
- **Auth:** `auth:sanctum`
- **Description:** Create a new appointment.

### Get Appointment
- **GET** `/appointments/{id}`
- **Auth:** `auth:sanctum`
- **Description:** Get appointment details.

### Update Appointment
- **PUT** `/appointments/{id}`
- **Auth:** `auth:sanctum`
- **Description:** Update appointment details.

### Delete Appointment
- **DELETE** `/appointments/{id}`
- **Auth:** `auth:sanctum`
- **Description:** Delete an appointment.

---

## 6. Connections

### List Connections
- **GET** `/connections`
- **Auth:** `auth:sanctum`
- **Description:** List all connections.

### Create Connection
- **POST** `/connections`
- **Auth:** `auth:sanctum`
- **Description:** Create a new connection.

### Get Connection
- **GET** `/connections/{id}`
- **Auth:** `auth:sanctum`
- **Description:** Get details for a specific connection.

### Update Connection Time
- **PATCH** `/connections/{id}`
- **Auth:** `auth:sanctum`
- **Description:** Update only the time for a connection.

### Delete Connection
- **DELETE** `/connections/{id}`
- **Auth:** `auth:sanctum`
- **Description:** Delete a connection.

---

## 7. Authentication

### Student Login
- **POST** `/students/login`
- **Body:** `{ email, password }`
- **Throttle:** login
- **Description:** Login as student.

### Company Login
- **POST** `/companies/login`
- **Body:** `{ email, password }`
- **Throttle:** login
- **Description:** Login as company.

### Admin Login
- **POST** `/admins/login`
- **Body:** `{ email, password }`
- **Throttle:** login
- **Description:** Login as admin.

### Generic Login
- **POST** `/login`
- **Body:** `{ email, password }`
- **Throttle:** login
- **Description:** Login for any user type.

### Logout (Protected)
- **POST** `/students/logout`  
  `/companies/logout`  
  `/admins/logout`  
  `/logout`
- **Auth:** `auth:sanctum`
- **Description:** Logout for each user type or general.

---

## 8. Password Reset

### Send Password Reset Email
- **POST** `/students/{id}/reset/mail`
- **Auth:** Signed URL, `throttle:mail`
- **Description:** Send password reset mail to student.

### Reset Student Password
- **PATCH** `/students/{id}/reset`
- **Auth:** Signed URL
- **Description:** Reset student password.

---

## 9. Messages

### Send Message
- **POST** `/messages/send`
- **Body:** `{ sender_id, receiver_id, message }`
- **Description:** Send a message.

### Get Conversation
- **POST** `/messages/conversation`
- **Body:** `{ participant_one_id, participant_two_id }`
- **Description:** Get conversation between two participants.

---

## 10. Skills

### List Skills
- **GET** `/skills`
- **Description:** List all skills.

### Get Skill Detail
- **GET** `/skills/{id}`
- **Description:** Get a specific skill.

### Attach Skill to Student
- **POST** `/students/{id}/skills`
- **Description:** Attach a skill to a student.

### Remove Skill from Student
- **DELETE** `/students/{id}/skills/{skill_id}`
- **Description:** Remove a skill from a student.

### Get Student Skills
- **GET** `/students/{id}/skills`
- **Description:** List skills for a specific student.

### Attach Skill to Company
- **POST** `/companies/{id}/skills`
- **Description:** Attach a skill to a company.

### Remove Skill from Company
- **DELETE** `/companies/{id}/skills/{skill_id}`
- **Description:** Remove a skill from a company.

### Get Company Skills
- **GET** `/companies/{id}/skills`
- **Description:** List skills for a specific company.

---

## 11. Diplomas

### List Diplomas
- **GET** `/diplomas`
- **Description:** List all diplomas.

### Get Diploma Detail
- **GET** `/diplomas/{id}`
- **Description:** Get a specific diploma.

---

## 12. Skill Match

### Calculate Skill Match Percentage
- **GET** `/match/{student_id}/{company_id}`
- **Description:** Calculate and return the skill match percentage between a student and a company.

---

## Error Handling

- **401 Unauthorized:** Missing or invalid authentication token.
- **403 Forbidden:** Insufficient ability/role.
- **404 Not Found:** Resource does not exist.
- **422 Unprocessable Entity:** Validation error.

---

## Notes

- All endpoints return JSON.
- Use Bearer tokens for authenticated requests.
- Rate limiting is enforced on sensitive endpoints.
- For full request/response schemas, see the controllers or request validation files in the repository.

---

