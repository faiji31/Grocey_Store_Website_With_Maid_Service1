<?php
session_start();
//error_reporting(0); 
include('includes/dbconnection.php');



if (strlen($_SESSION['agentid']==0)) {
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
   <body class="bg-gray-100 min-h-screen flex">
      <?php include_once('includes/sidebar.php');?>
      <div class="flex-1 flex flex-col min-h-screen" style="min-width:0;">
         <?php include_once('includes/header.php');?>
         <main class="flex-1 p-6 md:p-10 mt-4">
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
                        <fieldset class="space-y-5">
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">Category Name</label>
                              <select name="catid" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition">
                                 <option value="<?php echo $row->did;?>"><?php echo $row->CategoryName;?></option>
                                 <?php 
                                 $sql2 = "SELECT * from   tblcategory ";
                                 $query2 = $dbh -> prepare($sql2);
                                 $query2->execute();
                                 $result2=$query2->fetchAll(PDO::FETCH_OBJ);
                                 foreach($result2 as $row2) { ?>
                                 <option value="<?php echo htmlentities($row2->ID);?>"><?php echo htmlentities($row2->CategoryName);?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">Maid ID</label>
                              <input type="text" name="maidid" value="<?php echo $row->MaidId;?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition">
                           </div>
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">Name</label>
                              <input type="text" name="name" value="<?php echo $row->Name;?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition">
                           </div>
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">Email</label>
                              <input type="email" name="email" value="<?php echo $row->Email;?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition">
                           </div>
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">Contact Number</label>
                              <input type="text" name="contno" value="<?php echo $row->ContactNumber;?>" required maxlength="10" pattern="[0-9]+" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition">
                           </div>
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">Gender</label>
                              <select name="gender" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition">
                                 <option value="<?php echo $row->Gender;?>"><?php echo $row->Gender;?></option>
                                 <option value="Male">Male</option>
                                 <option value="Female">Female</option>
                              </select>
                           </div>
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">Experience</label>
                              <input type="text" name="experience" value="<?php echo $row->Experience;?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition">
                           </div>
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">Date of Birth</label>
                              <input type="date" name="dob" value="<?php echo $row->Dateofbirth;?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition">
                           </div>
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">Address</label>
                              <textarea name="add" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"><?php echo $row->Address;?></textarea>
                           </div>
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">Description (if any)</label>
                              <textarea name="desc" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"><?php echo $row->Description;?></textarea>
                           </div>
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">Maid Pic</label>
                              <div class="flex items-center space-x-4">
                                 <img src="images/<?php echo $row->ProfilePic;?>" width="100" height="100" class="rounded-lg border border-gray-300 shadow" alt="Maid Pic">
                                 <a href="changeimage.php?editid=<?php echo $row->eid;?>" class="text-green-700 hover:underline">Edit Image</a>
                              </div>
                           </div>
                           <div>
                              <label class="block text-green-700 font-semibold mb-1">ID Proof</label>
                              <div class="flex items-center space-x-4">
                                 <img src="idproofimages/<?php echo $row->IdProof;?>" width="100" height="100" class="rounded-lg border border-gray-300 shadow" alt="ID Proof">
                                 <a href="changeidproof.php?editid=<?php echo $row->eid;?>" class="text-green-700 hover:underline">Upload New</a>
                              </div>
                           </div>
                           <div class="pt-4 text-center">
                              <button type="submit" name="submit" id="submit" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-10 py-2 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg">Update</button>
                           </div>
                        </fieldset>
                     </form>
                                            
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- funcation section -->
                     
                     </div>
                  </div>
            </div>
         </main>
         <?php include_once('includes/footer.php');?>
      </div>
   </body>
</html><?php } ?>