<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['mhmsaid']==0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $catname = $_POST['catname'];
    $eid = $_GET['editid'];
    $sql = "UPDATE tblcategory SET CategoryName=:catname WHERE ID=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':catname', $catname, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
    echo '<script>alert("Category name has been updated")</script>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Grocery Store and Maid Service|| Update Category</title>
   <script src="https://cdn.tailwindcss.com"></script>
   </head>
   <body class="inner_page general_elements">
      <div class="flex min-h-screen bg-gray-100">
         <?php include_once('includes/sidebar.php'); ?>
         <div class="flex-1 flex flex-col">
            <?php include_once('includes/header.php'); ?>
            <main class="flex-1 p-6 md:p-10">
               <h2 class="text-3xl font-bold text-green-700 mb-8">Update Category</h2>
               <div class="max-w-xl mx-auto bg-white rounded-xl shadow p-8">
                  <form method="post" class="space-y-6">
                     <?php
                        $eid = $_GET['editid'];
                        $sql = "SELECT * FROM tblcategory WHERE ID=$eid";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                           foreach ($results as $row) {
                     ?>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Category Name</label>
                        <input type="text" name="catname" value="<?php echo htmlentities($row->CategoryName); ?>" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <?php 
                           }
                        }
                     ?>
                     <div class="text-center pt-4">
                        <button type="submit" name="submit" id="submit" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-10 py-2 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg">Update</button>
                     </div>
                  </form>
               </div>
            </main>
            <?php include_once('includes/footer.php'); ?>
         </div>
      </div>
   </body>
</html>
