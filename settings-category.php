<?php
    include 'backend.php';
    $backend = new Backend;

    $backend->checksession();
    $method = $backend->listCategory();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@600&display=swap"
      rel="stylesheet"
    />
    <style>
        body{
            background-image:linear-gradient(#4990b5,skyblue);
        }
    </style>
    <title>Payment-settings</title>
</head>
<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row rounded-3 shadow bg-dark bg-gradient text-center">
            <?php
                if (isset($_GET['btn'])) {
                    if ($_GET['btn'] == 'add') {
            ?>
                <div class="col-12 p-2 text-success">
                    <h2><i class="bi bi-plus-circle"> Add Category</i></h2>
                </div>
                <div class="col-12">
                    <form action="">
                        <input type="text" name="name" class="form-control" placeholder="Category Name" required>
                        <textarea name="desc" cols="10" rows="2" class="form-control my-2" placeholder="Description here" required></textarea>
                        <button type="submit" name="savebtn" value="save" class="btn btn-success form-control my-3">Save</button>
                        <a href="settings-other.php" class="btn btn-danger form-control">Cancel</a>
                    </form>
                </div>
            <?php
                    }
                    elseif ($_GET['btn'] == 'edit') {
            ?>
                <div class="col-12 p-2 text-warning">
                    <h2><i class="bi bi-plus-circle"> Edit Category</i></h2>
                </div>
                <div class="col-12">
                    <form action="">
                        <input type="hidden" name="cat_id" value="<?=$_GET['id']?>">
                        <input type="text" name="name" class="form-control" value="<?=$_GET['name']?>" placeholder="Category Name" required>
                        <textarea name="desc" cols="10" rows="2" class="form-control my-2" placeholder="Description here" required><?=$_GET['desc']?></textarea>
                        <button type="submit" name="editbtn" value="save" class="btn btn-success form-control my-3">Save</button>
                        <a href="settings-other.php" class="btn btn-danger form-control">Cancel</a>
                    </form>
                </div>
            <?php
                    }
                    elseif ($_GET['btn'] == 'del') {
                        $backend->delCategory($_GET['id']);
                    }
                }
                if (isset($_GET['savebtn'])) {
                    $name = $_GET['name'];
                    $desc = $_GET['desc'];
                    $backend->addCategory($name,$desc);
                 }
                 elseif (isset($_GET['editbtn'])) {
                    $name = $_GET['name'];
                    $desc = $_GET['desc'];
                    $id = $_GET['cat_id'];

                    $backend->editCategory($id,$name,$desc);
                 }
            ?>
        </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
</body>
</html>