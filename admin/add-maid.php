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
$pic=$_FILES["pic"]["name"];
$idproof=$_FILES["idproof"]["name"];
$extension = substr($pic,strlen($pic)-4,strlen($pic));
$extension1 = substr($idproof,strlen($idproof)-4,strlen($idproof));
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
$allowed_extensions1 = array(".jpg","jpeg",".png",".gif");
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Pic has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{

$picnew=md5($pic).time().$extension;
 move_uploaded_file($_FILES["pic"]["tmp_name"],"images/".$picnew);


if(!in_array($extension1,$allowed_extensions1))
{
echo "<script>alert('Id proof has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{

$idproof=md5($idproof).time().$extension1;
 move_uploaded_file($_FILES["idproof"]["tmp_name"],"idproofimages/".$idproof);
$ret="select Email from tblmaid where Email=:email || ContactNumber=:contno || MaidId=:maidid";
 $query= $dbh -> prepare($ret);
$query->bindParam(':maidid',$maidid,PDO::PARAM_STR);
$query->bindParam(':contno',$contno,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query-> execute();
     $results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() == 0)
{

$sql="insert into tblmaid(CatID,MaidId,Name,Email,ContactNumber,Gender,Experience,Dateofbirth,Address,Description,ProfilePic,IdProof)values(:catid,:maidid,:name,:email,:contno,:gender,:exp,:dob,:add,:desc,:pic,:idproof)";
$query=$dbh->prepare($sql);
$query->bindParam(':catid',$catid,PDO::PARAM_STR);
$query->bindParam(':maidid',$maidid,PDO::PARAM_STR);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':contno',$contno,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':exp',$exp,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':add',$add,PDO::PARAM_STR);
$query->bindParam(':desc',$desc,PDO::PARAM_STR);
$query->bindParam(':pic',$picnew,PDO::PARAM_STR);
$query->bindParam(':idproof',$idproof,PDO::PARAM_STR);

 $query->execute();

   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Maid detail has been added.")</script>';
echo "<script>window.location.href ='add-maid.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}
else
{

echo "<script>alert('Email-id,Employee Id or Mobile Number already exist. Please try again');</script>";
}
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Maid Hirirng Management System || Add Maid</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
     
   </head>
   <body class="inner_page general_elements">
        <div class="flex min-h-screen bg-gray-100">
            <?php include_once('includes/sidebar.php');?>
            <div class="flex-1 flex flex-col">
                <?php include_once('includes/header.php');?>
                <main class="flex-1 p-6 md:p-10">
                    <h2 class="text-3xl font-bold text-green-700 mb-8">Add Maid</h2>
                    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-8">
                        <form method="post" enctype="multipart/form-data" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">Category Name</label>
                                        <select name="catid" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                                            <option value="">Select Category</option>
                                            <?php
                                            $sql2 = "SELECT * from tblcategory";
                                            $query2 = $dbh -> prepare($sql2);
                                            $query2->execute();
                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            foreach($result2 as $row2) {
                                            ?>
                                            <option value="<?php echo htmlentities($row2->ID);?>"><?php echo htmlentities($row2->CategoryName);?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">Maid ID</label>
                                        <input type="text" name="maidid" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">Name</label>
                                        <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">Email</label>
                                        <input type="email" name="email" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">Gender</label>
                                        <select name="gender" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">Contact Number</label>
                                        <input type="text" name="contno" required maxlength="10" pattern="[0-9]+" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">Experience</label>
                                        <input type="text" name="experience" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">Date of Birth</label>
                                        <input type="date" name="dob" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">Address</label>
                                        <textarea name="add" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">Description (if any)</label>
                                        <textarea name="desc" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">Maid Pic</label>
                                        <input type="file" name="pic" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-lg font-semibold text-green-700 mb-2">ID Proof</label>
                                        <input type="file" name="idproof" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center pt-6">
                                <button type="submit" name="submit" id="submit" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-10 py-2 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg">Add</button>
                            </div>
                        </form>
                    </div>
                </main>
                <?php include_once('includes/footer.php');?>
            </div>
        </div>
   </body>
</html><?php } ?>