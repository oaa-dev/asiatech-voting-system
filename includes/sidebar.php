<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="homepage.php">
            <!-- <div class="logo-img"> -->
               <!-- <img src="src/img/brand-white.svg" class="header-brand-img" alt="lavalite">  -->
            <!-- </div> -->
            <span class="text">Voting System</span>
        </a>
        <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>
    
    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-lavel"></div>
                <div class="nav-item">
                    <a href="homepage.php"><i class="ik ik-bar-chart-2"></i><span>Homepage</span></a>
                </div>
                <!-- <div class="nav-item">
                    <a href="pages/navbar.html"><i class="ik ik-menu"></i><span>Navigation</span> <span class="badge badge-success">New</span></a>
                </div> -->

                <?php if($_SESSION['userTypeId'] == 1){ ?>
                <div class="nav-item has-sub">
                    <a><i class="ik ik-users"></i><span>Account Management</span></a>
                    <div class="submenu-content">
                        <a href="create_account.php" class="menu-item">New Account</a>
                        <a href="display_admin.php" class="menu-item">Display Administrator</a>
                        <a href="display_staff.php" class="menu-item">Display Staff</a>
                        <a href="display_student.php" class="menu-item">Display Student</a>
                    </div>
                </div>
                <?php } ?>

                <?php if($_SESSION['userTypeId'] == 1){ ?>
                <div class="nav-item has-sub">
                    <a><i class="ik ik-settings"></i><span>College Program</span></a>
                    <div class="submenu-content">
                        <a href="create_college_program.php" class="menu-item">New Program</a>
                        <a href="display_college_program.php" class="menu-item">Display Program</a>
                    </div>
                </div>
                <?php } ?>

                <?php if($_SESSION['userTypeId'] == 1){ ?>
                <div class="nav-item has-sub">
                    <a><i class="ik ik-users"></i><span>Party List Management</span></a>
                    <div class="submenu-content">
                        <a href="create_party_list.php" class="menu-item">New Party List</a>
                        <a href="create_party_list_platform.php" class="menu-item">Party List Platform</a>
                    </div>
                </div>
                <?php } ?>

                <?php if($_SESSION['userTypeId'] == 1){ ?>
                <div class="nav-item has-sub">
                    <a><i class="ik ik-users"></i><span>Candidate Management</span></a>
                    <div class="submenu-content">
                        <a href="create_candidate_position.php" class="menu-item">Candidate Position</a>
                        <a href="create_candidate.php" class="menu-item">New Candidate</a>
                        <!-- <a href="read_candidate.php" class="menu-item">Display Candidate</a> -->
                    </div>
                </div>
                <?php } ?>

                <?php if($_SESSION['userTypeId'] == 1){ ?>
                <div class="nav-item has-sub">
                    <a><i class="ik ik-settings"></i><span>Voting Management</span></a>
                    <div class="submenu-content">
                        <a href="create_voting_program.php" class="menu-item">New Voting Program</a>
                        <a href="display_voting_program.php" class="menu-item">Display Voting Program</a>
                    </div>
                </div>
                <?php } ?>

                <?php if($_SESSION['userTypeId'] == 1 || $_SESSION['userTypeId'] == 2){ ?>
                <div class="nav-item has-sub">
                    <a><i class="ik ik-settings"></i><span>Filling of Candidacy</span></a>
                    <div class="submenu-content">
                        <a href="display_filling_of_candidacy.php" class="menu-item">View Candidacy</a>
                    </div>
                </div>
                <?php } ?>

                
                <?php if($_SESSION['userTypeId'] == 3){ ?>
                <div class="nav-item has-sub">
                    <a><i class="ik ik-settings"></i><span>Filling of Candidacy</span></a>
                    <div class="submenu-content">
                        <a href="create_filling_of_candidacy.php" class="menu-item">New Candidacy</a>
                    </div>
                </div>

                <div class="nav-item has-sub">
                    <a><i class="ik ik-settings"></i><span>Cast Your Vote</span></a>
                    <div class="submenu-content">
                        <a href="new_vote.php" class="menu-item">Vote Now !</a>
                        <a href="display_vote_statistics.php" class="menu-item">Vote Statistics</a>
                    </div>
                </div>
                <?php } ?>                    

                <?php if($_SESSION['userTypeId'] == 1){ ?>
                <div class="nav-item has-sub">
                    <a><i class="ik ik-settings"></i><span>Student Votes</span></a>
                    <div class="submenu-content">
                        <a href="display_vote.php" class="menu-item">Display Votes</a>
                    </div>
                </div>
                <?php } ?>                    
                
            </nav>
        </div>
    </div>
</div>