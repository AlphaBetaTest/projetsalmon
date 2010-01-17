<?php
$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit(1))
{
	echo '<h1>Remettre à zéro</h1>';
	
	
	if(isset($_POST['binomes'])) {
		$objet->RAZ($_POST['binomes'], $_POST['eleves'], $_POST['dates'], $_POST['indisponibilites'], $_POST['soutenance'], $_POST['projets'], $_POST['souhaits']);
	}
	
	echo '<p>Vous pouvez choisir de remettre à zéro les différentes tables du site.</p><p class="warning">Attention ! Une fois le formulaire validé, il n\'y aura aucune récupération des données possible !</p>';
	echo '<p>Vous souhaitez remettre à zéro : </p>';
	
	echo '<form action="index.php?page=raz" method="post">';
	
	echo '<input type="checkbox" name="binomes" /> Binomes<br />';
	echo '<input type="checkbox" name="eleves" /> Elèves<br />';
	echo '<input type="checkbox" name="projets" /> Projets<br />';
	echo '<input type="checkbox" name="dates" /> Planning des dates<br />';
	echo '<input type="checkbox" name="indisponibilites" /> Indisponibilités des professeurs<br />';
	echo '<input type="checkbox" name="soutenance" /> Planning des soutenances<br />';
	echo '<input type="checkbox" name="souhaits" /> Souhaits émis par les binomes<br /><br />';
	
	echo '<input type="submit" value="Envoyer" /></form>';
}
?>