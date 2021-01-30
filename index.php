<?php
	session_start();
    
    $_SESSION['db']=new PDO('mysql:host=localhost;dbname=livreor', 'root' , '');

    if(isset($_POST['disconnect']) && $_POST['disconnect']=='ok'){
        unset($_SESSION['connected']);
        unset($_SESSION['login']);
    }
    
?>

<!DOCTYPE html>

<html>

	<head>
		<title>Accueil</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="stylesheet" type='text/css' href="css/livreor.css?v=<?php echo time(); ?>">
		<link rel="icon" href="" />
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

    <body id="body_accueil">
        <header>
            <h1>La Plateforme_</h1>
            <h2>Bed & Breakfast</h2>
            <h3>J'ai juste besoin de 3 points en SQL</h3>
            <details>
                <summary>Menu</summary>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <?php if(!isset($_SESSION['connected']) || empty($_SESSION['connected'])){?>
                        <li><a href="pages/connexion.php">Connexion</a></li>
                        <li><a href="pages/inscription.php">Inscription</a></li>
                        <?php }
                        else if(isset($_SESSION['connected']) && $_SESSION['connected']='success'){?>
                        <li><a href="pages/profil.php">Profil</a></li>
                        <li><a href="pages/commenter.php">Laisser un message</a></li>
                        <?php }?>
                        <li><a href="pages/livre-or.php">Livre d'Or</a></li>
                        <?php if(isset($_SESSION['connected']) && $_SESSION['connected']='success'){?>
                        <li><form method="post" action="index.php">
                            <input type="hidden" name="disconnect" value="ok">
                            <input type="submit" value="Déconnexion">
                            </form>
                        </li>
                        <?php } ?>
                    </ul>
            </details>
        </header>
    
        <main>
            <img src="assets/bbhouse.webp">
            <p>Bienvenue sur le site de notre gite "La Plateforme_" situé au coeur de Marseille.<br>
            <span id="alert">En cette période de crise sanitaire, votre Bed & Breakfast sera fermé jusqu'à nouvel ordre.</span>
            Vous avez séjourné chez nous et souhaitez nous laisser un mot ? <br>
            Vous êtes au bon endroit, nous lisons tous vos chaleureux messages et espérons vous retrouver dans les plus brefs délais.
            A très bientôt.</p>
        </main>

        <footer>
            <ul>
                <li><a href="">Contact</a></li>
                <li><a href="">Trouvez-nous</a></li>
                <li><a href="">Ils parlent de nous</a></li>
                <li><a href="">Mentions légales</a></li>
            </ul>
        </footer>
    </body>

</html>

<?php
    $_SESSION['db']=NULL;
?>