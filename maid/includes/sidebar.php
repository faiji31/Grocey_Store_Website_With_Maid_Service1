<aside class="fixed top-0 left-0 h-full w-64 bg-gradient-to-b from-green-600 to-green-400 shadow-lg z-40 flex flex-col">
    <div class="flex flex-col items-center py-8 border-b border-green-300">
        <a href="dashboard.php?maidId=<?php echo isset($maidId) ? urlencode($maidId) : ''; ?>">
            <img class="w-16 h-16 rounded-full border-4 border-white shadow mb-2 object-cover" src="images/layout_img/user_img.jpg" alt="User" />
        </a>
        <div class="text-center">
            <?php
            if (isset($_GET['maidId'])) {
                $maidId = $_GET['maidId'];
                $sql = "SELECT Name, Email FROM tblmaid WHERE MaidId = :maidId";
                $query = $dbh->prepare($sql);
                $query->bindParam(':maidId', $maidId, PDO::PARAM_STR);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                if ($result) {
                    echo '<div class="text-white font-bold text-lg">' . htmlentities($result->Name) . '</div>';
                    echo '<div class="text-green-100 text-xs">' . htmlentities($result->Email) . '</div>';
                } else {
                    echo '<div class="text-white font-bold text-lg">Maid Not Found</div>';
                }
            } else {
                echo '<div class="text-white font-bold text-lg">No MaidId Provided</div>';
            }
            ?>
        </div>
    </div>
    <nav class="flex-1 px-4 py-6 overflow-y-auto">
        <h4 class="text-green-100 font-semibold mb-4 uppercase tracking-wider">General</h4>
        <ul class="space-y-2">
            <li>
                <a href="dashboard.php?maidId=<?php echo isset($maidId) ? urlencode($maidId) : ''; ?>" class="flex items-center px-3 py-2 rounded-lg text-white hover:bg-green-700 transition">
                    <svg class="w-5 h-5 mr-3 text-yellow-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 0v6m0 0H7m6 0h6"/></svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- Add more sidebar links here as needed -->
        </ul>
    </nav>
</aside>
<div class="w-64 flex-shrink-0"></div>
