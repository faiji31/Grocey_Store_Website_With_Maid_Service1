<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
  {
    $email=$_POST['email'];
$mobile=$_POST['mobile'];
$newpassword=md5($_POST['newpassword']);
  $sql ="SELECT Email FROM tbladmin WHERE Email=:email and MobileNumber=:mobile";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update tbladmin set Password=:newpassword where Email=:email and MobileNumber=:mobile";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
$chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
echo "<script>alert('Your Password succesfully changed');</script>";
}
else {
echo "<script>alert('Email id or Mobile no is invalid');</script>"; 
}
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
    
      <title>Maid Hiring Management System || Forgot Page</title>
     
   <script src="https://cdn.tailwindcss.com"></script>
   <script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>
   </head>
   <body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-200 via-green-100 to-green-400">
      <div class="w-full max-w-md mx-auto bg-white rounded-2xl shadow-2xl p-8 md:p-10 border border-green-200">
         <div class="flex flex-col items-center mb-8">
            <svg class="w-16 h-16 text-green-600 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M6.05 17.95l-1.414 1.414M17.95 17.95l-1.414-1.414M6.05 6.05L4.636 4.636"/><circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
            <h3 class="text-2xl font-bold text-green-700 text-center">Maid Hiring Management System</h3>
         </div>
         <form method="post" name="chngpwd" onSubmit="return valid();" class="space-y-6">
            <div>
               <label class="block text-green-700 font-semibold mb-1">Email</label>
               <input type="email" placeholder="Email" required name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <div>
               <label class="block text-green-700 font-semibold mb-1">Mobile Number</label>
               <input type="text" placeholder="Mobile Number" required name="mobile" maxlength="10" pattern="[0-9]+" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <div>
               <label class="block text-green-700 font-semibold mb-1">New Password</label>
               <input type="password" name="newpassword" placeholder="New Password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <div>
               <label class="block text-green-700 font-semibold mb-1">Confirm Password</label>
               <input type="password" name="confirmpassword" placeholder="Confirm Password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <button name="submit" type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-700 text-white font-bold py-2 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg">RESET</button>
            <div class="text-center pt-2">
               <a href="login.php" class="text-green-700 hover:underline text-sm">Login</a>
            </div>
         </form>
      </div>
   </body>
</html>