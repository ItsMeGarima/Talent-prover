<?php
require_once '../config/db.php';
require_once '../config/session.php';
require_once 'student_layout.php';
requireExactRole('student');

$pdo = getDB();
$profile = getStudentProfile($pdo);
$fields = [$profile['name'], $profile['email'], $profile['skills'], $profile['bio'], $profile['portfolio_link']];
$complete = (int)round((count(array_filter($fields)) / count($fields)) * 100);
$skillList = array_filter(array_map('trim', explode(',', $profile['skills'] ?: 'HTML, CSS, JavaScript')));
$avatar = !empty($profile['profile_image'])
    ? '<img src="' . htmlspecialchars($profile['profile_image']) . '" alt="Profile picture">'
    : htmlspecialchars(strtoupper(substr($profile['name'], 0, 1)));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard - TalentProve</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="student-portal">
<div class="student-layout">
    <?php renderStudentSidebar('overview'); ?>

    <main class="student-main">
        <header class="student-topbar">
            <button class="student-menu-btn lg:hidden" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
            <div class="student-topbar-profile">
                <div class="student-topbar-avatar"><?= $avatar ?></div>
                <div>
                    <span class="student-eyebrow">Student portal</span>
                    <h1>Welcome back, <?= htmlspecialchars($profile['name']) ?>! <span class="student-wave">👋</span></h1>
                    <p>Track tasks, submit proof of work, and follow your review status.</p>
                </div>
            </div>
            <div class="student-top-actions">
                <button class="student-notification-btn" type="button" onclick="openModal('notificationModal')" aria-label="View notifications">
                    <i class="fa-solid fa-bell"></i>
                    <span id="topNotificationCount">0</span>
                </button>
                <a class="student-action d-none d-md-inline-flex" href="/dashboard/tasks.php"><i class="fa-solid fa-magnifying-glass"></i> Find tasks</a>
            </div>
        </header>



        <section class="student-stat-grid">
            <div>
                <a class="student-stat-card student-stat-link emerald" href="/dashboard/tasks.php">
                    <i class="fa-solid fa-briefcase"></i>
                    <span>Open work</span>
                    <strong id="openTaskCount">--</strong>
                    <small>Tasks available to work on</small>
                    <em class="fa-regular fa-clipboard"></em>
                </a>
            </div>
            <div>
                <a class="student-stat-card student-stat-link amber" href="/dashboard/submissions.php">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Submissions</span>
                    <strong id="submissionCount">--</strong>
                    <small>Work submitted for review</small>
                    <em class="fa-regular fa-file-lines"></em>
                </a>
            </div>
            <div>
                <button class="student-stat-card student-stat-link blue" type="button" onclick="openModal('notificationModal')">
                    <i class="fa-solid fa-bell"></i>
                    <span>Notifications</span>
                    <strong id="notificationCount">--</strong>
                    <small>Unread notifications</small>
                    <em class="fa-regular fa-envelope-open"></em>
                </button>
            </div>
        </section>

        <section class="student-dashboard-grid">
            <div class="student-panel" id="tasks">
                <div class="student-panel-head">
                    <div>
                        <span>Handpicked tasks based on your skills</span>
                        <h2>Recommended Tasks</h2>
                    </div>
                    <a class="student-view-all" href="/dashboard/tasks.php">View all</a>
                </div>
                <div id="tasksList" class="student-recommended-list"></div>
            </div>
            <div class="student-dashboard-rail">
                <section id="submissions" class="student-panel">
                    <div class="student-panel-head">
                        <div>
                            <span>Latest review activity</span>
                            <h2>Recent Submissions</h2>
                        </div>
                        <a class="student-view-all" href="/dashboard/submissions.php">View all</a>
                    </div>
                    <div id="submissionsList" class="student-submission-list compact"></div>
                </section>

            </div>
        </section>
    </main>
</div>