<?php
    session_start();

    $_SESSION['db']=new PDO('mysql:host=localhost;dbname=livreor', 'root' , '');

?>

<!DOCTYPE html>

<html>

	<head>
		<title>Live d'or</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="stylesheet" type='text/css' href="../css/livreor.css?v=<?php echo time(); ?>">
		<link rel="icon" href="" />
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

    <body id="body_livre">
        <?php
        $req=$_SESSION['db']->query("SELECT `commentaire`, `id_utilisateur`, DATE_FORMAT(`date`, '%D %b %Y') as `date` FROM `commentaires` ORDER BY `date`");
        $j=$req->rowCount();
        $result=$req->fetchAll();
        for($i=0;$i<$j;$i++){
            $id=$result[$i]['id_utilisateur'];
            $req=$_SESSION['db']->query("SELECT `login` FROM `utilisateurs` WHERE `id`='$id'");
            $login=$req->fetch(PDO::FETCH_ASSOC);
            ?><div class="mess_livreor">
                <p><?php echo $result[$i]['commentaire'];?></p>
                <p><?php echo"Ecrit par : " . $login['login'];?></p>
                <p><?php echo $result[$i]['date'];?></p>
            </div><?php
        }
        ?>
        <a href="../index.php">Accueil</a>
    </body>

</html>

<?php
    $_SESSION['db']=NULL;
?>