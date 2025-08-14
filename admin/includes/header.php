
<header class="sticky top-0 z-40 bg-gradient-to-r from-green-800 to-green-600 shadow flex items-center justify-between px-6 py-4">
   <div class="flex items-center gap-4">
      <button id="sidebarCollapse" class="text-white focus:outline-none focus:ring-2 focus:ring-white rounded p-2">
         <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
      <a href="dashboard.php" class="text-white text-2xl font-bold tracking-wide">Grocery Store & Maid Service Admin</a>
   </div>
   <div class="flex items-center gap-4">
      <?php
$aid=$_SESSION['mhmsaid'];
$sql="SELECT AdminName,Email from  tbladmin where ID=:aid";
$query = $dbh -> prepare($sql);
$query->bindParam(':aid',$aid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $row)
{ ?>
      <div class="relative group">
         <button class="flex items-center gap-2 focus:outline-none">
            <img src="images/layout_img/user_img.jpg" alt="User" class="w-9 h-9 rounded-full border-2 border-green-400">
            <span class="text-white font-semibold"><?php  echo $row->AdminName;?></span>
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
         </button>
         <div class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg py-2 opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 transition pointer-events-none group-hover:pointer-events-auto z-50">
            <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-green-100">My Profile</a>
            <a href="change-password.php" class="block px-4 py-2 text-gray-700 hover:bg-green-100">Settings</a>
            <a href="logout.php" class="block px-4 py-2 text-red-600 hover:bg-red-50 flex items-center gap-2">Log Out <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg></a>
         </div>
      </div>
      <?php }} ?>
   </div>
</header>