<header class="fixed top-0 left-0 w-full z-50 bg-gradient-to-r from-green-600 to-green-400 shadow-lg">
    <div class="flex items-center justify-between px-6 py-3">
        <div class="flex items-center space-x-4">
            <button type="button" id="sidebarCollapse" class="text-white focus:outline-none text-2xl mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
            <a href="dashboard.php?maidId=<?php echo urlencode($_GET['maidId']); ?>" class="flex items-center">
                <span class="text-white text-xl md:text-2xl font-bold tracking-wide">Grocery Store & Maid Service</span>
            </a>
        </div>
        <div class="relative">
            <ul class="flex items-center space-x-4">
                <li class="relative group">
                    <?php
                    if (isset($_GET['maidId'])) {
                        $maidId = $_GET['maidId'];
                        $sql = "SELECT * FROM tblmaid WHERE MaidId = :maidId";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':maidId', $maidId, PDO::PARAM_STR);
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_OBJ);
                        if ($result) {
                    ?>
                        <button class="flex items-center focus:outline-none group-hover:opacity-80" id="userMenuBtn">
                            <img class="w-9 h-9 rounded-full border-2 border-white object-cover" src="images/layout_img/user_img.jpg" alt="#" />
                            <span class="ml-2 text-white font-semibold"><?php echo htmlentities($result->Name); ?></span>
                            <svg class="ml-1 w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg py-2 opacity-0 group-hover:opacity-100 transition pointer-events-none group-hover:pointer-events-auto">
                            <a class="block px-4 py-2 text-gray-700 hover:bg-green-100" href="profile.php?maidId=<?php echo urlencode($maidId); ?>">My Profile</a>
                            <a class="block px-4 py-2 text-gray-700 hover:bg-green-100" href="change-password.php?maidId=<?php echo urlencode($maidId); ?>">Settings</a>
                            <a class="block px-4 py-2 text-red-600 hover:bg-red-100" href="logout.php">Log Out <i class="fa fa-sign-out"></i></a>
                        </div>
                    <?php
                        } else {
                            echo '<span class="text-white font-semibold">Maid Not Found</span>';
                        }
                    } else {
                        echo '<span class="text-white font-semibold">No MaidId Found</span>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</header>
<div class="h-20"></div>
