<?php
    session_start();

    $_SESSION['db']=new PDO('mysql:host=localhost;dbname=livreor', 'root' , '');

    if(isset($_POST['comment']) && $_POST['comment']){
        $login=$_SESSION['login']; $db=$_SESSION['db']; $message=$_POST['comment']; $date=date('Y/m/d',time());
        $stmt=$db->prepare("SELECT * FROM `utilisateurs` WHERE `login`=?");
        $stmt->execute([$login]);
        $result_user=$stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($result_user)){
            echo "Vous n'avez pas l'autorisation d'effectuer ceci.";
            $_SESSION['db']=NULL;
            exit();
        }
        $id=$result_user['id'];
        $stmt=$db->prepare("SELECT * FROM `commentaires` WHERE `id_utilisateur`=?");
        $stmt->execute([$id]);
        $result_mess=$stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($result_mess) && $stmt->rowCount()>2){
            echo "Vous ne pouvez plus poster de message.";
            $_SESSION['db']=NULL;
            exit();
        }
        $stmt=$db->prepare("INSERT INTO `commentaires` (`commentaire`, `id_utilisateur`, `date`) VALUES (?,?,?)");
        $stmt->execute([$message, $id, $date]);
        echo "Nous vous remercions pour votre message. Retour à l'";?><a href="../index.php">Accueil</a><?php
    }

?>

<!DOCTYPE html>

<html>

	<head>
		<title>Laisser un message</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="stylesheet" type='text/css' href="../css/livreor.css?v=<?php echo time(); ?>">
		<link rel="icon" href="" />
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

    <body>
        <header>
            <h1>Laissez votre message</h1>
            <h2>B&B La Plateforme_</h2>
        </header>
        
        <main>  
            <?php
            $db=$_SESSION['db'];
            if(!isset($_SESSION['connected']) || !isset($_SESSION['login'])){
                echo "Vous ne pouvez pas accéder à cette page.";
                $_SESSION['db']=NULL;
                exit();
            }

            else if(!isset($_POST['comment']) || !$_POST['comment']){ ?>
            <form method="post" action="commenter.php">
                <label for="comment">Message :<br></label>
                <textarea name="comment" placeholder="J'ai trouvé mon séjour à La Plateforme_ ..." minlenght="30" maxlenght="500" rows="5" cols="40" required></textarea><br>
                <input type="submit" value="Envoyer">
            </form>
            <?php }
            
            else{}?>
            <a href="../index.php">Accueil</a>
        </main>
    
    </body>
</html>

<?php
    $_SESSION['db']=NULL;
?>  