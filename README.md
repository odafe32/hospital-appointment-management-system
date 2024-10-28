# **Hospital Appointment Management System**

## Overview

The **Hospital Appointment Management System** is a web-based solution designed to streamline the process of managing patient appointments for hospitals and clinics. This system allows administrators to schedule, modify, and cancel appointments efficiently, ensuring smooth communication between doctors and patients.

---

## **Features**

- **Admin Dashboard:** View and manage appointments, doctors, and patients.
- **Doctor Management:** Add, update, or remove doctor profiles.
- **Patient Registration:** Secure patient login and registration.
- **Appointment Scheduling:** Schedule, reschedule, or cancel appointments.
- **Appointment Status Updates:** Track appointments with statuses like `Pending`, `Completed`, and `Cancelled`.
- **Notifications:** Send notifications to patients and doctors about appointment changes.
- **Search & Filters:** Easy search for appointments by doctor, patient, date, or status.
- **Responsive Design:** Works on desktop, tablet, and mobile screens.

---

## **Technologies Used**

- **Frontend:** HTML, CSS, JavaScript, / Boostrap
- **Backend:** PHP /
- **Database:** MySQL
- **Authentication:** PHP Sessions or JWT-based authentication for secure login
- **Libraries:**

  - jQuery

---

## **System Requirements**

- **Server:** Apache/Nginx (XAMPP, WAMP for local development)
- **Database:** MySQL 8.x or higher
- **Browser:** Chrome, Firefox, Safari, Edge
- **PHP:** Version 7.4 or higher

---

## **Installation Guide**

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/your-repo/hospital-appointment-system.git
   cd hospital-appointment-system
   ```

   CREATE DATABASE hospital_management;
   USE hospital_management;

   $host = 'localhost';
   $user = 'root';
   $password = '';
   $database = 'hospital_management';

## **User Roles and Permissions**

- **Admin:**
  - Full access to manage appointments, doctors, and patients.
  - Can view reports and analytics on appointments.
- **Doctor:**
  - Can view their own appointments.
  - Update status of appointments (Completed, Cancelled).
- **Patient:**
  - Can schedule, reschedule, and cancel their own appointments.
  - Receive email notifications about appointment status.

---

## **Known Issues / Limitations**

- Limited to basic email notifications (SMTP configuration may vary).
- Appointment time slots may require additional validation to prevent conflicts.
- No payment integration for paid appointments (can be added later).

---

## **Future Enhancements**

- Add **SMS Notifications** for patients and doctors.
- Integrate a **Payment Gateway** for online consultation fees.
- Implement **Calendar View** for easy appointment tracking.
- Add **Reports and Analytics** for admin to monitor performance.
- Enable **Multi-language Support** for international usage.

---

## **Contributing**

If you'd like to contribute:

1. Fork the repository.
2. Create a feature branch:
   <pre class="!overflow-visible"><div class="contain-inline-size rounded-md border-[0.5px] border-token-border-medium relative bg-token-sidebar-surface-primary dark:bg-gray-950" bis_skin_checked="1"><div class="flex items-center text-token-text-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md h-9 bg-token-sidebar-surface-primary dark:bg-token-main-surface-secondary" bis_skin_checked="1">bash</div><div class="sticky top-9 md:top-[5.75rem]" bis_skin_checked="1"><div class="absolute bottom-0 right-2 flex h-9 items-center" bis_skin_checked="1"><div class="flex items-center rounded bg-token-sidebar-surface-primary px-2 font-sans text-xs text-token-text-secondary dark:bg-token-main-surface-secondary" bis_skin_checked="1"><span class="" data-state="closed"><button class="flex gap-1 items-center py-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm"><path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path></svg>Copy code</button></span></div></div></div><div class="overflow-y-auto p-4" dir="ltr" bis_skin_checked="1"><code class="!whitespace-pre hljs language-bash">git checkout -b feature-name
   </code></div></div></pre>
3. Commit your changes:
   <pre class="!overflow-visible"><div class="contain-inline-size rounded-md border-[0.5px] border-token-border-medium relative bg-token-sidebar-surface-primary dark:bg-gray-950" bis_skin_checked="1"><div class="flex items-center text-token-text-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md h-9 bg-token-sidebar-surface-primary dark:bg-token-main-surface-secondary" bis_skin_checked="1">bash</div><div class="sticky top-9 md:top-[5.75rem]" bis_skin_checked="1"><div class="absolute bottom-0 right-2 flex h-9 items-center" bis_skin_checked="1"><div class="flex items-center rounded bg-token-sidebar-surface-primary px-2 font-sans text-xs text-token-text-secondary dark:bg-token-main-surface-secondary" bis_skin_checked="1"><span class="" data-state="closed"><button class="flex gap-1 items-center py-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm"><path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path></svg>Copy code</button></span></div></div></div><div class="overflow-y-auto p-4" dir="ltr" bis_skin_checked="1"><code class="!whitespace-pre hljs language-bash">git commit -m "Add feature"
   </code></div></div></pre>
4. Push to the branch:
   <pre class="!overflow-visible"><div class="contain-inline-size rounded-md border-[0.5px] border-token-border-medium relative bg-token-sidebar-surface-primary dark:bg-gray-950" bis_skin_checked="1"><div class="flex items-center text-token-text-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md h-9 bg-token-sidebar-surface-primary dark:bg-token-main-surface-secondary" bis_skin_checked="1">bash</div><div class="sticky top-9 md:top-[5.75rem]" bis_skin_checked="1"><div class="absolute bottom-0 right-2 flex h-9 items-center" bis_skin_checked="1"><div class="flex items-center rounded bg-token-sidebar-surface-primary px-2 font-sans text-xs text-token-text-secondary dark:bg-token-main-surface-secondary" bis_skin_checked="1"><span class="" data-state="closed"><button class="flex gap-1 items-center py-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm"><path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path></svg>Copy code</button></span></div></div></div><div class="overflow-y-auto p-4" dir="ltr" bis_skin_checked="1"><code class="!whitespace-pre hljs language-bash">git push origin feature-name
   </code></div></div></pre>
5. Open a pull request on GitHub.

---

---

## **Contact**

For any queries or issues, feel free to contact:

- **Email:** [godfreyj.sule1gmail.com](godfreyj.sule1gmail.com)
- **Website:** [Hospital Appointment System]()
