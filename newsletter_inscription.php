<html>
	<head>
    	<title>Inscription</title>
    </head>
	<body>
    	<p>
            <?php
			if($nom && $prenom && $mail)
			
				$nom = $_POST['nom'];
				$prenom = $_POST['prenom'];
				$mail = $_POST['mail'];
				// connexion à la base
				$db = mysql_connect('localhost', 'root', '')  or die('Erreur de connexion '.mysql_error());
				// sélection de la base 
				mysql_select_db('bdd',$db)  or die('Erreur de selection '.mysql_error());
				
				//on regarde si le nom est vide
				if(empty($nom)){
					//si oui, on déclare l'erreur
					echo "vous n'avez pas renseigner votre nom";
				}
				
				//on regarde si le champ email est vide
				if(empty($mail)){
					echo "vous n'avez pas renseigner votre email";
				}
				
				//si le champ email n'est pas vide on regarde si l'email est valide
				else if(!preg_match("/^[a-z0-9\-_.]+@[a-z0-9\-_.]+\.[a-z0-9]{2,3}$/i",$mail)){
					echo "Votre email n'est pas valide";
				}
				 
				// on écrit la requête sql
    			$sql = "INSERT INTO personne(id_personne, Nom, Prenom, Mail) VALUES('', '$nom', '$prenom', '$mail')";
				
				$to = "servicelogic@gmail.com";
				$sujet = $nom. $prenom." a envoye une demande via le formulaire du site" ;
				$header = "From: logic@gmail.com \n";
				$message = "Mon message";
				//$header .= "Reply-To: $mail";
				
				//on appel la fonciton mail de php
				if (mail($to,$sujet,$message,$header)){
					echo "Votre demande nous ai bien parvenu";
					unset($nom);
					unset($prenom);
					unset($mail);
				}
				else
				{
					echo "Une erreur est survenue et votre demande n'a pas aboutit";
				}
				// on insère les informations du formulaire dans la table
    			mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error()); 
				mysql_close();
			?>
        </p>
    </body>
</html>