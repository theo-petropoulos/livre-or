<?php
    session_start();

    $_SESSION['db']=new PDO('mysql:host=localhost;dbname=livreor', 'root' , '');

    if(isset($_POST['login']) && $_POST['login'] && isset($_POST['password']) && $_POST['password']){
        $db=$_SESSION['db'];$login=$_POST['login'];$password=$_POST['password'];
        $stmt=$db->prepare("SELECT * FROM `utilisateurs` WHERE `login`=?");
        $stmt->bindParam(1, $login, PDO::PARAM_STR);
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($result)){
            echo "Login ou mot de passe incorrect. Veuillez ";?><a href="connexion.php">Réssayer</a><?php
        }
        else{
            if(password_verify($password,$result['password'])){
                echo "Vous êtes maintenant connecté. Retour à l'";?>
                <form method="post" action="../index.php">
                    <input type="hidden" value="ok" name="connected">
                    <input type="submit" value="Accueil">
                </form>
                <?php
                $_SESSION['connected']='success';
                $_SESSION['login']=$login;
            }
            else{
                echo "Login ou mot de passe incorrect. Veuillez ";?><a href="connexion.php">Réssayer</a><?php
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

    <body>
        <?php if(!isset($_POST) || empty($_POST)){?>
        <section id="conn_section">
            <form method="post" action="connexion.php">
                <label for="login">Login :</label><br>
                <input type="text" name="login"><br>
                <label for="password">Password :</label><br>
                <input type="password" name="password"><br>
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