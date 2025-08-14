<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['mhmsaid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
{
$adminid=$_SESSION['mhmsaid'];
$cpassword=md5($_POST['currentpassword']);
$newpassword=md5($_POST['newpassword']);
$sql ="SELECT ID FROM tbladmin WHERE ID=:adminid and Password=:cpassword";
$query= $dbh -> prepare($sql);
$query-> bindParam(':adminid', $adminid, PDO::PARAM_STR);
$query-> bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);

if($query -> rowCount() > 0)
{
$con="update tbladmin set Password=:newpassword where ID=:adminid";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':adminid', $adminid, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();

echo '<script>alert("Your password successully changed")</script>';
} else {
echo '<script>alert("Your current password is wrong")</script>';

}
}
  ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Maid Hiring Management System || Change Password</title>
    
   <script src="https://cdn.tailwindcss.com"></script>
     <script type="text/javascript">
function checkpass()
{
if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
{
alert('New Password and Confirm Password field does not match');
document.changepassword.confirmpassword.focus();
return false;
}
return true;
}   

</script>
   </head>
   <body class="inner_page general_elements">
      <div class="flex min-h-screen bg-gray-100">
         <?php include_once('includes/sidebar.php');?>
         <div class="flex-1 flex flex-col">
            <?php include_once('includes/header.php');?>
            <main class="flex-1 p-6 md:p-10">
               <h2 class="text-3xl font-bold text-green-700 mb-8">Change Password</h2>
               <div class="max-w-xl mx-auto bg-white rounded-xl shadow p-8">
                  <form method="post" class="space-y-6" onsubmit="return checkpass();">
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Current Password</label>
                        <input type="password" name="currentpassword" id="currentpassword" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">New Password</label>
                        <input type="password" name="newpassword" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Confirm Password</label>
                        <input type="password" name="confirmpassword" id="confirmpassword" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
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
</html><?php }  ?>