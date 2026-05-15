<?php
require_once '../config/db.php';
require_once '../config/session.php';
require_once 'student_layout.php';
requireExactRole('student');

$pdo = getDB();
$profile = getStudentProfile($pdo);
?>
<?php studentPageHead('Available Tasks'); ?>
<body class="student-portal">
<div class="student-layout">
    <?php renderStudentSidebar('tasks'); ?>
    <main class="student-main">
        <header class="student-topbar">
            <button class="student-menu-btn lg:hidden" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
            <div>
                <span class="student-eyebrow">Recommended work</span>
                <h1>Available Tasks</h1>
                <p>Browse active proof-of-work tasks and open the full brief before submitting.</p>
            </div>
            <a class="student-action d-none d-md-inline-flex" href="/dashboard/profile.php"><i class="fa-solid fa-user-gear"></i> Profile</a>
        </header>

        <section class="student-page-section">
            <div class="student-section-head">
                <div>
                    <span>Open assignments</span>
                    <h2>Choose a task</h2>
                </div>
                <i class="fa-solid fa-list-check"></i>
            </div>
            <div id="tasksList" class="row g-4"></div>
        </section>
    </main>
</div>