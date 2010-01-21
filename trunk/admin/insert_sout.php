<?php 

$objet = unserialize($_SESSION['objet']);
if ($_SESSION['objet'] != "" && $objet->get_droit(1)) // Page réservée a l'administrateur
{
	
	// pour la modif et les champs pré sélectionnés :
	$rowmodif = mysql_query("SELECT * FROM soutenance WHERE id_bin ='" . $_GET['bin'] . "'");
	$rowmodif = mysql_fetch_assoc($rowmodif);		
	isset($_GET['bin']) ? $out = $_GET['bin'] : $out = $_POST['bin'];
	
	echo '<h1>Ajouter une soutenance</h1>';
	
	echo '<p>Vous pouvez sélectionner une heure pour ajouter une soutenance en cliquant sur une des cases du calendrier.<br /> Les informations complémentaires sur la soutenance vous seront demandées apres.</p>
	<p class="warning">Attention ! Si vous souhaitez ajouter une soutenance pour les éleves parant a l\'étranger, utilisez le deuxieme planning en dessous !</p>';
	
	echo '<p><b>Niveau :</b> '.$_GET['niveau'].'</p>';
	
	$ret = mysql_query('SELECT * FROM date WHERE niveau = "'.$_GET['niveau'].'"'); // on récupere les dates de soutenance du niveau selectionné
	$d = mysql_fetch_array($ret);
	
	echo '<p><b>Semaine du '.date('d/m/Y', $d['deb_soutenance']).' au '.date('d/m/Y', $d['fin_soutenance']).'</b></p>';
	
	echo '<p>
		  <table>
		  <th>Horaire</th>
		  <th>Lundi</th>
		  <th>Mardi</th>
		  <th>Mercredi</th>
		  <th>Jeudi</th>
		  <th>Vendredi</th>';
	
	for ($i = 1; $i <= 11 ; $i++) // pour chaque tranche horaire on affiche une case et un survol contenant la liste des professeurs disponibles
	{
		$h = $i + 7;
		$profs ="";
		
		echo '<tr>';
		echo '<th>' . $h . 'h-' . ($h + 1) . 'h</th>';
		$tab = $objet->prof_disponibles_heure("lundi", $i); // on récupere la liste des profs dispo a ce jour et cette heure
		foreach($tab as $value) $profs.=$value.' / ';
		echo '<td><a href="?page=edition_soutenance&jour=lundi&heure='.$i.'&niveau='.$_GET['niveau'].'" class="dispo"><input type="text" size="10" maxlength="0" /><span>Profs disponibles : <br /><br />'.$profs.'</span></a></td>';
		$profs ="";
		
		$tab = $objet->prof_disponibles_heure("mardi", $i);
		foreach($tab as $value) $profs.=$value.' / ';
		echo '<td><a href="?page=edition_soutenance&jour=mardi&heure='.$i.'&niveau='.$_GET['niveau'].'" class="dispo"><input type="text" size="10" maxlength="0" /><span>Profs disponibles : <br /><br />'.$profs.'</span></a></td>';
		$profs ="";
		
		$tab = $objet->prof_disponibles_heure("mercredi", $i);
		foreach($tab as $value) $profs.=$value.' / ';
		echo '<td><a href="?page=edition_soutenance&jour=mercredi&heure='.$i.'&niveau='.$_GET['niveau'].'" class="dispo"><input type="text" size="10" maxlength="0" /><span>Profs disponibles : <br /><br />'.$profs.'</span></a></td>';
		$profs ="";
		
		$tab = $objet->prof_disponibles_heure("jeudi", $i);
		foreach($tab as $value) $profs.=$value.' / ';
		echo '<td><a href="?page=edition_soutenance&jour=jeudi&heure='.$i.'&niveau='.$_GET['niveau'].'" class="dispo"><input type="text" size="10" maxlength="0" /><span>Profs disponibles : <br /><br />'.$profs.'</span></a></td>';
		$profs ="";
		
		$tab = $objet->prof_disponibles_heure("vendredi", $i);
		foreach($tab as $value) $profs.=$value.' / ';
		echo '<td><a href="?page=edition_soutenance&jour=vendredi&heure='.$i.'&niveau='.$_GET['niveau'].'" class="dispo"><input type="text" size="10" maxlength="0" /><span>Profs disponibles : <br /><br />'.$profs.'</span></a></td>';
		$profs ="";
		echo ' </tr>';
	}	
	echo '<input type="hidden" value="1" name="exist"/>
	</table><br/>';
	
	if($_GET['niveau'] == "A2") { // petite modification pour le niveau A2 : on ajoute un formulaire permettant d'ajouter une soutenance pour les éleves partant a l'étranger
		echo '<p>Soutenances pour les éleves partant a l\'étranger :</p>';	
		
		$r =  mysql_query('SELECT soutenance_etranger FROM date WHERE niveau = "A2"');
		$d = mysql_fetch_array($r);
			
		$jours = array("lundi", "mardi", "mercredi", "jeudi", "vendredi");
		$jour_soutenance = $jours[date("w", $d['soutenance_etranger'])-1];
		
		echo '<table>';
		echo '<th>Horaire</th>';
		echo '<th>'.ucfirst($jour_soutenance).'</th><tr />';
				
		for ($i = 1; $i <= 11 ; $i++) { // on affiche toutes les tranches horaires
			$h = $i + 7;
			echo '<th>' . $h . 'h-' . ($h + 1) . 'h</th>';
		 	$tab = $objet->prof_disponibles_heure($jour_soutenance, $i);
			foreach($tab as $value) $profs.=$value.' / ';
			echo '<td><a href="?page=edition_soutenance&jour='.date("d", $d['soutenance_etranger']).'&heure='.$i.'&niveau='.$_GET['niveau'].'" class="dispo"><input type="text" size="10" maxlength="0" /><span>Profs disponibles : <br /><br />'.$profs.'</span></a></td>';
			$profs = "";
			echo ' </tr>';
		}
		
		echo '</table>';
	}
				
}
else
	echo 'Vous n\'avez pas acc&egrave;s &agrave; cette page		
<script type="text/javascript">redirection("login");</script>';
		

if (!empty($_POST['salle']) && !empty($_POST['bin']))
{
	$objet->ajouter_soutenance();	
}	


?>