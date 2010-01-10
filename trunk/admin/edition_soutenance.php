<?php

$objet = unserialize($_SESSION['objet']);
if ($_SESSION['objet'] != "" && $objet->get_droit(1))
{
	
	$ret = mysql_query('SELECT * FROM soutenance WHERE id_bin = "'.$_GET['bin'].'"');
	if(mysql_num_rows($ret) > 0) {
		$modif = true;
		$d = mysql_fetch_array($ret);
	}
	else
		$modif = false;
	
	if(isset($_POST['binome'])) {
		$objet->ajouter_soutenance($_POST['binome'], $_GET['niveau'], $_GET['jour'], $_GET['heure'], $_POST['salle'], $_POST['jury'], $modif);	
	}
	
	$d = mysql_query("SELECT deb_soutenance,fin_soutenance,niveau FROM date WHERE niveau = '".$_GET['niveau']."'");
	$date = mysql_fetch_assoc($d);
	
	echo '<p><b>Semaine du '.date('d/m/Y', $date['deb_soutenance']).' au '.date('d/m/Y', $date['fin_soutenance']).'</b><br />';	
	echo '<b>Jour</b> : '.$_GET['jour'].' de '.($_GET['heure']+7).'h a '.($_GET['heure']+8).'h<br />';	
	echo '<b>Niveau :</b> '.$date['niveau'].'</p>';	
	echo '<p>Pour ajouter une soutenance a cette date, veuillez renseigner les champs suivants :</p>';

	echo '<form name="form" method="post" action="?page=edition_soutenance&heure='.$_GET['heure'].'&jour='.$_GET['jour'].'&niveau='.$_GET['niveau'].'">';
	
	echo 'Binome : <select name="binome">';
	
	$ret = mysql_query('SELECT * FROM binome WHERE niveau = "'.$_GET['niveau'].'"');
	while($donnees = mysql_fetch_array($ret)) {
		echo '<option value="'.$donnees['num'].'">'.$donnees['num'].' : '.$donnees['nom1'].' - '.$donnees['nom2'].'</option>';
	}
	
	echo '</select>';
	
	echo '<p>Salle : <input type="text" name="salle" size="3" maxlength="5" /></p>';
	
	echo '<p style="float:left;">Jury : <select name="jury">';
	$p = mysql_query("SELECT login FROM prof");
	while ($prof = mysql_fetch_array($p))
	{
		echo '<option ';
		if ($rowmodif['tuteur_comp'] == $prof['login']) echo ' selected="selected"';
		echo ' name="' . $prof['login'] . '">' . $prof['login'] . '</option>';
	}
		
	echo '</select></p>';
	
	$tab = $objet->prof_disponibles_heure($_GET['jour'], $_GET['heure']);
	
	echo '<span class="dispo"><b>Professeurs disponibles a cette heure :</b><br /><br />';
	
	foreach($tab as $value) echo $value.' / ';
	
	echo '</span><div style="clear:both"></div>';
	
	echo '<input type="submit" value="Envoyer" />
	</form>';
}
?>