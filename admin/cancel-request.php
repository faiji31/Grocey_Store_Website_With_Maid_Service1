<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['mhmsaid']==0)) {
  header('location:logout.php');
  } else{

  ?>
<!DOCTYPE html>
<html lang="en">
   <head>
   <title>Grocery Store and Maid Service | Cancel Request</title>
   <link rel="shortcut icon" href="images/logo/logo_icon.png" type="image/x-icon">
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
   </head>

   <body class="bg-gray-100 min-h-screen">
      <div class="flex min-h-screen">
         <?php include_once('includes/sidebar.php'); ?>
         <div class="flex-1 flex flex-col min-h-screen">
            <?php include_once('includes/header.php'); ?>
            <main class="flex-1 p-6">
               <div class="max-w-6xl mx-auto">
                  <h2 class="text-3xl font-bold text-red-800 mb-8">Cancel Request</h2>
                  <!-- Table for tblmaidbooking -->
                  <div class="bg-white rounded-xl shadow-lg p-6 mb-10">
                     <h3 class="text-xl font-semibold text-red-700 mb-4">Cancelled Maid Bookings</h3>
                     <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg overflow-hidden shadow text-sm">
                           <thead class="bg-red-700 text-white">
                              <tr>
                                 <th class="px-4 py-3">#</th>
                                 <th class="px-4 py-3">Booking ID</th>
                                 <th class="px-4 py-3">Name</th>
                                 <th class="px-4 py-3">Mobile Number</th>
                                 <th class="px-4 py-3">Email</th>
                                 <th class="px-4 py-3">Booking Date</th>
                                 <th class="px-4 py-3">Status</th>
                                 <th class="px-4 py-3">Assign To</th>
                              </tr>
                           </thead>
                           <tbody class="divide-y divide-red-100">
                              <?php
                              $sql="SELECT * from tblmaidbooking where Status='Cancelled'";
                              $query = $dbh -> prepare($sql);
                              $query->execute();
                              $results=$query->fetchAll(PDO::FETCH_OBJ);
                              $cnt=1;
                              if($query->rowCount() > 0)
                              {
                              foreach($results as $row)
                              { ?>
                              <tr class="hover:bg-red-50">
                                 <td class="px-4 py-2 text-center"><?php echo htmlentities($cnt);?></td>
                                 <td class="px-4 py-2 font-semibold text-red-800"><?php echo htmlentities($row->BookingID);?></td>
                                 <td class="px-4 py-2"><?php echo htmlentities($row->Name);?></td>
                                 <td class="px-4 py-2"><?php echo htmlentities($row->ContactNumber);?></td>
                                 <td class="px-4 py-2"><?php echo htmlentities($row->Email);?></td>
                                 <td class="px-4 py-2"><?php echo htmlentities($row->BookingDate);?></td>
                                 <td class="px-4 py-2">
                                    <span class="inline-block bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium"><?php echo htmlentities($row->Status);?></span>
                                 </td>
                                 <td class="px-4 py-2"><?php echo htmlentities($row->AssignTo);?></td>
                              </tr>
                              <?php $cnt=$cnt+1; } } else { ?>
                              <tr>
                                 <td colspan="8" class="text-center text-red-500 py-4">No Cancelled Maid Bookings Found</td>
                              </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <!-- Table for tblgrocerybooking -->
                  <div class="bg-white rounded-xl shadow-lg p-6">
                     <h3 class="text-xl font-semibold text-red-700 mb-4">Cancelled Grocery Orders</h3>
                     <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg overflow-hidden shadow text-sm">
                           <thead class="bg-red-700 text-white">
                              <tr>
                                 <th class="px-4 py-3">#</th>
                                 <th class="px-4 py-3">Order ID</th>
                                 <th class="px-4 py-3">Customer Name</th>
                                 <th class="px-4 py-3">Phone Number</th>
                                 <th class="px-4 py-3">Delivery Address</th>
                                 <th class="px-4 py-3">Order Details</th>
                                 <th class="px-4 py-3">Delivery Time</th>
                                 <th class="px-4 py-3">Status</th>
                                 <th class="px-4 py-3">Assign To</th>
                              </tr>
                           </thead>
                           <tbody class="divide-y divide-red-100">
                              <?php
                              $sql="SELECT * from tblgrocerybooking where Status='Cancelled'";
                              $query = $dbh -> prepare($sql);
                              $query->execute();
                              $results=$query->fetchAll(PDO::FETCH_OBJ);
                              $cnt=1;
                              if($query->rowCount() > 0)
                              {
                              foreach($results as $row)
                              { ?>
                              <tr class="hover:bg-red-50">
                                 <td class="px-4 py-2 text-center"><?php echo htmlentities($cnt);?></td>
                                 <td class="px-4 py-2 font-semibold text-red-800"><?php echo htmlentities($row->ID);?></td>
                                 <td class="px-4 py-2"><?php echo htmlentities($row->UserName);?></td>
                                 <td class="px-4 py-2"><?php echo htmlentities($row->PhoneNumber);?></td>
                                 <td class="px-4 py-2"><?php echo htmlentities($row->FullArea);?></td>
                                 <td class="px-4 py-2"><?php echo htmlentities($row->OrderDetails);?></td>
                                 <td class="px-4 py-2"><?php echo htmlentities($row->DeliveryTime);?></td>
                                 <td class="px-4 py-2">
                                    <span class="inline-block bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium"><?php echo htmlentities($row->Status);?></span>
                                 </td>
                                 <td class="px-4 py-2"><?php echo htmlentities($row->AssignTo);?></td>
                              </tr>
                              <?php $cnt=$cnt+1; } } else { ?>
                              <tr>
                                 <td colspan="9" class="text-center text-red-500 py-4">No Cancelled Grocery Orders Found</td>
                              </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </main>
            <?php include_once('includes/footer.php'); ?>
         </div>
      </div>
   </body>
</html><?php } ?>
