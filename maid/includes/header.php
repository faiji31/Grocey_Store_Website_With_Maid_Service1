<div class="topbar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="full">
            <button type="button" id="sidebarCollapse" class="sidebar_toggle">
                <i class="fa fa-bars"></i>
            </button>
            <div class="logo_section">
                <a href="dashboard.php?maidId=<?php echo urlencode($_GET['maidId']); ?>">
                    <h3 style="color: white; padding-top: 20px; padding-left: 10px;">
                        Grocery Store and Maid Servicde Website
                    </h3>
                </a>
            </div>
            <div class="right_topbar">
                <div class="icon_info">
                    <ul class="user_profile_dd">
                        <li>
                            <?php
                            if (isset($_GET['maidId'])) {
                                $maidId = $_GET['maidId']; // Get MaidId from the URL
                                $sql = "SELECT * FROM tblmaid WHERE MaidId = :maidId";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':maidId', $maidId, PDO::PARAM_STR);
                                $query->execute();
                                $result = $query->fetch(PDO::FETCH_OBJ);

                                if ($result) {
                                    ?>
                                    <a class="dropdown-toggle" data-toggle="dropdown">
                                        <img class="img-responsive rounded-circle" src="images/layout_img/user_img.jpg" alt="#" />
                                        <span class="name_user"><?php echo htmlentities($result->Name); ?></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="profile.php?maidId=<?php echo urlencode($maidId); ?>">My Profile</a>
                                        <a class="dropdown-item" href="change-password.php?maidId=<?php echo urlencode($maidId); ?>">Settings</a>
                                        <a class="dropdown-item" href="logout.php"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                                    </div>
                                    <?php
                                } else {
                                    echo '<span class="name_user">Maid Not Found</span>';
                                }
                            } else {
                                echo '<span class="name_user">No MaidId Found</span>';
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
