<?php

$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit(1)) // Page r�serv�e a l'administrateur
{		
	//suppression d'un tuple
	if (isset($_GET['id']) && $_GET['action'] == "supprimer")
	{
		$objet->supprimer_binome($_GET['id']);	
		echo '<p class="granted">Tuple supprim�</p>';
	}
	
	echo '<h1> Les bin�mes</h1>';
	
	
	echo '<table>
	<th class="border_cellule">Num�ro</th>
	<th class="border_cellule">Nom 1</th>
	<th class="border_cellule">Nom 2</th>
	<th class="border_cellule">Niveau</th>
	<th class="border_cellule">Valide</th>
	<th class="border_cellule" colspan="2">Action</th>';
	
	$ret = mysql_query("SELECT * FROM binome");	// on r�cupere tous les binomes, qu'ils soient valid�s ou non
	while ($binome = mysql_fetch_array($ret)) // pour chaque binome r�cup�r�
	{
		echo '<tr>
		<td class="border_cellule">' . $binome['num'] . '</td>
		<td class="border_cellule">' . $binome['nom1'] . '</td>
		<td class="border_cellule">' . $binome['nom2'] . '</td>
		<td class="border_cellule">' . $binome['niveau'] . '</td>
		<td class="border_cellule">' . $binome['valide'] . '</td>
		<td class="border_cellule"><a href="index.php?page=modifier_binome&id=' . $binome['num'] . '"><img src="../images/b_edit.png" alt="Modifier" title="Modifier" /></a></td>
		<td class="border_cellule"><a href="javascript:confirmation(\'gestion_binome\',\'id\',\''. $binome['num'] . '\',\'action\',\'supprimer\',3);"><img src="../images/b_drop.png" alt="Supprimer" title="Supprimer" /></a></td>
		</tr>';
	}
	echo '</table>';
}
else
{
echo 'Vous n\'avez pas acc�s � cette page	
<script type="text/javascript">redirection("login");</script>';
}
?>

