<?php 
$objet = unserialize($_SESSION['objet']);
if ($_SESSION['objet'] != "" && $objet->get_droit(1))
{
	
	if (isset($_GET['mode']) && $_GET['mode'] == "Modifier")
	{		
		$user = mysql_query("SELECT * FROM " . $_GET['type'] . " WHERE login='" . $_GET['log'] . "'");
		$user = mysql_fetch_assoc($user); 
	}

	// traitement formulaire
	if ($_POST['nom'] != "" && $_POST['prenom'] != "" && $_POST['mdp'] != "" && $_POST['mdp2'] != "" && $_POST['login'] != "")
	{	
		$objet->ajouter_utilisateur($_POST['mdp'], $_POST['mdp2'], $_POST['gen'], $_POST['mode'], $_POST['type'], $_POST['nom'], $_POST['prenom'], $_POST['groupe'], $_POST['login'], $_POST['niveau'], $_POST['loginold']);	
		
		echo 'Utilisateur ajouté ou modifié ! Vous allez etre redirigé.
		<script type="text/javascript">redirection("gestion_utilisateur");</script>';		
	}
	else
	{
		echo 'Tous les champs sont obligatoires';
	}
	
    echo '<h1>Ajout d\'un utilisateur</h1>

	<form name="form" method="post" action="?page=ajouter_utilisateur" >			
	Nom : <input type="text" size="30" name="nom" value="' . $user['nom'] . '" /><br/>
	Prénom : <input type="text" size="30" name="prenom" value="' . $user['prenom'] . '" /><br/>';
	
		if ($_GET['type'] == "eleves" || $_POST['type'] == "eleves") 
		{
			echo 'Groupe : <select name="groupe">';
			$groupe = mysql_query("SELECT distinct(groupe) FROM eleves ORDER BY groupe ASC");
			while ($groupes = mysql_fetch_array($groupe))
			{
				echo '<option';
				if ($user['groupe'] == $groupes['groupe'])
					echo ' selected="selected"';
				echo ' value="' . $groupes['groupe'] . '"> ' . $groupes['groupe'] . ' </option>';
			}
			echo '</select><br/>';
		}
	
	echo 'Login : <input type="text" size="30" name="login" value="' . $user['login'] . '" /><br/>
	Mot de passe : <input type="password" size="30" name="mdp" /> &nbsp; &nbsp; Resaisir mot de passe : <input type="password" size="30" name="mdp2" /><br/>
	Niveau : <select name="niveau">
				<option>A2</option>
				<option>LP</option>
				<option>AS</option>
				</select><br/>';
	
		if ($_GET['type'] == "prof") 
			echo 'Admin : ';
		else
			echo 'Choisi dans un binôme : ';
	
	echo '<input type="checkbox" name="gen"'; 
	if($user['droit'] == 1 || $user['boolbin'] == 1) echo 'CHECKED'; 
	echo '/><br/>
	<input type="hidden" name="type" value="';
	if (isset($_GET['type'])) echo $_GET['type']; else echo $_POST['type'];
	echo '"/>
	<input type="hidden" name="mode" value="';
	if (isset($_GET['mode'])) echo $_GET['mode']; else echo $_POST['mode'];
	echo '"/>
	<input type="hidden" name="loginold" value="';
	if (isset($_GET['log'])) echo $_GET['log']; else echo $_POST['loginold'];
	echo '"/>
	<input type="submit" value="';
	if (isset($_GET['mode']))
		echo $_GET['mode'];
	else
		echo $_POST['mode'];
	echo '"/>';
	echo " <input type='button' value='Retour' name='bnom' onClick='javascript:history.back();'>
	</form>";

	
}
else
{
echo 'Vous n\'avez pas accès à cette page	
<script type="text/javascript">redirection("login");</script>';
}

?>

        