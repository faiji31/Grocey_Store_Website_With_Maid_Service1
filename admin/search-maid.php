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
$sql="delete from tblmaid where ID=:rid";
$query=$dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
 echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'manage-maid.php'</script>";     


}

  ?>
<!DOCTYPE html>

<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['mhmsaid']==0)) {
  header('location:logout.php');
  exit();
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Admin | Search Maid</title>
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
               <h2 class="text-3xl font-bold text-green-800 mb-8">Search Maid</h2>
                      
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Search Maid</h2>
                                 </div>
                              </div>
                              
               <div class="bg-white rounded-xl shadow-lg p-8">
                  <form id="basic-form" method="post" class="flex flex-col md:flex-row items-center gap-4 mb-8">
                     <input id="searchdata" type="text" name="searchdata" required class="flex-1 px-4 py-2 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none text-gray-700" placeholder="Enter Maid ID or Name">
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
                              <th class="px-4 py-3">S.No</th>
                              <th class="px-4 py-3">Category Name</th>
                              <th class="px-4 py-3">Name</th>
                              <th class="px-4 py-3">Email</th>
                              <th class="px-4 py-3">Contact Number</th>
                              <th class="px-4 py-3">Date of Registration</th>
                              <th class="px-4 py-3">Action</th>
                           </tr>
                        </thead>
                        <tbody class="divide-y divide-green-100">
                           <?php
                           $sql="SELECT tblcategory.ID as cid, tblcategory.CategoryName, tblmaid.ID as mid, tblmaid.CatID, tblmaid.MaidId, tblmaid.Name, tblmaid.Email, tblmaid.ContactNumber, tblmaid.RegDate from tblmaid join tblcategory on tblcategory.ID=tblmaid.CatID where tblmaid.MaidId like :sdata or tblmaid.Name like :sdata";
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
                              <td class="px-4 py-2"><?php echo htmlentities($row->CategoryName);?></td>
                              <td class="px-4 py-2"><?php echo htmlentities($row->Name);?></td>
                              <td class="px-4 py-2"><?php echo htmlentities($row->Email);?></td>
                              <td class="px-4 py-2"><?php echo htmlentities($row->ContactNumber);?></td>
                              <td class="px-4 py-2"><?php echo htmlentities($row->RegDate);?></td>
                              <td class="px-4 py-2 flex gap-2">
                                 <a href="edit-maid.php?editid=<?php echo htmlentities($row->mid);?>" class="inline-block px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">Edit</a>
                                 <a href="manage-maid.php?delid=<?php echo ($row->mid);?>" onclick="return confirm('Do you really want to Delete ?');" class="inline-block px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Delete</a>
                              </td>
                           </tr>
                           <?php $cnt++; } } else { ?>
                           <tr>
                              <td colspan="7" class="text-center text-red-500 py-4">No record found against this search</td>
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
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="js/animate.js"></script>
      <!-- select country -->
      <script src="js/bootstrap-select.js"></script>
      <!-- owl carousel -->
      <script src="js/owl.carousel.js"></script> 
      <!-- chart js -->
      <script src="js/Chart.min.js"></script>
      <script src="js/Chart.bundle.min.js"></script>
      <script src="js/utils.js"></script>
      <script src="js/analyser.js"></script>
      <!-- nice scrollbar -->
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- fancy box js -->
      <script src="js/jquery-3.3.1.min.js"></script>
      <script src="js/jquery.fancybox.min.js"></script>
      <!-- custom js -->
      <script src="js/custom.js"></script>
      <!-- calendar file css -->    
      <script src="js/semantic.min.js"></script>
   </body>
</html><?php } ?>