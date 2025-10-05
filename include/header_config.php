<?php
// Header Configuration
$page_title = $page_title ?? 'MeCare - Hospital Management System';
$page_description = $page_description ?? 'Comprehensive hospital appointment management system';
$page_keywords = $page_keywords ?? 'hospital, appointments, management, healthcare';

// User Information
$user_name = '';
$user_type = '';
$user_avatar = './img/user.png';
$user_dashboard = '';

if (isset($_SESSION["student_id"])) {
    $user_type = 'student';
    $user_name = $firstname . ' ' . $lastname;
    $user_dashboard = 'dashboard.php';
    $user_avatar = $profile_image ?? './img/user.png';
} elseif (isset($_SESSION["doctor_id"])) {
    $user_type = 'doctor';
    $user_name = $firstname . ' ' . $lastname;
    $user_dashboard = 'dashboard.php';
    $user_avatar = $profile_image ?? './img/user.png';
} elseif (isset($_SESSION["admin_id"])) {
    $user_type = 'admin';
    $user_name = $fullname ?? 'Admin';
    $user_dashboard = 'dashboard.php';
    $user_avatar = './img/user.png';
}

// Navigation Items
$nav_items = [
    'student' => [
        ['label' => 'Dashboard', 'url' => 'dashboard.php', 'icon' => 'fas fa-columns'],
        ['label' => 'Appointments', 'url' => '#', 'icon' => 'fas fa-calendar', 'dropdown' => [
            ['label' => 'Book Appointment', 'url' => 'book-appointment.php', 'icon' => 'fas fa-calendar-plus'],
            ['label' => 'Appointment Status', 'url' => 'appointment-status.php', 'icon' => 'fas fa-info-circle'],
            ['label' => 'All Appointments', 'url' => 'all-appointments.php', 'icon' => 'fas fa-history']
        ]],
        ['label' => 'Feedback & Reports', 'url' => 'feedback.php', 'icon' => 'fas fa-comments'],
        ['label' => 'My Profile', 'url' => 'profile.php', 'icon' => 'fas fa-user']
    ],
    'doctor' => [
        ['label' => 'Dashboard', 'url' => 'dashboard.php', 'icon' => 'fas fa-columns'],
        ['label' => 'Appointments', 'url' => '#', 'icon' => 'fas fa-calendar', 'dropdown' => [
            ['label' => 'New Appointments', 'url' => 'new-appointments.php', 'icon' => 'fas fa-calendar-check'],
            ['label' => 'Approved Appointments', 'url' => 'approved-appointments.php', 'icon' => 'fas fa-check-circle'],
            ['label' => 'Cancelled Appointments', 'url' => 'cancelled-appointments.php', 'icon' => 'fas fa-times-circle'],
            ['label' => 'All Appointments', 'url' => 'all-appointments.php', 'icon' => 'fas fa-history']
        ]],
        ['label' => 'Feedback & Reports', 'url' => 'feedback.php', 'icon' => 'fas fa-comments'],
        ['label' => 'My Profile', 'url' => 'profile.php', 'icon' => 'fas fa-user']
    ],
    'admin' => [
        ['label' => 'Dashboard', 'url' => 'dashboard.php', 'icon' => 'fas fa-columns'],
        ['label' => 'Appointments', 'url' => '#', 'icon' => 'fas fa-calendar', 'dropdown' => [
            ['label' => 'New Appointments', 'url' => 'new-appointments.php', 'icon' => 'fas fa-calendar-check'],
            ['label' => 'Approved Appointments', 'url' => 'approved-appointments.php', 'icon' => 'fas fa-check-circle'],
            ['label' => 'Cancelled Appointments', 'url' => 'cancelled-appointments.php', 'icon' => 'fas fa-times-circle'],
            ['label' => 'All Appointments', 'url' => 'all-appointments.php', 'icon' => 'fas fa-history']
        ]],
        ['label' => 'Feedback & Reports', 'url' => 'feedback-management.php', 'icon' => 'fas fa-comments'],
        ['label' => 'Doctors', 'url' => '#', 'icon' => 'fas fa-user-md', 'dropdown' => [
            ['label' => 'Add Doctor', 'url' => 'add_doctor.php', 'icon' => 'fas fa-plus'],
            ['label' => 'View Doctors', 'url' => 'view_doctor.php', 'icon' => 'fas fa-users'],
            ['label' => 'Manage Doctors', 'url' => 'manage_doctors.php', 'icon' => 'fas fa-cogs']
        ]],
        ['label' => 'Patients', 'url' => 'patient.php', 'icon' => 'fas fa-users'],
        ['label' => 'My Profile', 'url' => 'profile.php', 'icon' => 'fas fa-user']
    ]
];

// Breadcrumb Generation
function generateBreadcrumbs($page_name = '') {
    $breadcrumbs = [];

    if (isset($_SESSION["student_id"])) {
        $breadcrumbs[] = ['label' => 'Student Portal', 'url' => 'dashboard.php'];
    } elseif (isset($_SESSION["doctor_id"])) {
        $breadcrumbs[] = ['label' => 'Doctor Portal', 'url' => 'dashboard.php'];
    } elseif (isset($_SESSION["admin_id"])) {
        $breadcrumbs[] = ['label' => 'Admin Portal', 'url' => 'dashboard.php'];
    }

    if (!empty($page_name)) {
        $breadcrumbs[] = ['label' => $page_name];
    }

    return $breadcrumbs;
}

// Page Header Info
function getPageHeader($current_page = '') {
    $headers = [
        'dashboard' => ['title' => 'Dashboard', 'icon' => 'fas fa-columns', 'description' => 'Overview of your activities'],
        'profile' => ['title' => 'My Profile', 'icon' => 'fas fa-user', 'description' => 'Manage your personal information'],
        'appointments' => ['title' => 'Appointments', 'icon' => 'fas fa-calendar', 'description' => 'Manage your appointments'],
        'feedback' => ['title' => 'Feedback & Reports', 'icon' => 'fas fa-comments', 'description' => 'Submit feedback and reports'],
        'book-appointment' => ['title' => 'Book Appointment', 'icon' => 'fas fa-calendar-plus', 'description' => 'Schedule a new appointment'],
        'appointment-status' => ['title' => 'Appointment Status', 'icon' => 'fas fa-info-circle', 'description' => 'Check your appointment status'],
        'all-appointments' => ['title' => 'All Appointments', 'icon' => 'fas fa-history', 'description' => 'View all your appointments'],
        'new-appointments' => ['title' => 'New Appointments', 'icon' => 'fas fa-calendar-check', 'description' => 'Review new appointment requests'],
        'approved-appointments' => ['title' => 'Approved Appointments', 'icon' => 'fas fa-check-circle', 'description' => 'View approved appointments'],
        'cancelled-appointments' => ['title' => 'Cancelled Appointments', 'icon' => 'fas fa-times-circle', 'description' => 'View cancelled appointments'],
        'feedback-management' => ['title' => 'Feedback Management', 'icon' => 'fas fa-comments', 'description' => 'Manage user feedback and reports'],
        'add_doctor' => ['title' => 'Add Doctor', 'icon' => 'fas fa-user-md', 'description' => 'Add new doctors to the system'],
        'view_doctor' => ['title' => 'View Doctors', 'icon' => 'fas fa-users', 'description' => 'Manage doctor information'],
        'patient' => ['title' => 'Patients', 'icon' => 'fas fa-users', 'description' => 'Manage patient information']
    ];

    return $headers[$current_page] ?? ['title' => 'MeCare', 'icon' => 'fas fa-home', 'description' => 'Hospital Management System'];
}
?>
