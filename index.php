<?php session_start();?>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Se connecter</title>

  <script src="https://kit.fontawesome.com/26c1d388d0.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="container">

<?php
//connection to the db 
  include('connect.php');
  try {
      $sql="SELECT * FROM connectAdmin";
      $stmt = $bdd->prepare($sql);
      $stmt->execute();
      } catch (Exception $e) {print "Erreur ! " . $e->getMessage() . "<br/>";}
      // $results=$stmt->fetchAll(PDO::FETCH_ASSOC);
      // print_r($results);

      while($results=$stmt->fetch(PDO::FETCH_ASSOC)) {
        // print_r($results);
        // echo '<hr>';

         //if connected and logged in db, display it on page browser 
         echo "<h2>L'utilisateur " .$results['login'];
    
         //split the date and the time
         $la_date = $results['date_connect'];

         $la_date = explode(' ', $la_date);
         //below I split the date in 3 boxes
         $jour = explode("-",$la_date[0]);
        // print_r($jour);
        

        //  print_r($la_date);

        //below, I display the date in french format
         echo " s'est connecté le " .$jour[2] ." "  .$jour[1] ." " .$jour[0];
    
         echo " à " .$la_date[1]; 
        
         echo " avec le mdp " .$results['pass'].'</h2>';
      }
?>

<!-- here we want to fetch the infos from the form -->
<?php
  $login = "aaa";
  $pass = "123";

  //deconnect session
  if(isset($_POST['deconnect'])){ 
    unset($_SESSION['connect']);
  }
  
  if(isset($_POST['connect'])){ 
      print_r($_POST); //to display the array key : value
      echo'<hr>';
      //to fetch all the inputs form
      foreach ($_POST as $key => $value){ 
        echo $key. '=> '.$value. '<br>';
      }

    echo 'Le login envoyé est: ' .strip_tags($_POST['login']);
    echo '<br>Le pass envoyé est: ' . $_POST['pass'];
    echo '<hr>';

    //INSERT 
    $login= strip_tags($_POST['login']);
    $pass= strip_tags($_POST['pass']);

    try {
      $sql="INSERT INTO connectAdmin SET login=?, pass=?, ip=?";  //ID is in AI and DATE is current
      $stmt = $bdd->prepare($sql);
      $stmt->execute( array($_POST['login'], $_POST['pass'], $_SERVER['REMOTE_ADDR']));
    } catch (Exception $e) {print "Erreur ! " . $e->getMessage() . "<br/>";}
      // $results=$stmt->fetchAll(PDO::FETCH_ASSOC);
      // print_r($results);
      echo '<hr>';

    //to test login :
    if ($login == $_POST['login']) {
      $testLogin = "bon";
    } else {
      $testLogin = "erroné";
    }
    echo '<br> Votre Login est ' . $testLogin;

    //to test pass :
    if ($pass == $_POST['pass']) {
      $testPass = "bon";
    } else {
      $testPass = "erroné";
    }
    echo '<br> Votre pass est ' . $testPass;

    if ($testPass =='bon' && $testLogin=='bon') {
    echo '<br> Tout est ok';
    $_SESSION['connect']=1;
    }
}

// echo '<hr>Votre adresse IP est ' . $_SERVER['REMOTE_ADDR'];
?>

<!-- Si connecté, le dire -->
<?php
if(isset($_SESSION['connect'])) { 

  echo'<H2>Vous etes connecté.</h2>';?>
  <form method="post">
    <button type="submit" name="deconnect">Se déconnecter</button>
  </form>
<?php }
?>

<?php
//if not connected
if(!isset($_SESSION['connect'])){  ?>

<!-- Si non connecté,  proposer le form -->
<form class="form-1" method="post">
      <h1>Se connecter</h1>
      <p><?php echo '<hr>Votre adresse IP est ' . $_SERVER['REMOTE_ADDR']; ?> </p>
      <br>

      <!-- <label for="email">Email</label> -->
      <input type="text" name="login" id="email" />
      <br>
      <!-- <label for="password">Password</label> -->
      <input type="text" name="pass" id="password" />
      <br>
      <div class="icons">
        <div>
          <button><i class="fa-solid fa-martini-glass"></i></button>
          <button><i class="fa-solid fa-magnifying-glass"></i></button>
          <button><i class="fa-solid fa-arrow-pointer"></i></button>
          <button><i class="fa-solid fa-leaf"></i></button>
          <button><i class="fa-solid fa-thumbs-up"></i></button>
          <button><i class="fa-solid fa-star"></i></button>
          <button><i class="fa-solid fa-sun"></i></button>
        </div>
      </div>

      <p>Cliquer sur l'étoile</p>

      <input class="button" type="submit" name="connect" value="Se connecter">
    </form>
<?php } ?>
  </div>
</body>
</html>