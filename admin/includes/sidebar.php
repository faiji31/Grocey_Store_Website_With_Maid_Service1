
<!-- Tailwind CSS Sidebar -->
<aside class="h-screen w-64 bg-gradient-to-b from-green-700 to-green-900 text-white flex flex-col shadow-xl sticky top-0">
   <div class="flex flex-col items-center py-8 border-b border-green-800">
      <a href="dashboard.php" class="mb-4">
         <img src="images/logo/logo_icon.png" alt="Logo" class="w-16 h-16 rounded-full shadow-lg border-4 border-green-500">
      </a>
      <div class="flex flex-col items-center mt-2">
         <img src="images/layout_img/user_img.jpg" alt="User" class="w-14 h-14 rounded-full border-2 border-green-400 mb-2">
         <div class="text-center">
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
            <h2 class="font-bold text-lg"> <?php  echo $row->AdminName;?> </h2>
            <p class="text-green-200 text-xs flex items-center justify-center gap-2"><span class="inline-block w-2 h-2 bg-green-400 rounded-full animate-pulse"></span><?php  echo $row->Email;?></p>
            <?php }} ?>
         </div>
      </div>
   </div>
   <nav class="flex-1 px-4 py-6 overflow-y-auto">
      <h4 class="uppercase text-green-200 text-xs tracking-widest mb-4">General</h4>
      <ul class="space-y-2">
         <li>
            <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-800 transition font-semibold">
               <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 8h2v-2H7v2zm0-4h2v-2H7v2zm0-4h2V7H7v2zm4 8h2v-2h-2v2zm0-4h2v-2h-2v2zm0-4h2V7h-2v2zm4 8h2v-2h-2v2zm0-4h2v-2h-2v2zm0-4h2V7h-2v2z"/></svg>
               Dashboard
            </a>
         </li>
         <li>
            <details class="group">
               <summary class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-800 transition font-semibold cursor-pointer">
                  <svg class="w-5 h-5 text-orange-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12l2 2 4-4"/></svg>
                  Category
                  <svg class="w-4 h-4 ml-auto group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
               </summary>
               <ul class="ml-8 mt-2 space-y-1">
                  <li><a href="add-category.php" class="block px-2 py-1 rounded hover:bg-green-700">Add</a></li>
                  <li><a href="manage-category.php" class="block px-2 py-1 rounded hover:bg-green-700">Manage</a></li>
               </ul>
            </details>
         </li>
         <li>
            <details class="group">
               <summary class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-800 transition font-semibold cursor-pointer">
                  <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12l2 2 4-4"/></svg>
                  Maid
                  <svg class="w-4 h-4 ml-auto group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
               </summary>
               <ul class="ml-8 mt-2 space-y-1">
                  <li><a href="add-maid.php" class="block px-2 py-1 rounded hover:bg-green-700">Add Maid</a></li>
                  <li><a href="manage-maid.php" class="block px-2 py-1 rounded hover:bg-green-700">Manage Maid</a></li>
               </ul>
            </details>
         </li>
         <li>
            <details class="group">
               <summary class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-800 transition font-semibold cursor-pointer">
                  <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12l2 2 4-4"/></svg>
                  Maid Hiring Request
                  <svg class="w-4 h-4 ml-auto group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
               </summary>
               <ul class="ml-8 mt-2 space-y-1">
                  <li><a href="new-request.php" class="block px-2 py-1 rounded hover:bg-green-700">New Request</a></li>
                  <li><a href="assign-request.php" class="block px-2 py-1 rounded hover:bg-green-700">Assign Request</a></li>
                  <li><a href="cancel-request.php" class="block px-2 py-1 rounded hover:bg-green-700">Cancel Request</a></li>
                  <li><a href="all-request.php" class="block px-2 py-1 rounded hover:bg-green-700">All Request</a></li>
               </ul>
            </details>
         </li>
         <li>
            <a href="sale-report.php" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-800 transition font-semibold">
               <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"/></svg>
               Sales Report
            </a>
         </li>
         <li>
            <a href="view-feedback.php" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-800 transition font-semibold">
               <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12l2 2 4-4"/></svg>
               Feedbacks
            </a>
         </li>
      </ul>
   </nav>
</aside>