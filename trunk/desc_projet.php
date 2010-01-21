<?php
	echo '<h1>Description du projet</h1>';	
	echo '<p><b>Niveau : </b>	
	<form action="?page=enregistrer_projet" method="post" name="formulaire">';
	
	$retour = mysql_query('SELECT * FROM projets WHERE id_proj = "'.$_GET['id'].'"'); // on récupere le projet dont l'id est dans l'url
	$donnees = mysql_fetch_array($retour);
			
	$niv = array('A2','AS', 'LP');
			
	for ($i = 0 ; $i <= 2 ; $i++)
	{
		if($donnees['niveau'] == $niv[$i]) $select = 'checked="checked"'; else $select="";
		echo '<br /><input type="radio" disabled="disabled" name="niveau" value="' . $niv[$i] . '" '.$select.' /> '.$niv[$i]; 
	}
	
	if(!empty($donnees['groupe']))
		echo '&nbsp;('.$donnees['groupe'].')';
		
	$ret1 = mysql_query('SELECT * FROM prof WHERE login ="'.$donnees['tuteur1'].'"');
	$d1 = mysql_fetch_array($ret1);
	
	$ret2 = mysql_query('SELECT * FROM prof WHERE login ="'.$donnees['tuteur2'].'"');
	$d2 = mysql_fetch_array($ret2);

?>
    <p><b>Tuteur(s) : </b><br/>
    Nom <input type="text" size="20" name="nomtuteur1" value="<?php echo $d1['nom']; ?>" disabled="true"/> Prénom  <input type="text" size="20" name="prenomtuteur1" value="<?php echo $d1['prenom']; ?>" disabled="true"/> 
    <br/>
    Nom <input type="text" size="20" name="nomtuteur2" value="<?php echo $d2['nom']; ?>" disabled="true"/> Prénom  <input type="text" size="20" name="prenomtuteur2" value="<?php echo $d2['prenom']; ?>" disabled="true"/>
    <br/><br/>
    <b>Titre : </b><br/>
    <input type="text" size="100" name="titre" value="<?php echo $donnees['titre']; ?>" disabled="true" /><br/><br/>
    <b>Nombre de binôme souhaités : <input type="text" size="1" name="wish" value="<?php echo $donnees['binwish']; ?>" disabled="true" maxlength="1" /> &nbsp; Nombre de binôme possibles : <input type="text" size="1" maxlength="1" value="<?php echo $donnees['binpos']; ?>" name="possible" disabled="true" /></b><br/><br/>
    <b>Description : </b><br/>
    <textarea name="description" cols="100" rows="16" disabled="true"><?php echo stripslashes($donnees['description']); ?></textarea>
    <br/><br/>
    <b>Qualification : </b>
    </p>	
    <table class="addproj">
    <tr>
    <td colspan="2"><?php if(!empty($donnees['dom_appl'])) echo $donnees['dom_appl']; else echo "Aucune"; ?></td>
    </tr>
    </table>	
    <br/>
    <p>
    <b>Domaines d'application : </b></br>
    <textarea name="domaine" cols="100" rows="4" disabled="true"><?php if(!empty($donnees['dom_appl'])) echo $donnees['dom_appl']; else echo "Aucun"; ?></textarea><br/><br/>
    <b>Matériels & logiciels utilisés : </b><br/>
    <textarea name="matos" cols="100" rows="2" disabled="true"><?php if(!empty($donnees['dom_appl'])) echo $donnees['mat_log']; else echo "Aucun"; ?></textarea><br/><br/>
    <b>Remarques : </b><br/>
    <textarea name="rem" cols="100" rows="7" disabled="true"><?php if(!empty($donnees['dom_appl'])) echo $donnees['remarques']; else echo "Aucune"; ?></textarea>
    </p>
    
    </form>