<?php
$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit() == 1)
{
	
	if (isset($_GET))
	{
		$dispo = mysql_query("SELECT * FROM indisponibilite WHERE login='" . $_GET['log'] . "'");
		$dispo = mysql_fetch_assoc($dispo);
		echo '<table>
			<th>Horaire</th>
			<th>Lundi</th>
			<th>Mardi</th>
			<th>Mercredi</th>
			<th>Jeudi</th>
			<th>Vendredi</th>
			';
		
		$indispos = $objet->recup_indisponibilites(); // on r�cupere les indisponibilit�s de l'utilisateur si celui ci les a d�ja rentr�
	
		$heures_memorisee_lundi = explode(";", $indispos['lundi']);
		$heures_memorisee_mardi = explode(";", $indispos['mardi']);
		$heures_memorisee_mercredi = explode(";", $indispos['mercredi']);
		$heures_memorisee_jeudi = explode(";", $indispos['jeudi']);
		$heures_memorisee_vendredi = explode(";", $indispos['vendredi']);
		
		for ($row = 1 ; $row <= 11 ; $row++)
		{
			$h = $row + 7;
			echo '<tr>
				<th>' . $h . 'h-' . ($h + 1) . 'h</th>
			 <td><input type="text" size="10" disabled="true" maxlength="0" style="background-color:';
			 if (in_array($row, $heures_memorisee_lundi)) echo 'red';
			echo '"/></td>
			<td><input type="text" size="10" disabled="true"  maxlength="0" style="background-color:';
			 if (in_array($row, $heures_memorisee_mardi)) echo 'red';
			echo '"/></td>
			<td><input type="text" size="10" disabled="true" maxlength="0" style="background-color:';
			 if (in_array($row, $heures_memorisee_mercredi)) echo 'red';
			echo '"/></td>
			<td><input type="text" size="10" disabled="true" maxlength="0" style="background-color:';
			 if (in_array($row, $heures_memorisee_jeudi)) echo 'red';
			echo '"/></td>
			<td><input type="text" size="10" disabled="true" maxlength="0" style="background-color:';
			 if (in_array($row, $heures_memorisee_vendredi)) echo 'red';
			echo '"/></td>
			</tr>';
		}
		echo '</table>';		
	}
	else
		echo 'Donn�ee manquante';
	
	echo "<br/><input type='button' value='Retour' name='bnom' onClick='javascript:history.back();'>";
}
else
{
echo 'Vous n\'avez pas acc&egrave;s &agrave; cette page, vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("login");</script>';

}

?>
