<?php
    session_start();

    $_SESSION['db']=new PDO('mysql:host=localhost;dbname=livreor', 'root' , '');

    if(isset($_POST['mlogin']) && $_POST['mlogin'] && isset($_POST['mpassword']) && $_POST['mpassword'] && isset($_POST['cmpassword']) && $_POST['cmpassword']){
        $db=$_SESSION['db'];
        $login=$_SESSION['login'];
        $mlogin=$_POST['mlogin']; $mpassword=$_POST['mpassword']; $cmpassword=$_POST['cmpassword'];
        $lflogin=$db->prepare("SELECT * FROM `utilisateurs` WHERE `login`=?");
        $lflogin->bindParam(1, $mlogin, PDO::PARAM_STR);
        $lflogin->execute();
        $result=$lflogin->fetch(PDO::FETCH_ASSOC);

        if($_POST['mpassword']!=$_POST['cmpassword']){
            echo "Les mots de passe ne correspondent pas. Veuillez ";?><a href="profil.php">Réssayer</a><?php
        }
        else if(preg_match("/([%\$#\*.!&~\"\'{}\+^@=¤:|\/]+)/", $mlogin)){
            echo "Vous utilisez des caractères interdits pour le login. Veuillez ";?><a href="profil.php">Réssayer</a><?php
        }
        else if(!empty($result)){
            echo "Ce nom d'utilisateur est déjà pris. Veuillez ";?><a href="profil.php">Réssayer</a><?php
        }
        else{
            $mpassword=password_hash($mpassword, PASSWORD_DEFAULT);
            $stmt=$db->prepare("UPDATE `utilisateurs` SET `login`=?, `password`=? WHERE `login`=?");
            $stmt->execute([$mlogin, $mpassword, $login]);
            echo "Votre compte a bien été mis à jour. Retour à l'"?>
                <form method="post" action="../index.php">
                    <input type="hidden" value="ok" name="connected">
                    <input type="submit" value="Accueil">
                </form>
                <?php
            $_SESSION['connected']='success';
            $_SESSION['login']=$mlogin;
        }
    }
?>

<!DOCTYPE html>

<html>

	<head>
		<title>Profil</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="stylesheet" type='text/css' href="../css/livreor.css?v=<?php echo time(); ?>">
		<link rel="icon" href="" />
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

    <body id="body_profile">
        <header>
            <h1>Modifier son profil</h1>
        </header>
            <?php
            $login=$_SESSION['login'];
            $db=$_SESSION['db'];
            $stmt=$db->prepare("SELECT * FROM `utilisateurs` WHERE `login`=?");
            $stmt->bindParam(1, $login, PDO::PARAM_STR);
            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            if(empty($result)){
                die("Vous ne pouvez pas afficher cette page.");
            }
            else if(!isset($_POST['mlogin'])){?>
                <form method="post" action="profil.php">
                    <label for="mlogin">Login :<br></label>
                    <input type="text" name="mlogin" value="<?php echo $result['login'];?>" required><br>
                    <label for="mpassword">Password :<br></label>
                    <input type="password" name="mpassword" placeholder="*****" required><br>
                    <label for="cmpassword">Confirm password :<br></label>
                    <input type="password" name="cmpassword" placeholder="*****" required>
                    <input type="submit" value="Valider">
                </form>
            <?php } 
            else{}?>
    <a href="../index.php">Accueil</a>
    </body>
</html>

<?php
    $_SESSION['db']=NULL;
?>