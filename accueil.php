<p>Bienvenue sur le module de gestion des projets du département informatique de Montpellier.
	<p />Désormais plus besoin d'une montagne de papier pour choisir son binôme, ses voeux ...
</p>

<?php

if (isset($_SESSION['objet']))	 
{
	$objet = unserialize($_SESSION['objet']);
	$r = mysql_query("SELECT nom,prenom FROM " . $objet->type() . " WHERE login='" . $objet->info_login() . "'");
	$n = mysql_fetch_assoc($r);
	echo '<div style="border:2px #000 solid;text-align:center;padding:5px;width:300px;margin-left:auto;margin-right:auto;">
			<p>Bonjour <b>'. ucfirst(strtolower($n['prenom'])) . ' ' . ucfirst(strtolower($n['nom'])) . '</b>
			<br />Vous &ecirc;tes actuellement connect&eacute; 
			<p /><a href="?page=login&action=logout">Se déconnecter</a> - <a href="?page=login&action=modif">Modifier mot de passe</a>
			</p>
		</div>';
}
else
{
	echo '<p class="warning">Vous n\'etes pas identifié. Redirection dans quelques secondes.<p/>
			<script type="text/javascript">redirection("login");</script>'; 	  
}
?>