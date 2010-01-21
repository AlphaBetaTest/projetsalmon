<?php

$objet = unserialize($_SESSION['objet']);
if ($_SESSION['objet'] != "" && $objet->type() == "prof") // Page réservé aux professeurs
{
	if(isset($_GET['action']) && isset($_GET['sujet'])) { // Si l'utilisateur a voulu supprimer le sujet
		$objet->supprimer_sujet($_GET['sujet']);	
	}
	
	echo '<h1>Liste de mes sujets</h1>';
	
	echo '<p>Vous pouvez selectionner le projet a supprimer. Une description du sujet est visible au survol du titre. Si vous souhaitez éditer un sujet, vous devez d\'abord le supprimer, puis le réenregistrer.</p>';
	
	$sujets = $objet->recup_sujets(); // on récupere la liste des sujets qu'a proposé l'utilisateur

	if(!empty($sujets)) {
		echo '<table>';
		echo '<th>Titre du sujet</th>
		<th>Niveau</th>
		<th>Action</th>';
		
		foreach($sujets as $value) { // on affiche tous les sujets
			echo '<tr>';
			
			if(empty($value['description'])) $description = "Pas de description"; else $description = $value['description'];
			
			echo '<td class="border_cellule"><a href="#" class="survol">'.$value['titre'].'<span>'.$description.'</span></a></td>
				<td class="border_cellule">'.$value['niveau'].' : '.$value['groupe'].'</td>
				<td class="border_cellule"><a href="?page=editer_sujet&action=1&sujet='.$value['id_proj'].'"><img src="images/b_drop.png" alt="supprimer" title="Supprimer le sujet" /></a></td>
				</tr>';
		}
		echo '</table>';
	}
	else {
		echo '<p class="warning">Vous n\'avez pas proposé de sujet.</p>';	
	}
?>

<?php
}
else
{
echo 'Vous devez etre connecté en tant qu\'enseignant. Vous allez &ecirc;tre redirig&eacute;...
<script type="text/javascript">redirection("login");</script>';
}
?>