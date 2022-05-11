<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
               
                <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button>

                <!-- <button type="button" class="nav-link ml-10" id="apps_modal_btn" data-toggle="modal" data-target="#appsModal"><i class="ik ik-grid"></i></button> -->
                
                <!-- <b style="font-size: 15px;"> ONLINE CAMPUS VOTING SYSTEM USING QR CODE FOR ASIATECH COLLEGE</b> -->
            </div>
            <div class="top-menu d-flex align-items-center">
                <div class="dropdown">
                   Welcome: <?php echo UserPersonName($_SESSION['personId']); ?>
                </div>                
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="img/user.jpg" alt=""></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="display_profile.php"><i class="ik ik-user dropdown-icon"></i> Profile</a>
                        <a class="dropdown-item" href="sign_out.php"><i class="ik ik-power dropdown-icon"></i> Logout</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>