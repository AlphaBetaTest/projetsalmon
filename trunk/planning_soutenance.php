<?php

	echo '<h1> Planning des soutenances</h1><br/>';
	$retour = mysql_query("
	SELECT s.salle,s.date,s.tuteur_comp,b.niveau,b.nom1,b.nom2,p.tuteur1,p.tuteur2 
	FROM soutenance s, binome b, projets p 
	WHERE (s.id_bin = b.num) AND (b.id_proj = p.id_proj)
	ORDER BY date ASC");
	
	echo '<table>
			<th class="border_cellule">Bin&ocirc;me</th>
			<th class="border_cellule">Salle</th>
			<th class="border_cellule">Tuteurs</th>
			<th class="border_cellule">Date</th>
			<th class="border_cellule">Niveau</th>';
	
	while($donnees = mysql_fetch_array($retour)) {
		$date = date('d/m/Y \a H\h', $donnees['date']);
		
		echo '<tr>
				<td class="border_cellule">'.ucfirst($donnees['nom1']).' - '.ucfirst($donnees['nom2']).'</td>
				<td class="border_cellule">'.$donnees['salle'].'</td>
				<td class="border_cellule"><b>'.ucfirst($donnees['tuteur1']).'</b> - '.ucfirst($donnees['tuteur2']).' - '.ucfirst($donnees['tuteur_comp']).'</td>
				<td class="border_cellule">'.$date.'</td>
				<td class="border_cellule">'.$donnees['niveau'].'</td>
			</tr>';
		
	}
	echo '</table>';
	
?>
