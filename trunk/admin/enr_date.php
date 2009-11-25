<?php
$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit() == 1)
{	
	echo '<h1>Enregistrer les dates</h1>';
	
	$mois = array("janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre");
	$infos =array("Constitution des binômes","Proposition des projets par les enseignants","Début réunion de coordination des projets","Diffusion des sujets proposés","Choix <b>ordonnée</b> des sujets par les étudiants (<b>5 choix</b>)","Publication de l'attribution des sujets","Remise du rapport préliminaire (au tuteur)","Remise du rapport (au secrétariat)","Début soutenances de projets","Fin soutenances de projets");
	$annee = date("Y",time());
	
	echo '<table>	
	<form method="post" action="?page=enregistrer_date">
	<tr>
		<td>Niveau</td>
		<td><select name="niveau">
				<option>A2</option>
				<option>LP</option>
				<option>AS</option>
	        </select>
		</td>
	</tr>';
	
	for( $i = 0 ; $i <= 9 ; $i++)
	{	
		echo '
		<tr> 
			<td>' . $infos[$i] . '&nbsp;</td>
			<td> <input type="text" size="2" maxlength="2" name="j' . $i . '" />&nbsp; 
				<select name="m' . $i . '">';
			
			for ($j = 0 ; $j < 12 ; $j++)
			{
				echo '<option>' . ucfirst($mois[$j]) . '</option>';
			}
		
		echo '</select>&nbsp; 
			<select name="a' . $i . '">
				<option>' . $annee . '</option>
				<option>' . ($annee + 1) . '</option>
			</select>&nbsp à &nbsp;
				<input type="text" size="2" maxlength="2" name="h' . $i . '" />&nbsp; h&nbsp; 
				<input type="text" size="2" maxlength="2" name="mm' . $i . '" /> &nbsp; &nbsp; &nbsp;
			</td>		
		</tr>';
	}
	
	echo '<tr>
			<td>&nbsp;</td>
			<td>
				<input type="submit" value="Envoyer"/>
			</td>
			</form>
		</table>';
	
	
	
}
else
{
echo 'Vous n\'avez pas accès à cette page	
<script type="text/javascript">redirection("login");</script>';
}

if (isset($_POST))
{
	$verif = true;
	for($i = 0; $i<=9; $i++) {
		if(empty($_POST['j'.$i]))
			$verif = false;
	}
	
	if($verif)
		$objet->enregistrer_date();
}