<?php
$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit(1)) // Page réservée a l'administrateur
{

	if (isset($_GET['log']) && isset($_GET['type'])) // souhaite t-on supprimer un utilisateur ?
		$objet->supprimer_utilisateur($_GET['log'],$_GET['type']);		
	
	echo '<h1>Gestion des utilisateurs</h1>
	<form name="form" class="form_center" method="post" action="?page=gestion_utilisateur" >		
	Type : <select name="type" onchange="document.forms[\'form\'].submit();">
		<option value="prof">Enseignant</option>
		<option'; 
		if ($_GET['type'] || $_POST['type'] == "eleves") echo ' SELECTED';
		echo ' value="eleves">Etudiant</option>		
			</select><br/>
			</form><br/>
			<table>

			<th class="border_cellule">Nom</th>
			<th class="border_cellule">Prénom</th>
			<th class="border_cellule">Login</th>';
	if ($_POST['type'] == "eleves")
	{	
		echo '<th class="border_cellule">Groupe</th>
			  <th class="border_cellule">Niveau</th>
			  <th class="border_cellule">Choisi</th>';
	}
	else
	{
		echo '<th class="border_cellule">Admin</th>';
	}
	$type == "eleves" ? $nb = 2 : $nb = 3; // condition ternaire
	echo '<th class="border_cellule" colspan="' . $nb . '">Actions</th>';

	isset($_POST['type']) ? $type = $_POST['type'] : $type = "prof"; // condition ternaire
	if (isset($_GET['type']))
		$type = $_GET['type'];
	$ret = mysql_query("SELECT * FROM " . $type); // on récupere soit les éleves soit les professeurs
	while ($user = mysql_fetch_array($ret)) // pour chaque tuple : on affiche nom, prénom, login et actions
	{
		echo '<tr>
			<td class="border_cellule">' . $user['nom'] . '</td>
			<td class="border_cellule">' . $user['prenom'] . '</td>
			<td class="border_cellule">' . $user['login'] . '</td>
			<td class="border_cellule">'; 
		if ($type == "eleves")
		{
			echo $user['groupe'];
		}
		else
		{
			if($user['droit'] == 1)  echo 'Oui'; else echo 'Non';
		}		
		echo '</td>';
		
		if ($type == "eleves")
		{
			echo '<td class="border_cellule">' . $user['niveau'] . '</td>
			<td class="border_cellule">';
			if($user['boolbin'] == 1) echo 'Oui'; else echo 'Non';
			echo '</td>';
		}
		if ($type == "prof") echo '<td class="border_cellule"><a href="?page=indisponibilites&log=' . $user['login'] . '"><img src="../images/b_browse.png" alt="Afficher indisponibilités" title="Afficher indisponibilités" /></a>';
		echo '<td class="border_cellule"><a href="?page=ajouter_utilisateur&mode=Modifier&type=' . $type . '&log=' . $user['login'] . '"><img src="../images/b_edit.png" alt="Modifier" title="Modifier" /></a></td>
		<td class="border_cellule"><a href="javascript:confirmation(\'gestion_utilisateur\',\'log\',\''. $user['login'] . '\',\'type\',\'' . $type . '\',1);"><img src="../images/b_drop.png" alt="Supprimer" title="Supprimer" /></a></td>
		</tr>';
	}
	
	echo '<tr>	
	<td class="border_cellule" colspan="8">';
	if ($type == "eleves")
		echo '&nbsp; <a href="?page=ajouter_utilisateur&mode=Ajouter&type=' . $type . '">Ajout d\'un étudiant</a> &nbsp; // &nbsp; <a href="?page=ajout_multiple_utilisateur">Ajout d\'étudiants à partir d\'un fichier CSV</a> &nbsp; // &nbsp; <a href="javascript:confirmation(\'gestion_utilisateur\',\'log\',\'all\',\'type\',\'' . $type .'\',2);">Vider la table</a>';
	else
		echo '&nbsp; <a href="?page=ajouter_utilisateur&mode=Ajouter&type=' . $type . '">Ajout d\'un enseignant</a>';
	
	echo '</td></tr>
	</table>';

}
else
{
echo 'Vous n\'avez pas acc&egrave;s &agrave; cette page, vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("login");</script>';
}
?>
