<?php

$objet = unserialize($_SESSION['objet']);
if ($_SESSION['objet'] != "" && $objet->get_droit(1))
{
	
	//Modification d'un tuple
	if (isset($_POST['modif']) && $_POST['modif'] != "")
	{
		$objet->modifier_binome($_POST['nom1'], $_POST['nom2'], $_GET['id']);
		echo '<p class="granted">Bin�me modifi� !</p>';
	}
	
	$binome = mysql_query("SELECT * FROM binome WHERE num='" . $_GET['id'] . "'"); // on r�cupere le binome pass� en parametre dans l'url
	$binome = mysql_fetch_assoc($binome);
	
	$groupe = mysql_query("SELECT groupe FROM eleves WHERE login='" . $binome['nom1'] . "'"); // on r�cupere le groupe du binome
	$groupe = mysql_fetch_assoc($groupe);
	$groupebin = $groupe['groupe'];
	
	$groupes = mysql_query("SELECT distinct(groupe) FROM eleves ORDER BY groupe ASC");	// on r�cupere tous les groupes d'�leves
	echo '<form name="form_g" method="post" action="?page=modifier_binome&id=' . $_GET['id'] . '">
	Groupe du bin�me : <select name="groupe" Onchange="document.forms[\'form_g\'].submit()";>';
	
	while ($groupe = mysql_fetch_array($groupes)) // on affiche chaque groupe dans une liste d�roulante
	{
		echo '<option'; if($groupebin == $groupe['groupe']) {echo ' selected="SELECTED"';}  echo '>' . $groupe['groupe'] . '</option>';
	}
	
	echo '</select></form><br/>' . $_POST['groupe'];
	
	if (isset($_POST['groupe'])) {$groupebin = $_POST['groupe'];}
	
	$eleves = mysql_query("SELECT login FROM eleves WHERE groupe='" . $groupebin . "'"); // on r�cupere le login de l'�leve
	$eleves2 = $eleves;
	echo '<form action="?page=modifier_binome&id='.$_GET['id'].'" method="post" name="formulaire">
	Nom 1 : <select name="nom1">';
	while ($eleve = mysql_fetch_array($eleves)) // pour chaque �leve : onles affiche dans une liste d�roulante
	{
		echo '<option'; if($binome['nom1'] == $eleve['login']) {echo ' selected="SELECTED"';} echo '>' . $eleve['login'] . '</option>';		
	}
	echo '</select>
	Nom 2 : <select name="nom2">';
	mysql_data_seek($eleves,0); // Remet au d�but du tableau de la requ�te pour pouvoir reparcourir
	
	while ($eleve = mysql_fetch_array($eleves)) // pour chaque �leve : on les affiche dans une liste d�roulante
	{ 
		echo '<option'; if($binome['nom2'] == $eleve['login']) {echo ' selected="SELECTED"';} echo '>' . $eleve['login'] . '</option>';		
	}
	
	echo '</select><br/><br/>
	<input type="hidden" value="' . $_GET['id'] . '" name="id" />	
	<input type="submit" value="Modifier" name="modif"/>
	</form>';
}
else
	echo 'Vous n\'&ecirc;tes pas autoris� � acc�der � cette page, vous allez &ecirc;tre redirig&eacute;...
<script type="text/javascript">redirection("login");</script>';
?>