<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['agent_id'] == 0)) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Grocery Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Grocery Items</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>S.No</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tblgrocery";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                        foreach ($results as $row) {
                    ?>
                    <tr>
                        <td><?php echo htmlentities($cnt); ?></td>
                        <td>
                            <img src="<?php echo htmlentities($row->ImagePath); ?>" alt="Product Image" style="max-width: 100px;">
                        </td>
                        <td><?php echo htmlentities($row->ProductName); ?></td>
                        <td><?php echo htmlentities($row->Description); ?></td>
                        <td><?php echo htmlentities($row->Price); ?> USD</td>
                        <td>
                            <a href="edit-grocery.php?editid=<?php echo htmlentities($row->ID); ?>" class="btn btn-success btn-sm">Edit</a>
                            <a href="delete-grocery.php?delid=<?php echo htmlentities($row->ID); ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php $cnt++; }
                    } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">No Grocery Items Found</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>
