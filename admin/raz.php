<?php
$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit(1))
{
	echo '<h1>Remettre � z�ro</h1>';
	
	
	if(isset($_POST['binomes'])) {
		$objet->RAZ($_POST['binomes'], $_POST['eleves'], $_POST['dates'], $_POST['indisponibilites'], $_POST['soutenance'], $_POST['projets'], $_POST['souhaits']);
	}
	
	echo '<p>Vous pouvez choisir de remettre � z�ro les diff�rentes tables du site.</p><p class="warning">Attention ! Une fois le formulaire valid�, il n\'y aura aucune r�cup�ration des donn�es possible !</p>';
	echo '<p>Vous souhaitez remettre � z�ro : </p>';
	
	echo '<form action="index.php?page=raz" method="post">';
	
	echo '<input type="checkbox" name="binomes" /> Binomes<br />';
	echo '<input type="checkbox" name="eleves" /> El�ves<br />';
	echo '<input type="checkbox" name="projets" /> Projets<br />';
	echo '<input type="checkbox" name="dates" /> Planning des dates<br />';
	echo '<input type="checkbox" name="indisponibilites" /> Indisponibilit�s des professeurs<br />';
	echo '<input type="checkbox" name="soutenance" /> Planning des soutenances<br />';
	echo '<input type="checkbox" name="souhaits" /> Souhaits �mis par les binomes<br /><br />';
	
	echo '<input type="submit" value="Envoyer" /></form>';
}
?>