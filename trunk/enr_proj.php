<?php

$objet = unserialize($_SESSION['objet']);
if ($_SESSION['objet'] != "" && $objet->type() == "prof")
{	
	echo '<h1>Proposition de projet</h1>';	

	if (isset($_POST['description']) && isset($_POST['titre']) && isset($_POST['niveau']) && !empty($_POST['titre']))
	{
		if ($_POST['qualif1']) $qualif .= " analyse & conception,";
		if ($_POST['qualif2']) $qualif .= " développement & programmation,";
		if ($_POST['qualif3']) $qualif .= " travail original,";
		if ($_POST['qualif4']) $qualif .= " continuation ou maintenance,";	   
		
		$niveau = $_POST['niveau'];
		
		$groupe = "";
		if($_POST['DAE'] == "on") $groupe.="DAE;";
		if($_POST['ACPI'] == "on") $groupe.="ACPI;";
		if($_POST['PGI'] == "on") $groupe.="PGI;";
		
		$objet->enregistrer_projet($_POST['nomtuteur2'],$_POST['prenomtuteur2'], $_POST['titre'], $_POST['wish'], $_POST['possible'], $qualif, $_POST['rem'], $_POST['description'], $_POST['domaine'], $_POST['matos'], $niveau, $groupe); // s'occuper de niveau quand on aura adapté pour LP et AS.
	}
	else {
		echo '<p style="font-weight:bold;color:#FF0000;">Veuillez remplir correctement tous les champs !</p>';	
	}
	
	$nomcomplet = $objet->name();
	$nom = substr($nomcomplet,0,strpos($nomcomplet,' '));
	$prenom = substr($nomcomplet,strpos($nomcomplet,' ')+1);	
	

	echo '<p><b>Niveau (obligatoire) : </b>	
			<form action="?page=enregistrer_projet" method="post" name="formulaire">';
			
	$niv = array('A2','AS', 'LP');
		
	for ($i = 0 ; $i <= 2 ; $i++)
	{
		echo '<br /><input type="radio" name="niveau" value="' . $niv[$i] . '" /> '.$niv[$i]; 
	}
	
	echo '&nbsp;(PGI : <input type="checkbox" name="PGI" /> / 
	DAE<input type="checkbox" name="DAE" /> / 
	ACPI<input type="checkbox" name="ACPI" />)';
		
	if ($_POST['niveau'] == "LP")
	{	
		$r = mysql_query("SELECT DISTINCT(groupe) FROM eleves WHERE niveau='LP'");
		while ($groupe = mysql_fetch_array($r))
			echo ' &nbsp;  &nbsp; <input type="radio" name="promo" value="' . $groupe['groupe'] . '"/> ' . $groupe['groupe'];			
	}
?>
		
		<p><b>Tuteur(s) : </b><br/>
		Nom <input type="text" size="20" name="nomtuteur1" value="<?php echo $nom; ?>" disabled="true"/> Prénom  <input type="text" size="20" name="prenomtuteur1" value="<?php echo $prenom; ?>" disabled="true"/> 
		<br/>
		Nom <input type="text" size="20" name="nomtuteur2" value="" /> Prénom  <input type="text" size="20" name="prenomtuteur2" value="" /><em> &nbsp;(Laisser vide cette ligne s'il n'y a qu'un seul tuteur)</em>
		<br/><br/>
		<b>Titre (obligatoire) : </b><br/>
		<input type="text" size="100" name="titre" value="" /><br/><br/>
		<b>Nombre de binôme souhaités : <input type="text" size="1" name="wish" value="" maxlength="1" /> &nbsp; Nombre de binôme possibles : <input type="text" size="1" maxlength="1" name="possible" /></b><br/><br/>
		<b>Description : </b><br/>
		<textarea name="description" cols="100" rows="16"></textarea>
		<br/><br/>
		<b>Qualification : </b>
		</p>	
		<table class="addproj">
		<tr>
		<td class="addproj">analyse & conception <input type="checkbox" name="qualif1" /></td>
		<td class="addproj">développement & programmation <input type="checkbox" name="qualif2" /></td>
		</tr>
		<td class="addproj">travail original <input type="checkbox" name="qualif3" /> </td>
		<td class="addproj">continuation ou maintenance <input type="checkbox" name="qualif4" /></td>
		</tr>
		</table>	
		<br/>
		<p>
		<b>Domaines d'application : </b></br>
		<textarea name="domaine" cols="100" rows="4"></textarea><br/><br/>
		<b>Matériels & logiciels utilisés : </b><br/>
		<textarea name="matos" cols="100" rows="2"></textarea><br/><br/>
		<b>Remarques : </b><br/>
		<textarea name="rem" cols="100" rows="7"></textarea>
		<br/><br/>
		<input class="center" type="submit" value="Envoyer" />
		</p>
		
		</form>
<?php	
}
else
{
echo 'Vous devez etre connecté en tant qu\'enseignant. Vous allez &ecirc;tre redirig&eacute;...
<script type="text/javascript">redirection("login");</script>';
}
?>


	
