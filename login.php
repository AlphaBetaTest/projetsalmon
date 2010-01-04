<?php

/* Gestion des messages d'information */
switch ($_GET['etat'])  {
	case "1" : echo '<p class="warning">Mauvais nom d\'utilisateur et/ou mot de passe.<p/>'; 
	break;
	
	case "2" : echo '<p class="granted">Modification du mot de passe effectuée avec succes.<p/>'; 
	break;
	
	default :
	break;
}

/*
* Fonction login() :
* Permet de s'identifier en tant qu'utilisateur (retourne le formulaire) et de créer l'objet correspondant (prof ou éleve). 
*/
function login() {
	
	if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['pass'])) // On a validé le formulaire
	{
		  extract($_POST);  
		  // on recupère le password de la table qui correspond au login du visiteur
		  $sql = "SELECT * FROM " . $liste . " WHERE login='".$login."'";  // pour pouvoir avoir droit
		  $req = mysql_query($sql) or die('Erreur SQL !<br>Nom inexistant dans la base de donn&eacute;es !<br>');

		  $data = mysql_fetch_assoc($req);
		  
		  if($data['pwd'] != md5($pass)) // Si le mot de passe n'est pas bon
		  {
		    header("Location: index.php?page=login&etat=1");
		  }
		  else 
		  {
			if ($liste == "eleves")
				$objet = new eleves($login);
			else if ($liste == "prof")
				$objet = new prof($login);
			
		    $_SESSION['objet'] = serialize($objet);
			
			header("Location: index.php?page=accueil");
		  }    		 
	}
	else // On arrive sur la page pour la premiere fois
	{
		echo '<h1>Zone d\'identification</h1>
		<br/>
		<form action="?page=login" method="post">
			<table>
				<tr>
		  			<td>Catégorie :</td>
		  			<td><select name="liste">
		  					<option value="eleves">Eleve</option>
		  					<option value="prof">Enseignant</option>
		  				</select>
					</td>
		  		</tr>  
		 		<tr>	
		    		<td>Login : </td>
		    		<td><input type="text" name="login"/></td>
		  		</tr>
		  		<tr>
		    		<td>Password : </td>
		    		<td><input type="password" name="pass" /></td>
		  		</tr>
		  		<tr>
			    	<td colspan="2"><input type="submit" value="log in"/></td>
		  		</tr>
			</table>
		</form>'; 
	}
	
}

/*
* Fonction logout() :
* Permet de se déconnecter en détruisant toutes les sessions courantes
*/
function logout() {

	$_SESSION = array();
	session_destroy();
	echo '<p class="warning">Vous avez été déconnecté. Redirection dans quelques secondes.<p/>
			<script type="text/javascript">redirection("login");</script>';
}

/*
* Fonction modifPass() :
* Permet de modifier le mot de passe d'un utilisateur
*/
function modifpass()
{
	echo '<h1> Modification du mot de passe</h1>';
		echo '<p>
				<form action="?page=login&action=modif" method="post" name="formulaire">
			  		<table>
						<tr>
							<td>Ancien mot de passe : </td><td><input type="password" size="20" name="oldpass"/></td>
						</tr>
						<tr>
							<td>Nouveau mot de passe : </td><td><input type="password" size="20" name="pass"/></td>
						</tr>
						<tr>
							<td>Nouveau mot de passe : </td><td><input type="password" size="20" name="passverif"/></td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" size="20" value="OK"/></td>
					</table>
				</form>
			</p><br />';

			if (isset($_POST['oldpass']) && isset($_POST['oldpass']) && isset($_POST['passverif'])) // Si le formulaire n'est pas vide
			{
				$objet = unserialize($_SESSION['objet']);
				
				if ($objet->compare_mdp($_POST['oldpass'])) // Vérification de l'ancien password
				{
					if ($_POST['pass'] == $_POST['passverif']) // Vérification du nouveau password
					{
						$objet->changer_pass($_POST['pass']);
						header("Location: index.php?page=login&action=modif&etat=2");
					}
					else
					{
					echo 'Les nouveaux mots de passes ne correspondent pas, veuillez rééssayer.';
					}
				}
				else
				{
				echo 'Ancien mot de passe incorrect.';
				}
			}
			else
			{
				echo 'Tout les champs sont obligatoires';
			}
}

/* Appel des fonctions suivant le parametre */
switch($_GET['action']) {

    default:
    login();
    break;

    case "logout":
    logout();
    break;
	
	case "modif":
	modifpass();
	break;
}
?>