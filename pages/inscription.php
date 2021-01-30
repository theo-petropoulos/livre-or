<?php
    session_start();

    $_SESSION['db']=new PDO('mysql:host=localhost;dbname=livreor', 'root' , '');

    if(isset($_POST['login']) && $_POST['login'] && isset($_POST['password']) && $_POST['password'] && isset($_POST['cpassword']) && $_POST['cpassword']){
        $db=$_SESSION['db'];$login=$_POST['login'];$password=$_POST['password'];$cpassword=$_POST['cpassword'];
        if($password!==$cpassword){
            echo "Les mots de passe ne correspondent pas. Veuillez ";?><a href="inscription.php">Réessayer</a>.<?php 
        }
        else if(preg_match("/([%\$#\*.!&~\"\'{}\+^@=¤:|\/]+)/", $login)){
            echo "Vous utilisez des caractères interdits pour le login. Veuillez ";?><a href="inscription.php">Réessayer</a>.<?php 
        }
        else{
            $stmt=$db->prepare("SELECT * FROM `utilisateurs` WHERE `login`=?");
            $stmt->bindParam(1, $login, PDO::PARAM_STR);
            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            if(empty($result)){
                $password=password_hash($password, PASSWORD_DEFAULT);
                $insert=$db->prepare("INSERT INTO `utilisateurs` (`login`,`password`) VALUES (?,?)");
                $insert->execute([$login, $password]);
                echo "Votre inscription a bien été enregistrée.";?><a href="../index.php">Accueil</a><?php
            }
            else{
                echo "Ce nom d'utilisateur existe déjà. Veuillez ";?><a href="inscription.php">Réessayer</a>.<?php 
            }
        }
    }
?>


<!DOCTYPE html>

<html>

	<head>
		<title>Inscription</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="stylesheet" type='text/css' href="../css/livreor.css?v=<?php echo time(); ?>">
		<link rel="icon" href="" />
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

    <body id="body_inscription">
        <?php if(!isset($_POST) || empty($_POST)){?>
        <section id="subscr_section">
            <form method="post" action="inscription.php">
                <label for="login">Login :</label><br>
                <input type="text" name="login"><br>
                <label for="password">Password :</label><br>
                <input type="password" name="password"><br>
                <label for="cpassword">Confirm :</label><br>
                <input type="password" name="cpassword"><br>
                <input type="submit" value="Valider">
            </form>
        </section>
        <footer>
            <a href="../index.php">Accueil</a>
        </footer>
        <?php } ?>
    </body>
</html>

<?php
    $_SESSION['db']=NULL;
?>