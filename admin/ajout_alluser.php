<?php

$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit() == 1)
{
?>
<h1> Ajout de la nouvelle promotion </h1>
<form action="?page=ajout_multiple_utilisateur" method="post" enctype="multipart/form-data">

<p> Veuillez envoyer le fichier csv cr�� � partir du fichier excel nomm� "listepromo.xls" <br/> <br/>
Fichier csv : <input type="file" name="fich"/><br/><br/>
 <input type="submit" value="Envoyer"/>			
</p>
</form>

<?php

	if (isset($_FILES['fich']))
	{	
		$objet->ajouter_multiutilisateur($_FILES['fich']);
	}	
	
}
else
{
echo 'Vous n\'avez pas acc&egrave;s &agrave; cette page, vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("login");</script>';
}
?>