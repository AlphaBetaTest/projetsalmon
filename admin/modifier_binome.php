<?php

$objet = unserialize($_SESSION['objet']);
if ($_SESSION['objet'] != "" && $objet->get_droit() == 1)
{
	
	$binome = mysql_query("SELECT * FROM binome WHERE num='" . $_GET['id'] . "'");
	$binome = mysql_fetch_assoc($binome);
	
	$groupe = mysql_query("SELECT groupe FROM eleves WHERE login='" . $binome['nom1'] . "'");
	$groupe = mysql_fetch_assoc($groupe);
	$groupebin = $groupe['groupe'];
	
	$groupes = mysql_query("SELECT distinct(groupe) FROM eleves ORDER BY groupe ASC");	
	echo '<form name="form_g" method="post" action="?page=modifier_binome&id="' . $_GET['id'] . '">
	Groupe du binôme : <select name="groupe" Onchange="document.forms[\'form_g\'].submit()";>';
	while ($groupe = mysql_fetch_array($groupes))
	{
		echo '<option'; if($groupebin == $groupe['groupe']) {echo ' selected="SELECTED"';}  echo '>' . $groupe['groupe'] . '</option>';
			
	}
	echo '</select></form><br/>' . $_POST['groupe'];
	
	if (isset($_POST['groupe'])) {$groupebin = $_POST['groupe'];}
	$eleves = mysql_query("SELECT login FROM eleves WHERE groupe='" . $groupebin . "'");
	$eleves2 = $eleves;
	echo '<form action="?page=binomes" method="post" name="formulaire">
	Nom 1 : <select name="nom1">';
	while ($eleve = mysql_fetch_array($eleves))
	{
		echo '<option'; if($binome['nom1'] == $eleve['login']) {echo ' selected="SELECTED"';} echo '>' . $eleve['login'] . '</option>';		
	}
	echo '</select>
	Nom 2 : <select name="nom2">';
	mysql_data_seek($eleves,0); // Remet au début du talbeau de la requête
	while ($eleve = mysql_fetch_array($eleves))
	{ 
		echo '<option'; if($binome['nom2'] == $eleve['login']) {echo ' selected="SELECTED"';} echo '>' . $eleve['login'] . '</option>';		
	}
	
	echo '</select><br/><br/>
	<input type="hidden" value="' . $_GET['id'] . '" />	
	<input type="submit" value="Modifier" name="modif"/>
	</form>';
}
else
	echo 'Vous n\'&ecirc;tes pas autorisé à accéder à cette page, vous allez &ecirc;tre redirig&eacute;...
<script type="text/javascript">redirection("login");</script>';
?>