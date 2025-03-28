<?php

include_once "./User.php";

$id = null;
$user = null;
if($_GET['id'])
{
$id = $_GET['id'];
$user = User::find($id);
}else{
    header("location:./index.php");
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CURD User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <div>
            <h1>Show User</h1>
        </div>
        <?php if($user){ ?>
            <h1>User Information</h1>

            <h3>Name: <?= $user['name'] ?></h3>
            <h3>Email: <?= $user['email'] ?></h3>
        <?php }else{ ?>
            <h1>User Not Found.</h1>
        <a href="/create.php"class="btn btn-primary">Back to List</a>
        <?php } ?>
        <div>
          <?php if(count($users)>0){ ?>

        <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($users as $user){ ?>
    <tr>
      <th scope="row"><? $user['id'] ?></th>
      <td><?php echo $user["name"]?></td>
      <td><?php echo $user["email"]?></td>
      <td>
      <a href="./show.php?id=<?= $user['id']?>" class="btn btn-info">Show</a>  <!--Tạo nút màu xanh nhạt (info).-->
      <a href="" class="btn btn-warning">Edit</a>  <!--Tạo nút màu xanh nhạt (info).-->
      <button class="btn btn-danger">Delete</button>  <!--Tạo nút canh bao ma trong the a laji khoong co (info).-->

      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

              <?php }else{ ?>
                <h2>Dữ liệu không tồn tại.</h2>
              <?php } ?>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
