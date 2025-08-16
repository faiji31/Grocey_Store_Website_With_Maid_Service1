<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['agentid']==0)) {
  header('location:logout.php');
  } else{

// Code for deletion
if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$sql="delete from tblmaid where ID=:rid";
$query=$dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
 echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'manage-maid.php'</script>";     


}

  ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      
      <title>Maid Hiring Management System || Manage Maid</title>
   
   <script src="https://cdn.tailwindcss.com"></script>
      
   </head>
   <body class="bg-gray-100 min-h-screen flex">
      <?php include_once('includes/sidebar.php');?>
      <div class="flex-1 flex flex-col min-h-screen" style="min-width:0;">
         <?php include_once('includes/header.php');?>
         <main class="flex-1 p-6 md:p-10 mt-4">
            <h2 class="text-3xl font-bold text-green-700 mb-8">Manage Maid</h2>
            <div class="bg-white rounded-xl shadow-lg p-8">
               <h3 class="text-xl font-semibold text-green-700 mb-4">Manage Maid</h3>
               <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-green-200">
                     <thead class="bg-green-100">
                        <tr>
                           <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">S.No</th>
                           <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Category Name</th>
                           <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Name</th>
                           <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Email</th>
                           <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Contact Number</th>
                           <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Date of Registration</th>
                        </tr>
                     </thead>
                     <tbody class="bg-white divide-y divide-green-100">
                        <?php
$sql="SELECT tblcategory.ID as cid, tblcategory.CategoryName,tblmaid.ID as mid,tblmaid.CatID,tblmaid.Name,tblmaid.Email,tblmaid.ContactNumber,tblmaid.RegDate from tblmaid join tblcategory on tblcategory.ID=tblmaid.CatID";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?> 
                           <tr>
                              <td class="px-4 py-2 font-medium text-gray-700"><?php echo htmlentities($cnt);?></td>
                              <td class="px-4 py-2 text-gray-600"><?php  echo htmlentities($row->CategoryName);?></td>
                              <td class="px-4 py-2 text-gray-600"><?php  echo htmlentities($row->Name);?></td>
                              <td class="px-4 py-2 text-gray-600"><?php  echo htmlentities($row->Email);?></td>
                              <td class="px-4 py-2 text-gray-600"><?php  echo htmlentities($row->ContactNumber);?></td>
                              <td class="px-4 py-2 text-gray-600"><?php  echo htmlentities($row->RegDate);?></td>
                           </tr><?php $cnt=$cnt+1;}} ?>
                                       </tbody>
                  </table>
               </div>
            </div>
         </main>
         <?php include_once('includes/footer.php');?>
      </div>
   </body>
</html><?php } ?>