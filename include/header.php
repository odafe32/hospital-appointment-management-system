<?php
// Include header configuration
require_once("header_config.php");

// Determine current page for breadcrumbs and active states
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Page header info
$page_header = getPageHeader($current_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $page_title; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="<?php echo $page_keywords; ?>" name="keywords">
    <meta content="<?php echo $page_description; ?>" name="description">

    <!-- Favicon -->
    <?php require_once("favicon.php"); ?>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- Custom Header Styles -->
    <style>
        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
        }
        .header-icon {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
        }
        .breadcrumb-custom {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            padding: 10px 20px;
            margin-bottom: 0;
        }
        .breadcrumb-item {
            color: rgba(255, 255, 255, 0.8);
        }
        .breadcrumb-item.active {
            color: white;
            font-weight: 600;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.5);
        }
        .sidebar-profile {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .sidebar-profile-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #667eea;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <!-- Logo -->
                <a href="<?php echo $user_dashboard; ?>" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary">MeCare</h3>
                </a>

                <!-- User Profile Section -->
                <div class="sidebar-profile text-center">
                    <div class="sidebar-profile-avatar">
                        <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                    </div>
                    <h6 class="mb-1"><?php echo $user_name; ?></h6>
                    <span class="badge bg-light text-dark"><?php echo ucfirst($user_type); ?></span>
                </div>

                <!-- Navigation Menu -->
                <div class="navbar-nav w-100">
                    <?php foreach ($nav_items[$user_type] as $item): ?>
                        <?php if (isset($item['dropdown'])): ?>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle <?php echo ($current_page == basename($item['url'], '.php')) ? 'active' : ''; ?>"
                                   data-bs-toggle="dropdown">
                                    <i class="<?php echo $item['icon']; ?> me-2"></i><?php echo $item['label']; ?>
                                </a>
                                <div class="dropdown-menu bg-transparent border-0">
                                    <?php foreach ($item['dropdown'] as $dropdown_item): ?>
                                        <a href="<?php echo $dropdown_item['url']; ?>"
                                           class="nav-item nav-link <?php echo ($current_page == basename($dropdown_item['url'], '.php')) ? 'active' : ''; ?>">
                                            <i class="<?php echo $dropdown_item['icon']; ?> me-2"></i><?php echo $dropdown_item['label']; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo $item['url']; ?>"
                               class="nav-item nav-link <?php echo ($current_page == basename($item['url'], '.php')) ? 'active' : ''; ?>">
                                <i class="<?php echo $item['icon']; ?> me-2"></i><?php echo $item['label']; ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <!-- Logout -->
                    <a href="#" onclick="logout()" class="nav-item nav-link mt-4">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="<?php echo $user_dashboard; ?>" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>

                <div class="navbar-nav align-items-center ms-auto">
                    <!-- Messages Dropdown -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Messages</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <?php if ($user_type == 'student'): ?>
                                <?php
                                $select_msg = mysqli_query($connect, "SELECT * FROM `appointment` WHERE student_id = " . $_SESSION["student_id"] . " ORDER BY appointment_date DESC LIMIT 3");
                                if (mysqli_num_rows($select_msg) > 0) {
                                    while ($fetch_msg = mysqli_fetch_assoc($select_msg)) {
                                        $appointment_id = $fetch_msg["appointment_id"];
                                        $appointment_status = $fetch_msg["appointment_status"];
                                        $appointment_date = date("d M Y", strtotime($fetch_msg["appointment_date"]));

                                        echo '
                                        <a href="appointment-status.php" class="dropdown-item">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-2">
                                                    <h6 class="fw-normal mb-0">' . $appointment_id . '</h6>
                                                    <small>' . $appointment_status . ' - ' . $appointment_date . '</small>
                                                </div>
                                            </div>
                                        </a>
                                        <hr class="dropdown-divider">
                                        ';
                                    }
                                } else {
                                    echo '<a href="#" class="dropdown-item">No recent appointments</a>';
                                }
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="<?php echo $user_avatar; ?>" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo $user_name; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="profile.php" class="dropdown-item">
                                <i class="fas fa-user me-2"></i>My Profile
                            </a>
                            <a href="#" onclick="logout()" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Page Header Start -->
            <div class="header-section">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="header-icon mb-3">
                                <i class="<?php echo $page_header['icon']; ?>"></i>
                            </div>
                            <h2 class="mb-2"><?php echo $page_header['title']; ?></h2>
                            <p class="mb-0"><?php echo $page_header['description']; ?></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-custom justify-content-end mb-0">
                                    <?php
                                    $breadcrumbs = generateBreadcrumbs($page_header['title']);
                                    foreach ($breadcrumbs as $index => $breadcrumb):
                                    ?>
                                        <li class="breadcrumb-item <?php echo ($index === count($breadcrumbs) - 1) ? 'active' : ''; ?>">
                                            <?php if ($index < count($breadcrumbs) - 1): ?>
                                                <a href="<?php echo $breadcrumb['url']; ?>"><?php echo $breadcrumb['label']; ?></a>
                                            <?php else: ?>
                                                <?php echo $breadcrumb['label']; ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page Header End -->