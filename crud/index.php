<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Book List</title>
    <style>
        body {
            background-color: #fff5e1; 
            color: #333;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table td, table th {
            vertical-align: middle;
            text-align: center;
            padding: 10px;
            background-color: #f2e4c6;
            color: #333;
        }

        /* Hapus gaya tabel bawaan Bootstrap */
        table {
            margin-bottom: 0;
        }
    </style>

</head>
<body>
    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>Book List</h1>
            <div>
                <a href="create.php" class="btn btn-primary">Add New Book</a>
            </div>
        </header>
        <?php
        if (isset($_SESSION["create"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["create"];
            ?>
        </div>
        <?php
        unset($_SESSION["create"]);
        }
        ?>
         <?php
        if (isset($_SESSION["update"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["update"];
            ?>
        </div>
        <?php
        unset($_SESSION["update"]);
        }
        ?>
        <?php
        if (isset($_SESSION["delete"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["delete"];
            ?>
        </div>
        <?php
        unset($_SESSION["delete"]);
        }
        ?>

        <form method="GET" action="index.php" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Judul">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <?php
        include('connect.php');

        if(isset($_GET['search'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $sqlSearch = "SELECT * FROM books WHERE title LIKE '%$search%'";
            $result = mysqli_query($conn, $sqlSearch);
        } else {
            // Jika tidak ada query pencarian, ambil semua catatan
            $sqlSelect = "SELECT * FROM books";
            $result = mysqli_query($conn, $sqlSelect);
        }
        ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($data = mysqli_fetch_array($result)){
                ?>
                <tr>
                    <td><?php echo $data['id']; ?></td>
                    <td><?php echo $data['title']; ?></td>
                    <td><?php echo $data['author']; ?></td>
                    <td><?php echo $data['type']; ?></td>
                    <td>
                        <a href="view.php?id=<?php echo $data['id']; ?>&search=<?php echo $search; ?>" class="btn btn-info">Baca Selengkapnya</a>
                        <a href="edit.php?id=<?php echo $data['id']; ?>&search=<?php echo $search; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete.php?id=<?php echo $data['id']; ?>&search=<?php echo $search; ?>" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
