<?php
  include_once __DIR__. "/User.php";
    $users  = User::all();
    $id = null;
  $user = null;
  if($_GET['id'])
  {
  $id = $_GET['id'];
  $user = User::find($id);
  }else{
      header("location:./index.php");
  }
  $error = [];


  function validateField($request, $key){
    return isset($request[$key]) && $request[$key] != "" ? "": "$key is required";
  }
  function validate($request, $key){
    $results =[];
    foreach ($key as $key){
        $error = validateField($request, $key);
        if($error != ""){
            $results[$key] = $error;
        }
    }
    return $results;

  }

  if(isset($_POST['edit'])){
    $errors = validate($_POST,['name','email','password']);
    if(count($errors) <= 0 )
    {
        $dataUpdate = [
            'id' => $user['id'],
            'name' =>$_POST['name'], 'email' =>$_POST['email'], 'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];



        $user = User::update($dataUpdate);
        $_SESSION['message'] = "Update succcess";
        $errors = [];
        header("location:./index.php");
    }
    }
  
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <div>
            <h1>Edit User</h1>
        </div>
        <div>
        <form method="post">


  <div class="mb-3"> 
  <!-- (margin-bottom) -->
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input type="email" name = "email" value="<?= $user['email']?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="text-danger"></div>
    <?php echo isset($errors['email']) ? $errors['email'] :"" ?>
  </div>


  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Name</label>
    <input type="text" name = "name" value="<?= $user['name']?>"class="form-control" >
    <div id="emailHelp" class="text-danger"></div>
    <?php echo isset($errors['name']) ? $errors['name'] :"" ?>
  </div>


  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name = "password"class="form-control" id="exampleInputPassword1">
    <div id="emailHelp" class="text-danger"></div>
    <?php echo isset($errors['password']) ? $errors['password'] :"" ?>
  </div>


  <button type="submit" name ="edit" class="btn btn-primary">Update</button>
</form>



        </div>

        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
