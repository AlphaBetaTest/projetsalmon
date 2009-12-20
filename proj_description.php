<html>
   <head>
       <title>Maquette projet</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />	
			<link rel="stylesheet" type="text/css" href="template/screen.css" media="screen" />
			<link rel="stylesheet" type="text/css" media="screen" href="template/screenIE.css" media="screen" />
			<link rel="stylesheet" type="text/css" media="screen" href="template/screenproj.css" media="screen" />
		<script src="overlay.js"></script>
	</head>
<body>

<div id="1" class="pop"><a href="javascript:cachetout();"><img src="images/fermerpop.jpg"/></a></div>
	<?php




include('cfg.php');


$donnees = mysql_query("SELECT * FROM projets WHERE id_proj ='" . $_GET['id'] . "'");
$donnees = mysql_fetch_assoc($donnees);

echo '<div class="popform"><form action="#" method="post" name="formulaire">
		<p><b>Tuteur(s) : </b><br/>
		Nom : <input type="text" size="20" value="' . $donnees['tuteur1'] . '" disabled="true" />
		<br/>
		Nom : <input type="text" size="20" value="' . $donnees['tuteur2'] . '" disabled="true" />
		<br/><br/>
		<b>Titre : </b><br/>
		<input type="text" size="132" value="' . $donnees['titre'] . '" disabled="true"/><br/><br/>		
		<b>Nombre de binôme souhaités : </b>	<input type="text" size="1" value="' . $donnees['binwish'] . '" disabled="true" /> &nbsp; Nombre de binôme possibles : <input type="text" size="1" disabled="true" value="' . $donnees['binpos'] . '"/></b><br/><br/>
		<b>Description : </b><br/>
		<textarea cols="100" rows="16" disabled="true">' . $donnees['description'] .'</textarea>
		<br/><br/>
		<b>Qualification : </b><br/>
		<input type="text" size="132" value="' . $donnees['qualif'] . '" disabled="true"/><br/>
		<br/>		
		<b>Domaines d\'application : </b></br>
		<textarea cols="100" rows="4" disabled="true">' . $donnees['dom_appl'] . '</textarea><br/><br/>
		<b>Matériels & logiciels utilisés : </b><br/>
		<textarea cols="100" rows="2" disabled="true">' . $donnees['mat_log'] . '</textarea><br/><br/>
		<b>Remarques : </b><br/>
		<textarea cols="100" rows="7" disabled="true">' . $donnees['rem'] . '</textarea>		
		</p>					
		</form></div>';	
?>
<div class="pop"><a href="#1">< Remonter en haut de la page ></a></div>
</body>
</html>