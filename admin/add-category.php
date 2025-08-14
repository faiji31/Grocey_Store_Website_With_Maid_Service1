<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['mhmsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {

 $catname=$_POST['catname'];
$sql="insert into tblcategory(CategoryName)values(:catname)";
$query=$dbh->prepare($sql);
$query->bindParam(':catname',$catname,PDO::PARAM_STR);

 $query->execute();

   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Category has been added.")</script>';
echo "<script>window.location.href ='add-category.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Maid Hiring Management System || Add Category</title>
    
   <script src="https://cdn.tailwindcss.com"></script>
     
   </head>
   <body class="inner_page general_elements">
      <div class="flex min-h-screen bg-gray-100">
         <?php include_once('includes/sidebar.php');?>
         <div class="flex-1 flex flex-col">
            <?php include_once('includes/header.php');?>
            <main class="flex-1 p-6 md:p-10">
               <h2 class="text-3xl font-bold text-green-700 mb-8">Add Category</h2>
               <div class="max-w-xl mx-auto bg-white rounded-xl shadow p-8">
                  <form method="post" class="space-y-6">
                     <div>
                        <label for="catname" class="block text-lg font-semibold text-green-700 mb-2">Category Name</label>
                        <input type="text" name="catname" id="catname" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm" placeholder="Enter category name">
                     </div>
                     <div class="text-center">
                        <button type="submit" name="submit" id="submit" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-8 py-2 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg">Add</button>
                     </div>
                  </form>
               </div>
            </main>
            <?php include_once('includes/footer.php'); ?>
         </div>
      </div>
   </body>
</html><?php } ?>