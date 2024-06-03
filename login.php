
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
 
<?php

session_start();

if(isset($_SESSION['user'])){

    header('location:profile.php');

    exit();

}

if(isset($_POST['submit'])){

include 'conn-db.php';

   $password=filter_var($_POST['password'],FILTER_SANITIZE_STRING);

   $email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
 
   $errors=[];

 
   // validate email

   if(empty($email)){

    $errors[]="U moet het email typen";

   }
 
 
   // validate password

   if(empty($password)){

        $errors[]="U moet het wachtwoord typen";

   }
 
 
   // insert or errros 

   if(empty($errors)){

      // echo "check db";
 
    $stm="SELECT * FROM users WHERE email ='$email'";

    $q=$conn->prepare($stm);

    $q->execute();

    $data=$q->fetch();

    if(!$data){

       $errors[] = "login fout";

    }else{

         $password_hash=$data['password']; 

         if(!password_verify($password,$password_hash)){

            $errors[] = "login fout";

         }else{

            $_SESSION['user']=[

                "name"=>$data['name'],

                "email"=>$data['email'],

                "imagee"=>$data['image_src'],

                "id"=>$data['id']

              ];

            header('location:profile.php');
 
         }

    }


   }

}
 
?>
 
 
<form action="login.php" method="POST">

<?php 

        if(isset($errors)){

            if(!empty($errors)){

                foreach($errors as $msg){

                    echo $msg . "<br>";

                }

            }

        }

    ?>

    <input type="text" class="form-control" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" name="email" placeholder="email"><br><br>

    <input type="password" class="form-control" name="password" placeholder="password"><br><br>

    <input type="submit"  class="btn btn-primary" name="submit" value="Login">

    <br><br>

    <a href="register.php">register</a><br><br><br>

</form>
 
</div>

</body>

</html>