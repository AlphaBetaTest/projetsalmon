<div id="menu">
<!-- Debut du menu -->
<ul>
	<li class="normal">
		<a href="#">ACTUALITES</a>
	</li>
	<li class="normal deroulant" onmouseover="show(this);" onmouseout="hide(this);">
		<a href="#">Informations par ann&eacute;e</a>
		<ul>
			<li class="normal">
				<a href="#">1&egrave;re ann&eacute;e</a>
			</li>
			<li class="normal">
				<a href="#">2&egrave;me ann&eacute;e</a>
			</li>
			<li class="normal">
				<a href="#">Ann&eacute;e sp&eacute;ciale</a>
			</li>
			<li class="normal">
				<a href="#">Licence</a>
			</li>
		</ul>
	</li>
	<li class="normal deroulant" onmouseover="show(this);" onmouseout="hide(this);">
		<a href="#">Informations g&eacute;n&eacute;rales</a>
		<ul>
			<li class="normal">
				<a href="#">Dates &agrave; retenir</a>
			</li>
			<li class="normal">
				<a href="#">Annuaire et r&egrave;glement</a>
			</li>
			<li class="normal">
				<a href="#">Liens Internes</a>
			</li>
		</ul>
	</li>
	<li class="normal">
		<a href="#">Informations techniques</a>
	</li>
	<li class="normal deroulant" onmouseover="show(this);" onmouseout="hide(this);">
		<a href="#">Emplois et stages</a>
		<ul>
			<li class="normal">
				<a href="#">Stages</a>
			</li>
			<li class="normal">
				<a href="#">Emplois</a>
			</li>
		</ul>
	</li>
	<li class="normal">
		<a href="#">Espace Etudiants</a>
	</li>
	<?php 
		
	
	echo '<li class="normal deroulant" onmouseover="show(this);" onmouseout="hide(this);">
		<a href="index.php">Gestion des projets</a>
		<ul>
		<!-- Pour tout le monde -->			
			<li class="normal deroulant" onmouseover="show(this);" onmouseout="hide(this);"><a href="?page=liste_projets">Liste des sujets
			<ul>
				<li class="normal"><a href="?page=liste_projets&niveau=A2">Ann&eacute;e 2</a></li>
				<li class="normal"><a href="?page=liste_projets&niveau=LP">Licence professionnelle</a></li>
				<li class="normal"><a href="?page=liste_projets&niveau=AS">Ann&eacute; sp&eacute;ciale</a></li>
			</ul></li>
			
			<li class="normal deroulant" onmouseover="show(this);" onmouseout="hide(this);"><a href="?page=liste_projet_affecte">Liste des affectations</a>
			<ul>
				<li class="normal"><a href="?page=liste_projet_affecte&niveau=A2">Ann&eacute;e 2</a></li>
				<li class="normal"><a href="?page=liste_projet_affecte&niveau=LP">Licence professionnelle</a></li>
				<li class="normal"><a href="?page=liste_projet_affecte&niveau=AS">Ann&eacute;e sp&eacute;ciale</a></li>
			
			</ul></li>
			<li class="normal deroulant" onmouseover="show(this);" onmouseout="hide(this);"><a href="?page=affiche_date">Planning</a>
			<ul>
				<li class="normal"><a href="?page=affiche_date&niveau=A2">Ann&eacute;e 2</a></li>
				<li class="normal"><a href="?page=affiche_date&niveau=LP">Licence professionnelle</a></li>
				<li class="normal"><a href="?page=affiche_date&niveau=AS">Ann&eacute;e sp&eacute;ciale</a></li>			
			</ul></li>
		<li class="normal"><a href="?page=affiche_soutenance">Planning soutenances</a>';			
			
		
	if (!empty($_SESSION['objet']))
	{
		echo '<li class="normal"><a href="?page=login&action=modif">Modifier son mot de passe</a></li>';
		
		$objet = unserialize($_SESSION['objet']);				
		if ($objet->type() == "eleves")
		{
			echo '<!-- Pour les étudiants -->
				<li class="normal"><a href="?page=choisir_binome">Choisir son bin&ocirc;me</a></li>
				<li class="normal"><a href="?page=formulation_voeux">Formuler ses voeux</a></li>';			
		}
		else if ($objet->type() == "prof")
		{
			echo '<!-- Pour les enseignants -->
			<li class="normal"><a href="?page=enregistrer_projet">Enregistrer un sujet</a></li>
			<li class="normal"><a href="?page=ajouter_indisponibilite">Ajouter ses indisponibilites</a></li>';			
			
		
			echo '</ul></li>';
			
			if ($objet->get_droit() == 1)
			{
				echo '<li class="normal deroulant" onmouseover="show(this);" onmouseout="hide(this);">
					<a href="index.php">Admin Gestion des projets</a>
				<ul>
					<li class="normal"><a href="admin/index.php?page=creer_fichier_voeux">Cr&eacute;er le fichier de voeux</a></li>
					<li class="normal"><a href="admin/index.php?page=recuperer_affectation">R&eacute;cup&eacute;rer les affectations</a></li>
					<li class="normal"><a href="admin/index.php?page=compte_projet_enseignant">Compteur projet/soutenance</a></li>
					<li class="normal"><a href="admin/index.php?page=gestion_utilisateur">Gestion des utilisateurs</a></li>
					<li class="normal"><a href="admin/index.php?page=gestion_binome">Gestion des binomes</a></li>
					<li class="normal"><a href="admin/index.php?page=gestion_soutenance">Gestion des soutenances</a></li>
					<li class="normal"><a href="admin/index.php?page=enregistrer_date">Enregistrer planning date</a></li>
					
			</ul></li>';
			}			
		}
	}
		
		
	
	?>
		



</div>
<!-- Fin du menu -->
			
