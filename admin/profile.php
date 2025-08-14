<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['mhmsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {
    $adminid=$_SESSION['mhmsaid'];
    $AName=$_POST['adminname'];
  $mobno=$_POST['mobilenumber'];
  $email=$_POST['email'];
  $sql="update tbladmin set AdminName=:adminname,MobileNumber=:mobilenumber,Email=:email where ID=:aid";
     $query = $dbh->prepare($sql);
     $query->bindParam(':adminname',$AName,PDO::PARAM_STR);
     $query->bindParam(':email',$email,PDO::PARAM_STR);
     $query->bindParam(':mobilenumber',$mobno,PDO::PARAM_STR);
     $query->bindParam(':aid',$adminid,PDO::PARAM_STR);
$query->execute();
if($query -> rowCount() > 0)
   {
    echo '<script>alert("Your profile has been updated")</script>';
    echo "<script>window.location.href ='profile.php'</script>";
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
      <title>Maid Hiring Management System || Profile</title>
    
   <script src="https://cdn.tailwindcss.com"></script>
     
   </head>
   <body class="inner_page general_elements">
      <div class="flex min-h-screen bg-gray-100">
         <?php include_once('includes/sidebar.php');?>
         <div class="flex-1 flex flex-col">
            <?php include_once('includes/header.php');?>
            <main class="flex-1 p-6 md:p-10">
               <h2 class="text-3xl font-bold text-green-700 mb-8">Admin Profile</h2>
               <div class="max-w-xl mx-auto bg-white rounded-xl shadow p-8">
                  <form method="post" class="space-y-6">
                     <?php
$sql="SELECT * from  tbladmin";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Admin Name</label>
                        <input type="text" name="adminname" value="<?php  echo $row->AdminName;?>" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">User Name</label>
                        <input type="text" name="username" value="<?php  echo $row->UserName;?>" readonly class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Contact Number</label>
                        <input type="text" name="mobilenumber" value="<?php  echo $row->MobileNumber;?>" maxlength='10' required pattern="[0-9]+" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Email</label>
                        <input type="email" name="email" value="<?php  echo $row->Email;?>" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Admin Registration Date</label>
                        <input type="text" value="<?php  echo $row->AdminRegdate;?>" readonly class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100">
                     </div>
                     <?php $cnt=$cnt+1;}} ?>
                     <div class="text-center pt-4">
                        <button type="submit" name="submit" id="submit" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-10 py-2 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg">Update</button>
                     </div>
                  </form>
               </div>
            </main>
            <?php include_once('includes/footer.php');?>
         </div>
      </div>
   </body>
</html><?php } ?>