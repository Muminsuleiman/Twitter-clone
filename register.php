<?php
session_start();
if(isset($_SESSION['user'])){
    header('location:profile.php');
    exit();
}
if(isset($_POST['submit'])){

include 'conn-db.php';

   $name = $_POST['name'];
   $password = $_POST['password'];
   $email = $_POST['email'];

   $errors=[];
   // validate name
   if(empty($name)){
       $errors[]="De naam moet geschreven zijn";
   }elseif(strlen($name)>100){
       $errors[]="De naam mag niet langer zijn dan 100 tekens ";
   }

   // validate email
   if(empty($email)){
    $errors[]="Je moet een e-mail schrijven";
   }elseif(filter_var($email,FILTER_VALIDATE_EMAIL)==false){
    $errors[]="Email is ongeldig";
   }


   $stm="SELECT email FROM users WHERE email ='$email'";
   $q=$conn->prepare($stm);
   $q->execute();
   $data=$q->fetch();

   if($data){
     $errors[]="De email bestaat wel";
   }


   // validate password
   if(empty($password)){
        $errors[]="Je moet je wachtword schrijven";
   }elseif(strlen($password)<6){
    $errors[]="De wachtword moet minmaal 6 letters lang zijn  ";
}



   // insert or errros 
   if(empty($errors)){
      // echo "insert db";
     $password=password_hash($password,PASSWORD_DEFAULT);
      $stm="INSERT INTO users (name,email,password) VALUES ('$name','$email','$password')";
      $conn->prepare($stm)->execute();
      $_POST['name']='';
      $_POST['email']='';

    //   $last_id = $conn->lastInsertId();

    //   $_SESSION['user']=[
    //  "name"=>$name,
    //  "email"=>$email,
    //  "id"=>$last_id,
     

    //  ];
    
      header('location:login.php');
    echo "Je account is regegistreed";
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="container">

<form action="register.php" method="POST">

    <?php 
        if(isset($errors)){
            if(!empty($errors)){
                foreach($errors as $msg){
                    echo $msg . "<br>";
                }
            }
        }
    ?>




   <div class="form-group">

    
    <input type="text"  class="form-control" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>" name="name" placeholder="name"><br><br>
    <input type="email"  class="form-control"  value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" name="email" placeholder="email"><br><br>
    <input type="password" class="form-control"  name="password" placeholder="password"><br><br>

    
    <input type="submit"   class="btn btn-primary" name="submit" value="Register">
    <br><br>
    
    <a href="login.php">login</a><br><br><br>

</form>
</div>

</div>
</body>
</html>