<?php 

$objet = unserialize($_SESSION['objet']);
if ($_SESSION['objet'] != "" && $objet->get_droit(1))
{

	
	// pour la modif et les champs pré sélectionné :
	$rowmodif = mysql_query("SELECT * FROM soutenance WHERE id_bin ='" . $_GET['bin'] . "'");
	$rowmodif = mysql_fetch_assoc($rowmodif);		
	isset($_GET['bin']) ? $out = $_GET['bin'] : $out = $_POST['bin'];
	
	echo '<h1>Ajouter une soutenance</h1>';
	
	echo '<p>Vous pouvez sélectionner une heure pour ajouter une soutenance en cliquant sur une des cases du calendrier.<br /> Les informations complémentaires sur la soutenance vous seront demandées apres.</p>';
	
	echo '<p>
		  <table>
		  <th>Horaire</th>
		  <th>Lundi</th>
		  <th>Mardi</th>
		  <th>Mercredi</th>
		  <th>Jeudi</th>
		  <th>Vendredi</th>';
	
	for ($i = 1; $i <= 11 ; $i++)
	{
		$h = $i + 7;
		$profs ="";
		
		echo '<tr>';
		echo '<th>' . $h . 'h-' . ($h + 1) . 'h</th>';
		$tab = $objet->prof_disponibles_heure("lundi", $i);
		foreach($tab as $value) $profs.=$value.' / ';
		echo '<td><a href="" class="dispo"><input type="text" size="10" maxlength="0" /><span>Profs disponibles : <br /><br />'.$profs.'</span></a></td>';
		$profs ="";
		
		$tab = $objet->prof_disponibles_heure("mardi", $i);
		foreach($tab as $value) $profs.=$value.' / ';
		echo '<td><a href="" class="dispo"><input type="text" size="10" maxlength="0" /><span>Profs disponibles : <br /><br />'.$profs.'</span></a></td>';
		$profs ="";
		
		$tab = $objet->prof_disponibles_heure("mercredi", $i);
		foreach($tab as $value) $profs.=$value.' / ';
		echo '<td><a href="" class="dispo"><input type="text" size="10" maxlength="0" /><span>Profs disponibles : <br /><br />'.$profs.'</span></a></td>';
		$profs ="";
		
		$tab = $objet->prof_disponibles_heure("jeudi", $i);
		foreach($tab as $value) $profs.=$value.' / ';
		echo '<td><a href="" class="dispo"><input type="text" size="10" maxlength="0" /><span>Profs disponibles : <br /><br />'.$profs.'</span></a></td>';
		$profs ="";
		
		$tab = $objet->prof_disponibles_heure("vendredi", $i);
		foreach($tab as $value) $profs.=$value.' / ';
		echo '<td><a href="" class="dispo"><input type="text" size="10" maxlength="0" /><span>Profs disponibles : <br /><br />'.$profs.'</span></a></td>';
		$profs ="";
		echo ' </tr>';
	}	
	echo '<input type="hidden" value="1" name="exist"/>
	</table><br/>';
	
	/*
	<form name="form" method="post" action="?page=ajouter_soutenance">	
	<p>Num&eacute;ro du bin&ocirc;me : <input type="text" name="bin" size="4" value="' . $out . '" onchange="document.forms[\'form\'].submit();"/> </p>';
	
	if (isset($_POST['bin']))
	{
		//SELECT b.nom1,b.nom2,p.tuteur1,p.tuteur2 FROM binome b, projets p WHERE (b.num = p.id_proj) AND b.num='4'
		$binome = mysql_query("SELECT b.nom1,b.nom2,p.tuteur1,p.tuteur2 FROM binome b, projets p WHERE (b.num = p.id_proj) AND num='" . $_POST['bin'] . "'");
		$binome = mysql_fetch_assoc($binome);
		if ($binome['nom1'] != "")
			echo '<p class="center">Nom 1 : <b>' . $binome['nom1'] . '</b> - Nom 2 : <b>' . $binome['nom2'] . '</b><br/></p>
	     	<p class="center">Tuteur 1 : <b>' . $binome['tuteur1'] . '</b> -  Tuteur 2 : <b>' . $binome['tuteur2'] . '</b><br/></p>';
		else
			echo 'Bin&ocirc;me inexistant !';
	}		
		
		$d = mysql_query("SELECT deb_soutenance,fin_soutenance FROM date");
		$date = mysql_fetch_assoc($d);
		$jours = array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi');	
		setlocale(LC_TIME, "fr_FR", "fr_FR@euro", "fr", "FR", "fra_fra", "fra"); // permet d'avoir le mois en français à partir du timestamp
		$min_j = date("d",$date['deb_soutenance']);
		$max_j = date("d",$date['fin_soutenance']);
		$moissout = strftime("%B",$date['deb_soutenance']);
		$d = date("w",$date['deb_soutenance']); // jour semaine
		if ($min_j < 10)
			$min_j = substr($min_j,1,1);
		echo '<p><input type="radio" name="date" value="def" checked="checked" />Jour : <select name="jours">';		// est ce que les soutenances peuvent s'étaler sur 2 mois ?
		for ($i = $min_j ; $i <= $max_j ; $i++)
		{
			if ($d != 0 && $d != 6) // samedi et dimanche
				echo '<option value="' . $i . '">' . $jours[$d] . ' ' . $i . ' ' . $moissout . '</option>'; 
			$d++;
		}
		echo '</select>
			&nbsp;Heure : <select name="h">';
		for ($i = 8 ; $i <= 17 ; $i++)
		{	
		echo '<option value="' . $i . '">' . $i . 'h - ' . ($i+1) . 'h</option>';
		}
		echo '</select></p><p><input type="radio" '; 
		if ( $rowmodif['date'] < $date['deb_soutenance'] && $rowmodif['date'] > $date['fin_soutenance']) 
		{ 
			echo 'checked="checked"';
			$other = true;
		}
		echo ' name="date" value="other" /> Jours : <input type="text" size="2" maxlength="2" name="j"';
		if($other) echo 'value="' . date("d",$rowmodif['date']) . '"';
		echo '/> Mois : <input type="text" size="2" maxlength="2" name="m"';
		if ($other) echo 'value="' . date("m",$rowmodif['date']) . '"'; 
		echo '/> </p>';
		
		echo '<p>Salle : <input type="text" name="salle" size="3" maxlength="3" value="' . $rowmodif['salle'] . '"/></p>
		
		<p> Jury : <select name="jure">
							<option name=""> </option>';
		$p = mysql_query("SELECT login FROM prof");
		while ($prof = mysql_fetch_array($p))
		{
			echo '<option ';
			if ($rowmodif['tuteur_comp'] == $prof['login']) echo ' selected="selected"';
			echo ' name="' . $prof['login'] . '">' . $prof['login'] . '</option>';
		}
			
		echo '</select></p>
		
		<input type="submit" value="Envoyer" />
		</form>';
		*/
				
}
else
	echo 'Vous n\'avez pas acc&egrave;s &agrave; cette page		
<script type="text/javascript">redirection("login");</script>';
		

if (!empty($_POST['salle']) && !empty($_POST['bin']))
{
	$objet->ajouter_soutenance();	
}	


?>