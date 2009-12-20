<?php

$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit(1))
{
?>
<h1> Ajout de la nouvelle promotion </h1>
<p>Veuillez envoyer le fichier resultat.csv cr�� a partir du fichier excel nomm� "promo.csv". <b>Pensez a s�lectionner correctement le niveau avant !</b>
<br />
<br /><u>Rappel des sp�cifications :</u><br />
- Chaque fichier xls doit contenir la liste des �leves d'un seul niveau (A2, AS, ...).<br />
- Dans la premiere colonne doivent figurer tous les noms de famille des �leves<br />
- Dans la seconde colonne doivent figurer tous les pr�noms des �leves<br />
- Dans la troisieme colonne doivent figurer les groupes des �leves (C1, C2, ...)<br />
- <b>Il ne doit y avoir aucune autre information dans ce fichier !</b><br />
- Une fois le fichier xls termin�, enregistrez le en fichier CSV nomm� promo.csv<br />
- <span style="color:#F00;font-weight:bold">S'il y a des �leves portant le meme nom de famille dans la promo, vous devrez editer le fichier resultat.csv que g�nerera l'ex�cutable "convertisseur.exe" : rajoutez la premiere lettre du pr�nom a l'identifiant (4� valeur dans chaque ligne)</span>
<br /><br />
Exemple de fichier xls :<br />
<img src="../images/exemple_xls.jpg" alt="Exemple de fichier xls" />
</p>
<form action="?page=ajout_multiple_utilisateur" method="post" enctype="multipart/form-data">

<p>Niveau de la promotion : 
<select name="niveau">
	<option value="A2">A2</option>
    <option value="AS">AS</option>
    <option value="LP_PGI">LP:PGI</option>
    <option value="LP_ACPI">LP:ACPI</option>
    <option value="LP_API">LP:API</option>
</select>
</p>

<p>Fichier CSV : <input type="file" name="fich"/><br/><br/>
 <input type="submit" value="Envoyer"/>			
</p>
</form>

<?php

	if (isset($_FILES['fich']))
	{	
		$objet->ajouter_multiutilisateur($_FILES['fich'], $_POST['niveau']);
	}	
	
}
else
{
echo 'Vous n\'avez pas acc&egrave;s &agrave; cette page, vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("login");</script>';
}
?>