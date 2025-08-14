<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['mhmsaid']==0)) {
  header('location:logout.php');
  } else{

// Code for deletion
if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$sql="delete from tblcategory where ID=:rid";
$query=$dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
 echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'manage-category.php'</script>";     


}

  ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      
      <title>Grocery Store and Maid Service || Manage Category</title>
   
   <script src="https://cdn.tailwindcss.com"></script>
      
   </head>
   <body class="inner_page tables_page">
      <div class="flex min-h-screen bg-gray-100">
         <?php include_once('includes/sidebar.php');?>
         <div class="flex-1 flex flex-col">
            <?php include_once('includes/header.php');?>
            <main class="flex-1 p-6 md:p-10">
               <h2 class="text-3xl font-bold text-green-700 mb-8">Manage Category</h2>
               <div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-8">
                  <div class="overflow-x-auto">
                     <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-700">
                           <tr>
                              <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">S.No</th>
                              <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Category Name</th>
                              <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Creation Date</th>
                              <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Action</th>
                           </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                           <?php
$sql="SELECT * from tblcategory";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?> 
                           <tr>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlentities($cnt);?></td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php  echo htmlentities($row->CategoryName);?></td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php  echo htmlentities($row->CreationDate);?></td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                                 <a href="edit-category.php?editid=<?php echo htmlentities ($row->ID);?>" class="bg-green-500 hover:bg-green-700 text-white px-4 py-1 rounded-full text-xs font-semibold transition">Edit</a>
                                 <a href="manage-category.php?delid=<?php echo ($row->ID);?>" onclick="return confirm('Do you really want to Delete ?');" class="bg-red-500 hover:bg-red-700 text-white px-4 py-1 rounded-full text-xs font-semibold transition">Delete</a>
                              </td>
                           </tr>
                           <?php $cnt=$cnt+1;}} ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </main>
            <?php include_once('includes/footer.php');?>
         </div>
      </div>
   </body>
</html><?php } ?>