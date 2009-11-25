<?php
$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit() == 1)
{	
	echo '<h1>Enregistrer les dates</h1>';
	
	$mois = array("janvier","f�vrier","mars","avril","mai","juin","juillet","ao�t","septembre","octobre","novembre","d�cembre");
	$infos =array("Constitution des bin�mes","Proposition des projets par les enseignants","D�but r�union de coordination des projets","Diffusion des sujets propos�s","Choix <b>ordonn�e</b> des sujets par les �tudiants (<b>5 choix</b>)","Publication de l'attribution des sujets","Remise du rapport pr�liminaire (au tuteur)","Remise du rapport (au secr�tariat)","D�but soutenances de projets","Fin soutenances de projets");
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
			</select>&nbsp � &nbsp;
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
echo 'Vous n\'avez pas acc�s � cette page	
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