
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['mhmsaid']==0)) {
  header('location:logout.php');
  exit();
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title>Maid Hiring Management System | Search Booking Request</title>
   <link rel="shortcut icon" href="images/logo/logo_icon.png" type="image/x-icon">
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
   <div class="flex min-h-screen">
      <!-- Sidebar -->
      <?php include_once('includes/sidebar.php'); ?>
      <div class="flex-1 flex flex-col min-h-screen">
         <!-- Header -->
         <?php include_once('includes/header.php'); ?>
         <main class="flex-1 p-6">
            <div class="max-w-5xl mx-auto">
               <h2 class="text-3xl font-bold text-green-800 mb-8">Search Booking Request</h2>
               <div class="bg-white rounded-xl shadow-lg p-8">
                  <form id="basic-form" method="post" class="flex flex-col md:flex-row items-center gap-4 mb-8">
                     <input id="searchdata" type="text" name="searchdata" required class="flex-1 px-4 py-2 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none text-gray-700" placeholder="Enter Booking ID or Name">
                     <button type="submit" name="search" id="submit" class="px-6 py-2 bg-green-700 text-white rounded-lg font-semibold hover:bg-green-800 transition">Search</button>
                  </form>
                  <?php
                  if(isset($_POST['search'])) {
                     $sdata=trim($_POST['searchdata']);
                  ?>
                  <h4 class="text-lg font-semibold text-center text-green-700 mb-4">Result against "<?php echo htmlspecialchars($sdata);?>" keyword</h4>
                  <div class="overflow-x-auto">
                     <table class="min-w-full bg-white rounded-lg overflow-hidden shadow text-sm">
                        <thead class="bg-green-700 text-white">
                           <tr>
                              <th class="px-4 py-3 text-center">#</th>
                              <th class="px-4 py-3">Booking ID</th>
                              <th class="px-4 py-3">Name</th>
                              <th class="px-4 py-3">Mobile Number</th>
                              <th class="px-4 py-3">Email</th>
                              <th class="px-4 py-3">Booking Date</th>
                              <th class="px-4 py-3">Status</th>
                              <th class="px-4 py-3">Assign To</th>
                              <th class="px-4 py-3">Action</th>
                           </tr>
                        </thead>
                        <tbody class="divide-y divide-green-100">
                           <?php
                           $sql= "SELECT * from tblmaidbooking where tblmaidbooking.BookingID like :sdata or tblmaidbooking.Name like :sdata";
                           $query = $dbh -> prepare($sql);
                           $likeData = $sdata . '%';
                           $query->bindParam(':sdata', $likeData, PDO::PARAM_STR);
                           $query->execute();
                           $results=$query->fetchAll(PDO::FETCH_OBJ);
                           $cnt=1;
                           if($query->rowCount() > 0) {
                              foreach($results as $row) {
                           ?>
                           <tr class="hover:bg-green-50">
                              <td class="px-4 py-2 text-center"><?php echo htmlentities($cnt);?></td>
                              <td class="px-4 py-2 font-semibold text-green-800"><?php echo htmlentities($row->BookingID);?></td>
                              <td class="px-4 py-2"><?php echo htmlentities($row->Name);?></td>
                              <td class="px-4 py-2"><?php echo htmlentities($row->ContactNumber);?></td>
                              <td class="px-4 py-2"><?php echo htmlentities($row->Email);?></td>
                              <td class="px-4 py-2">
                                 <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium"><?php echo htmlentities($row->BookingDate);?></span>
                              </td>
                              <td class="px-4 py-2">
                                 <?php if($row->Status==""){ ?>
                                    <span class="text-gray-400 italic">Not Updated Yet</span>
                                 <?php } else { ?>
                                    <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium"><?php echo htmlentities($row->Status);?></span>
                                 <?php } ?>
                              </td>
                              <td class="px-4 py-2">
                                 <?php if($row->Status==""){ ?>
                                    <span class="text-gray-400 italic">Not Assign Yet</span>
                                 <?php } else { ?>
                                    <span class="inline-block bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs font-medium"><?php echo htmlentities($row->AssignTo);?></span>
                                 <?php } ?>
                              </td>
                              <td class="px-4 py-2 text-center">
                                 <a href="view-booking-detail.php?editid=<?php echo htmlentities($row->ID);?>&&bookingid=<?php echo htmlentities($row->BookingID);?>" class="inline-block px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition" title="View"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                              </td>
                           </tr>
                           <?php $cnt++; } } else { ?>
                           <tr>
                              <td colspan="9" class="text-center text-red-500 py-4">No record found against this search</td>
                           </tr>
                           <?php } } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </main>
         <!-- Footer -->
         <?php include_once('includes/footer.php'); ?>
      </div>
   </div>
</body>
</html>
<?php } ?>