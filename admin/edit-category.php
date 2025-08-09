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
      <title>Maid Hiring Management System || Update Category</title>
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <link rel="stylesheet" href="style.css" />
      <link rel="stylesheet" href="css/responsive.css" />
      <link rel="stylesheet" href="css/colors.css" />
      <link rel="stylesheet" href="css/bootstrap-select.css" />
      <link rel="stylesheet" href="css/perfect-scrollbar.css" />
      <link rel="stylesheet" href="css/custom.css" />
      <link rel="stylesheet" href="js/semantic.min.css" />
   </head>
   <body class="inner_page general_elements">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
            <?php include_once('includes/sidebar.php'); ?>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
               <?php include_once('includes/header.php'); ?>
               <!-- end topbar -->
               <!-- dashboard inner -->
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12 text-left">
                           <div class="page_title">
                              <h2>Update Category</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row --> 
                     <div class="row column8 graph">
                        <div class="col-md-6 md-3">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0 text-center">
                                    <h2>Update Category</h2>
                                 </div>
                              </div>
                              <div class="full progress_bar_inner">
                                 <div class="row ms-auto">
                                    <div class="col-md-12">
                                       <div class="full">
                                          <div class="padding_infor_info">
                                             <div class="alert alert-primary" role="alert">
                                                <form method="post">
                                                   <?php
                                                      $eid = $_GET['editid'];
                                                      $sql = "SELECT * FROM tblcategory WHERE ID=$eid";
                                                      $query = $dbh->prepare($sql);
                                                      $query->execute();
                                                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                      if ($query->rowCount() > 0) {
                                                         foreach ($results as $row) {
                                                   ?>
                                                   <fieldset class="text-center mx-auto">
                                                      <div class="field">
                                                         <label class="label_field d-block mb-2" style="font-size: 14px;">Category Name</label>
                                                         <input type="text" name="catname" value="<?php echo htmlentities($row->CategoryName); ?>" class="form-control" required="true" style="max-width: 300px; margin: 0 auto; height: 35px;">
                                                      </div>

                                                      <br>
                                                      <div class="field margin_0 text-center">
                                                         <button class="main_bt btn btn-primary" type="submit" name="submit" style="max-width: 300px; margin: 0 auto; height: 35px;" id="submit">Update</button>
                                                      </div>
                                                   </fieldset>
                                                   <?php 
                                                         }
                                                      }
                                                   ?>
                                                </form>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php include_once('includes/footer.php'); ?>
            </div>
         </div>
      </div>
      <!-- jQuery -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/animate.js"></script>
      <script src="js/bootstrap-select.js"></script>
      <script src="js/owl.carousel.js"></script> 
      <script src="js/Chart.min.js"></script>
      <script src="js/Chart.bundle.min.js"></script>
      <script src="js/utils.js"></script>
      <script src="js/analyser.js"></script>
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <script src="js/custom.js"></script>
      <script src="js/semantic.min.js"></script>
   </body>
</html>
