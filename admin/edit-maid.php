<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['mhmsaid']==0)) {
  header('location:picut.php');
  } else{
    if(isset($_POST['submit']))
  {

 $catid=$_POST['catid'];
 $maidid=$_POST['maidid'];
 $name=$_POST['name'];
 $email=$_POST['email'];
 $contno=$_POST['contno'];
 $exp=$_POST['experience'];
 $dob=$_POST['dob'];
 $add=$_POST['add'];
 $desc=$_POST['desc'];
 $gender=$_POST['gender'];
$eid=$_GET['editid'];

$sql="update tblmaid set CatID=:catid,MaidId=:maidid,Name=:name,Email=:email,ContactNumber=:contno,Experience=:exp,Dateofbirth=:dob,Address=:add,Description=:desc, Gender=:gender where ID=:eid";
$query=$dbh->prepare($sql);
$query->bindParam(':catid',$catid,PDO::PARAM_STR);
$query->bindParam(':maidid',$maidid,PDO::PARAM_STR);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':contno',$contno,PDO::PARAM_STR);
$query->bindParam(':exp',$exp,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':add',$add,PDO::PARAM_STR);
$query->bindParam(':desc',$desc,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
 echo '<script>alert("Maid detail has been updated")</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Maid Hirirng Management System || Update Maid Details</title>
    
   <script src="https://cdn.tailwindcss.com"></script>
     
   </head>
   <body class="inner_page general_elements">
      <div class="flex min-h-screen bg-gray-100">
         <?php include_once('includes/sidebar.php');?>
         <div class="flex-1 flex flex-col">
            <?php include_once('includes/header.php');?>
            <main class="flex-1 p-6 md:p-10">
               <h2 class="text-3xl font-bold text-green-700 mb-8">Update Maid Details</h2>
               <div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
                  <form method="post" enctype="multipart/form-data" class="space-y-6">
                     <?php
$eid=$_GET['editid'];
$sql="SELECT tblcategory.ID as did, tblcategory.CategoryName,tblmaid.ID as eid,tblmaid.CatID,tblmaid.MaidId,tblmaid.Name,tblmaid.Email,tblmaid.Gender,tblmaid.ContactNumber,tblmaid.Experience,tblmaid.Dateofbirth,tblmaid.Address,tblmaid.Description,tblmaid.ProfilePic,tblmaid.IdProof,tblmaid.RegDate from tblmaid join tblcategory on tblcategory.ID=tblmaid.CatID where tblmaid.ID=:eid";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Category Name</label>
                        <select name="catid" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                           <option value="<?php echo $row->did;?>"><?php echo $row->CategoryName;?></option>
                           <?php 
$sql2 = "SELECT * from   tblcategory ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);
foreach($result2 as $row2)
{ ?>
                           <option value="<?php echo htmlentities($row2->ID);?>"><?php echo htmlentities($row2->CategoryName);?></option>
                           <?php } ?>
                        </select>
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Maid ID</label>
                        <input type="text" name="maidid" value="<?php echo $row->MaidId;?>" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Name</label>
                        <input type="text" name="name" value="<?php echo $row->Name;?>" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Email</label>
                        <input type="email" name="email" value="<?php echo $row->Email;?>" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Contact Number</label>
                        <input type="text" name="contno" value="<?php echo $row->ContactNumber;?>" required maxlength="10" pattern="[0-9]+" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Gender</label>
                        <select name="gender" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                           <option value="<?php echo $row->Gender;?>"><?php echo $row->Gender;?></option>
                           <option value="Male">Male</option>
                           <option value="Female">Female</option>
                        </select>
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Experience</label>
                        <input type="text" name="experience" value="<?php echo $row->Experience;?>" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Date of Birth</label>
                        <input type="date" name="dob" value="<?php echo $row->Dateofbirth;?>" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Address</label>
                        <textarea name="add" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm"><?php echo $row->Address;?></textarea>
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Description (if any)</label>
                        <textarea name="desc" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm"><?php echo $row->Description;?></textarea>
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">Maid Pic</label>
                        <div class="flex items-center gap-4">
                           <img src="images/<?php echo $row->ProfilePic;?>" width="100" height="100" class="rounded shadow border border-gray-200">
                           <a href="changeimage.php?editid=<?php echo $row->eid;?>" class="text-blue-600 hover:underline">Edit Image</a>
                        </div>
                     </div>
                     <div>
                        <label class="block text-lg font-semibold text-green-700 mb-2">ID Proof</label>
                        <div class="flex items-center gap-4">
                           <img src="idproofimages/<?php echo $row->IdProof;?>" width="100" height="100" class="rounded shadow border border-gray-200">
                           <a href="changeidproof.php?editid=<?php echo $row->eid;?>" class="text-blue-600 hover:underline">Upload New</a>
                        </div>
                     </div>
                     <?php $cnt=$cnt+1;}} ?>
                     <div class="text-center">
                        <button type="submit" name="submit" id="submit" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-8 py-2 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg">Update</button>
                     </div>
                  </form>
               </div>
            </main>
            <?php include_once('includes/footer.php');?>
         </div>
      </div>
   </body>
</html><?php } ?>