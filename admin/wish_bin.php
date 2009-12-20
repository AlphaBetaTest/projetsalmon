<?php
$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit(1))
{
	if (isset($_GET['niveau']))
	   $objet->creer_fichier_souhaits($_GET['niveau']);
	else
		echo '<a href="?page=creer_fichier_voeux&niveau=A2">Ann&eacute;e 2</a><br/>
		<a href="?page=creer_fichier_voeux&niveau=LP">Licence professionnelle</a><br/>
	<a href="?page=creer_fichier_voeux&niveau=AS">Ann&eacute;e sp&eacute;ciale</a>';
}
else
echo 'Vous n\'avez pas acc&egrave;s &agrave; cette page, vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("login");</script>';

?>
