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
		for ($row = 1 ; $row <= 11 ; $row++)
		{
			$h = $row + 7;
			echo '<tr>
				<th>' . $h . 'h-' . ($h + 1) . 'h</th>
			 <td><input type="text" size="10" disabled="true" maxlength="0" style="background-color:';
			 if (ereg((";" . $row . ";"),$dispo['lundi'])) echo 'red'; else echo 'white';
			echo '"/></td>
			<td><input type="text" size="10" disabled="true"  maxlength="0" style="background-color:';
			 if (ereg((";" . $row . ";"),$dispo['mardi'])) echo 'red'; else echo 'white';
			echo '"/></td>
			<td><input type="text" size="10" disabled="true" maxlength="0" style="background-color:';
			 if (ereg((";" . $row . ";"),$dispo['mercredi'])) echo 'red'; else echo 'white';
			echo '"/></td>
			<td><input type="text" size="10" disabled="true" maxlength="0" style="background-color:';
			 if (ereg((";" . $row . ";"),$dispo['jeudi'])) echo 'red'; else echo 'white';
			echo '"/></td>
			<td><input type="text" size="10" disabled="true" maxlength="0" style="background-color:';
			 if (ereg((";" . $row . ";"),$dispo['vendredi'])) echo 'red'; else echo 'white';
			echo '"/></td>
			</tr>';
		}
		echo '</table>';		
	}
	else
		echo 'Donnéee manquante';
	
	echo "<br/><input type='button' value='Retour' name='bnom' onClick='javascript:history.back();'>";
}
else
{
echo 'Vous n\'avez pas acc&egrave;s &agrave; cette page, vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("login");</script>';

}

?>
