<?php

$objet = unserialize($_SESSION['objet']); 

if ($_SESSION['objet'] != "" && $objet->get_droit(1))
{
  
?>
<form action="?page=recuperer_affectation" method="post" enctype="multipart/form-data">

<p>Veuillez envoyer le fichier texte contenant les affectations <br/> <br/>
Fichier texte : <input type="file" name="fich"/><br/>
Niveau : 
<select name="niveau">
	<option>A2</option>
	<option>LP</option>
	<option>AS</option>
</select>
<br/>
<br/>
<input type="submit" value="Envoyer"/>			
</p>
</form>
<?php
	if (isset($_FILES['fich']))
	{	
		$objet->recuperer_affectation($_FILES['fich'],$_POST['niveau']);		
	}
}
?>

