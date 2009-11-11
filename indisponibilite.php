<?php


$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->type() == "prof")
{
	echo '<h1> Indiquer ses indisponibilités</h1><br/>';
	echo '- Pour sélectionner vos indisponibilités, il vous suffit de cliquer dans la/les case(s) désirée(s)<br/>
	- Pour en supprimer une, cliquez sur une case déjà sélectionnée ou pressez une touche.';
	echo '<p><form action="?page=ajouter_indisponibilite" method="post" name="formulaire">
		  <table>
		  <th>Horaire</th>
		  <th>Lundi</th>
		  <th>Mardi</th>
		  <th>Mercredi</th>
		  <th>Jeudi</th>
		  <th>Vendredi</th>';
	for ($i = 1; $i <= 11 ; $i++)
	{
		$h = $i + 7;
		echo '<tr>
		  <th>' . $h . 'h-' . ($h + 1) . 'h</th>
		  <td><input type="text" class="indisponibilite" size="10" maxlength="0" onkeyup=desactive(this) onclick=active(this) name="LU' . $i . '"/></td>
		  <td><input type="text" class="indisponibilite" size="10" maxlength="0" onkeyup=desactive(this) onclick=active(this) name="MA' . $i . '"/></td>
		  <td><input type="text" class="indisponibilite"  size="10" maxlength="0" onkeyup=desactive(this) onclick=active(this) name="ME' . $i . '"/></td>
		  <td><input type="text" class="indisponibilite"  size="10" maxlength="0" onkeyup=desactive(this) onclick=active(this) name="JE' . $i . '"/></td>
		  <td><input type="text" class="indisponibilite"  size="10" maxlength="0" onkeyup=desactive(this) onclick=active(this) name="VE' . $i . '"/></td>
		  </tr>';
	}	
	echo '<input type="hidden" value="1" name="exist"/>
	</table><br/>
	<input type="submit" value="Envoyer"/>
	</form>';
		  
}
else
{
	echo 'Vous n\'&ecirc;tes pas autorisé à accéder à cette page, vous allez &ecirc;tre redirig&eacute;...
<script type="text/javascript">redirection("login");</script>';

}

if (isset($_POST['exist']))
{
	include('cfg.php');	
	$objet->ajouter_indisponibilite();
}
?>

</body>
</html>
