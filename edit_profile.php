
<?php

session_start();

if(!isset($_SESSION['user'])){

    header('location: login.php');

    exit();

}

include 'conn-db.php'; // Verbinding met de database

if(isset($_POST['edit_profile'])) {

    $file_name = $_FILES['image4']["name"];
    $file_tmp_name = $_FILES['image4']["tmp_name"];

    $file_achter = $_FILES['image5']["name"];
    $file_tmp_ground = $_FILES['image5']["tmp_name"];


    $melaad = $_POST['datum'];

    
    $name = $_POST['name'];
    $email = $_POST['email'];      



    $user_id = $_SESSION['user']['id'];

echo $user_id;

    try {

        move_uploaded_file($file_tmp_name, "uploads/" . $file_name);  

        move_uploaded_file($file_tmp_ground, "uploads/" . $file_achter);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Voorbereid SQL-statement voor update

        

        $sql = "UPDATE users SET name = :name, email = :email,  image_src = :image_src, image_achter = :image_achter, datum = :datum WHERE id = :id";

        

        // Prepareer het statement

        $stmt = $conn->prepare($sql);

        // Bind parameters

        $stmt->bindParam(':image_src', $file_name);

        $stmt->bindParam(':image_achter', $file_achter);

        $stmt->bindParam(':name', $name);

        $stmt->bindParam(':email', $email);

        $stmt->bindParam(':datum', $melaad);

        $stmt->bindParam(':id', $user_id);

        

        // Voer het statement uit

        $stmt->execute();

        // Bericht tonen als de update gelukt is

        echo "Profiel succesvol bijgewerkt.";

        $_SESSION['user']['name'] = $name; // Update session data with new name

        $_SESSION['user']['email'] = $email; // Update session data with new email


        $_SESSION['user']['imagee'] = $file_name; // Update session data with new email


        $_SESSION['user']['imageA'] = $file_achter; // Update session data with new email


        $_SESSION['user']['tareg'] = $melaad; // Update session data with new email




        


    } catch(PDOException $e) {

        echo "Error: " . $e->getMessage();

    }

}

$conn = null;

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <title>Profiel bewerken</title>

</head>

<body>

<br>

<h2>Profiel bewerken</h2>

<br>

<div class="container">


<form action="" method="POST" enctype="multipart/form-data" >

<div class="form-group">

    <label for="name">Naam:</label><br>

    <input type="text"  class="form-control" id="name" name="name" value="<?php echo $_SESSION['user']['name']; ?>"><br><br>

    <label for="email">E-mail:</label><br>


    <input type="email" class="form-control"  id="email" name="email" value="<?php echo $_SESSION['user']['email']; ?>"><br><br>


    <input type="file" class="form-control"  id="image4" name="image4" value="wijzig je foto"  multiple="multiple" ><br><br>

    
    <input type="file" class="form-control"  id="image5" name="image5"  multiple="multiple" ><br><br>


    <input type="date" class="form-control"  id="datum" name="datum" ><br><br>
    
    <br><br>

    <input type="submit" class="btn btn-primary"  name="edit_profile" value="Bewerk Profiel">



</form>
</div>

</div>

</body>

</html>