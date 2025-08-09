<nav id="sidebar">
    <div class="sidebar_blog_1">
        <div class="sidebar-header">
            <div class="logo_section">
                <a href="index.html">
                    <img class="logo_icon img-responsive" src="images/logo/logo_icon.png" alt="#" />
                </a>
            </div>
        </div>
        <div class="sidebar_user_info">
            <div class="icon_setting"></div>
            <div class="user_profle_side">
                <div class="user_img">
                    <img class="img-responsive" src="images/layout_img/user_img.jpg" alt="#" />
                </div>
                <div class="user_info">
                    <?php
                    if (isset($_GET['maidId'])) {
                        $maidId = $_GET['maidId']; // Retrieve MaidId from URL
                        $sql = "SELECT Name, Email FROM tblmaid WHERE MaidId = :maidId";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':maidId', $maidId, PDO::PARAM_STR);
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_OBJ);

                        if ($result) {
                            ?>
                            <h6><?php echo htmlentities($result->Name); ?></h6>
                            <p>
                                <span class="online_animation"></span>
                                <?php echo htmlentities($result->Email); ?>
                            </p>
                            <?php
                        } else {
                            echo '<h6>Maid Not Found</h6>';
                        }
                    } else {
                        echo '<h6>No MaidId Provided</h6>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar_blog_2">
        <h4>General</h4>
        <ul class="list-unstyled components">
            <li>
                <a href="dashboard.php?maidId=<?php echo urlencode($maidId); ?>">
                    <i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span>
                </a>
            </li>
            
                </ul>
            </li>
        </ul>
    </div>
</nav>
