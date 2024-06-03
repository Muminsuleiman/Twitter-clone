<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location:login.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css"> 


    <title>Document</title>
</head>
<body>

     
   
    
 

    <div class="menu">

    <img src="images/xxx.jpeg" alt="porofile">
        <Ul>
            <!-- <li class="active">
                <div class="img-box">
                    <img src="xxx.jpeg" alt="porofile">
                </div>
                
            </li> -->

            <li>
               <a href="index.php">
                <i class="fas fa-home"></i>
                <p>Home</p>
               </a>
            </li>

            <li>
               <a href="#">
                <i class="fas fa-search"></i>
                <p>Explore</p>
               </a>
            </li>

            <li>
                <a href="#">
                <i class="fa-regular fa-bell"></i>
                 <p>Notififcations</p>
 
                </a>
             </li>

             <li>
                <a href="#">
                <i class="fa-regular fa-message"></i>
                 <p>Tweet</p>
 
                </a>
             </li>


             <li>
                <a href="profile.php">
                <i class="fa-light fa-user"></i>
                 <p>Profile</p>
                </a>
             </li>

              <li class="log-out">
                <a href="index.html">
             
                 <p>Post</p>
                </a>
             </li> 

             <li class="log-out">
             <a href="logout.php" class="btn btn-warning">Logout</a>
             <i class="fas fa-sign-out"></i> 
                </a>
             </li>


        </Ul>
    </div>


      
<div class="content">


      <div class="center">
                             

         <a href="#">
         <i class="fa-solid fa-arrow-left"></i>
         <br><h3><?php echo $_SESSION['user']['name']; ?><br></h3>    
      </div>






      <div class="grijs2" >
       <div class="grijs" style = " background-image: url('uploads/<?php echo $_SESSION['user']['imageA']; ?>'); background-repeat: no-repeat; background-size: cover;">


       
      <img src="uploads/<?php echo $_SESSION['user']['imagee']; ?>" alt="porofile">

      </div> 

      </div> 


       






      <?php

      require('conn-db.php');
                $sql = "SELECT * FROM users ";
                $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $stmt = $conn->prepare($sql);
                // $stmt->execute();
                $foto1 = $stmt->fetchAll();
                // print_r($result);
                // echo count($result);
                // echo $result['title'];
                ?>


             
                    <?php
                    // https://www.php.net/manual/en/pdostatement.fetchall.php
                    // array_shift — Shift an element off the beginning of array
                    while ($foto1 = array_shift($foto1)) {

                        $sql = "SELECT * FROM users WHERE post_id = :image_src";
                        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':post_id', $image_src["id"]);
                        // $stmt->execute();
                        $foto1 = $stmt->fetchAll();
                    ?>
                         <div class="ui card"> 
                            <img src="uploads/<?php echo $foto1['image_src']; ?>"  alt="" style="width: 200px; height:100px; object-fit:cover; " class="ui t image">
                            
                            
                             
                                <div class="description">
                                    <?php echo substr($foto1['description'], 0, 30); ?>
                            </div>
                              
                              <br><br>
     <?php } ?>





                            


      <a href="edit_profile.php">
      <button class="edit-profile-btn">Edit Profile</button>
      </a>

  <br><br><br>

      <div class="profile7">




            <h3>  <?php echo $_SESSION['user']['name']; ?><br><br></h3>
            <h5>  <?php echo $_SESSION['user']['email']; ?><br><br></h5>
            <h5>  <?php echo $_SESSION['user']['tareg']; ?><br><br></h5>
    
            <h7>Joined January 2019</h7>



            

         <div class="button-container">
             <button class="button">Following: 23</button>
             <button class="button">Followers: 1</button>
         </div>
      </div>

   




  <nav>
  <a href="#">Posts</a>
  <a href="#">Replies</a>
  <a href="#">Highlights</a>
  <a href="#">Articles</a>
  <a href="#">Media</a>
  <a href="#">Likes</a>
 </nav>
        
<!-- </div>
 <div class="nap">
   <img src="images/testen.png"  alt="porofile">
</div>   -->

     
 
</body>
</html>