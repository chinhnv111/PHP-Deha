<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location:http://localhost:3000/login.html");
  exit;
}


?>

<?php

include_once __DIR__ . '/DB.php';
$connection = DB::getConnection(); // Dùng kết nối từ DB.php

// Tạo kết nối
include_once __DIR__ . "/User.php";
$data = User::all();
$users = $data['users'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];

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
      <h1>User list</h1>
    </div>
    <br>
    <h3>Search Name</h3>
    <form action="index.php" method="get">
      Search: <input type="text" name="ten">
      <button type="submit">Search</button>
    </form>

    <?php
    if (isset($_GET['ten'])) {
      $users = DB::searchByName($_GET['ten']);
      if (count($users) > 0) {
        foreach ($users as $user) {
          htmlspecialchars($user['name']) . '<br>';
        }
      } else {
        echo "Không tìm thấy kết quả.";
      }
    }
    ?>

    <br>

    <form action="logout.php" method="post">
      <button type="submit">Đăng xuất</button>
    </form>

    <?php if (isset($_SESSION['message'])) { ?>
      <div
        class="alert alert-warning alert-dismissible fade show" role="alert">
        <p>
          <?php echo ($_SESSION['message']);
          unset($_SESSION['message']) ?>
        </p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php } ?>
    <a href="/create.php" class="btn btn-primary">Create</a>
    <div>
      <?php if (count($users) > 0) { ?>

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
            <?php foreach ($users as $user) { ?>
              <tr>
                <th scope="row"><?php echo $user["id"] ?></th>
                <td><?php echo $user["name"] ?></td>
                <td><?php echo $user["email"] ?></td>
                <td>
                  <a href="./show.php?id=<?= $user['id'] ?>" class="btn btn-info">Show</a> <!--Tạo nút màu xanh nhạt (info).-->
                  <a href="./edit.php?id=<?= $user['id'] ?>" class="btn btn-warning">Edit</a> <!--Tạo nút màu xanh nhạt (info).-->
                  <form action="./delete.php" method="post" id="formDelete-<?= $user['id'] ?>">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <button class="btn btn-danger btn-delete" id="<?= $user['id'] ?>">Delete</button> <!--Tạo nút canh bao ma trong the a laji khoong co (info).-->
                  </form>
                </td>
              </tr>
            <?php } ?>


          </tbody>
        </table>

        <!-- Phân trang -->
        <nav>
          <ul class="pagination">
            <?php if ($currentPage > 1) { ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a>
              </li>
            <?php } ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
              <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php } ?>

            <?php if ($currentPage < $totalPages) { ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a>
              </li>
            <?php } ?>
          </ul>

        <?php } else { ?>
          <h2>No Data.</h2>
        <?php } ?>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function(event) {
          event.preventDefault();
          let formId = this.getAttribute('data-form-id'); // Lấy ID form
          if (confirm("Bạn có chắc chắn muốn xóa người dùng này không?")) {
            document.getElementById(formId).submit();
          }
        });
      });
    });
  </script>
</body>

</html>