<?php

	echo '<h1> Planning des soutenances</h1><br/>';
	$re = mysql_query("SELECT s.salle,s.date,s.tuteur_comp,b.nom1,b.nom2,p.tuteur1,p.tuteur2 FROM
	soutenance s, binome b, projets p 
	WHERE (s.id_bin = b.num) AND (b.id_proj = p.id_proj)
	ORDER BY date ASC");
	
	if(mysql_num_rows($re) > 0) {
	
		while($r = mysql_fetch_array($re))
		{
			$d = date("d",$r['date']);
			if ($jprec != $d)
			{
				$jprec = $d;
				echo '<p><table>';	
				$s = mysql_query("SELECT distinct(salle) FROM soutenance");
				$nbsalle = mysql_num_rows($s);
				$indice = 0;
				echo '<th class="border_cellule">' . date("d/m/Y",$r['date']) . 	'</th>';
				while ($salle = mysql_fetch_array($s))
				{
					echo '<th>Salle ' . $salle['salle'] . '</th>';
					$tablesalle[$indice] = $salle['salle'];
					$indice++;
				}
			}		  
				for ($i = 1; $i <= 11 ; $i++)
				{
					$h = $i + 7;
					echo '<tr>
					  <th class="border_cellule">' . $h . 'h-' . ($h + 1) . 'h</th>';
					for ($j = 0 ; $j < $nbsalle ; $j++)
					{
						echo '<td class="border_cellule">';		  				  
						if ($h == date("G",$r['date']) && $tablesalle[$j] == $r['salle'])
						{
							echo ucfirst($r['nom1']);
							if ($r['nom2'] != "")
								echo ' - ' . ucfirst($r['nom2']);						
							echo '<br/><b>' . ucfirst($r['tuteur1']);
							if ($r['tuteur2'] != "")
								echo ' - ' . ucfirst($r['tuteur2']);
							echo '</b>';
							if ($r['tuteur_comp'] != "")
								echo ' - ' . ucfirst($r['tuteur_comp']);
						}
							
					  echo '</td>';		  
					}
					echo '</tr>';
				}	
				if ($jprec == $d)
					echo '</table><br/></p>';
				
		}
	}
		else {
			echo '<p>Aucune soutenance n\'a été programmée.</p>';	
		}
?>
