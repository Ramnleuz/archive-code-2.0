<?php
include "db_conn.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch the offense record to be archived
    $sql = "SELECT * FROM offense WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Insert the offense record into the archive table
        $archive_sql = "INSERT INTO archive (full_name, stud_no, offense, offense_no, sunction) 
                        VALUES (
                            '" . mysqli_real_escape_string($conn, $row['full_name']) . "', 
                            '" . mysqli_real_escape_string($conn, $row['stud_no']) . "', 
                            '" . mysqli_real_escape_string($conn, $row['offense']) . "', 
                            '" . mysqli_real_escape_string($conn, $row['offense_no']) . "', 
                            '" . mysqli_real_escape_string($conn, $row['sunction']) . "')";
        mysqli_query($conn, $archive_sql);

        // Delete the offense record from the main table
        $delete_sql = "DELETE FROM offense WHERE id = $id";
        mysqli_query($conn, $delete_sql);

        header("Location: archive.php?msg=Offense has been archived");
        exit();
    } else {
        header("Location: archive.php?msg=Error: Offense not found");
        exit();
    }
} else {
    $sql = "SELECT * FROM archive";
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Archived Offenses</title>
    <style>
        .narrow-search-box {
            max-width: 200px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
        Archived Cases
    </nav>
    <div class="row">
        <div class="container">
            <?php
            if (isset($_GET["msg"])) {
                $msg = htmlspecialchars($_GET["msg"]);
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                ' . $msg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
            ?>
            <table class="table table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Student No.</th>
                        <th scope="col">Offense</th>
                        <th scope="col">Number of Offenses</th>
                        <th scope="col">Sanction</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["full_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["stud_no"]); ?></td>
                            <td><?php echo htmlspecialchars($row["offense"]); ?></td>
                            <td><?php echo htmlspecialchars($row["offense_no"]); ?></td>
                            <td><?php echo htmlspecialchars($row["sunction"]); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
