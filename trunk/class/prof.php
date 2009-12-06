<?php 
class prof 
{
	private $nom;
	private $prenom;	
	private $login;
	private $password;
	private $droit;	//entier qui vaut 1 si l'utilisateur est un administrateur, 0 sinon
	
	
	/*
	* Constructeur, permet de renseigner les attributs de l'objet
	* $login : login de l'utilisateur
	*/
	public function __construct ($login) // Permet de renseigner les attributs de l'objet
	{
		$r = mysql_query("SELECT * FROM prof WHERE login='" . $login . "'");
		$ligne = mysql_fetch_assoc($r);			
		$this->nom = $ligne['nom'];
		$this->prenom = $ligne['prenom'];
		$this->login = $login;
		$this->password = $ligne['pwd'];
		$this->droit = $ligne['droit'];
	}


	/*
	* Retourne le nom et le prénom de l'utilisateur sous forme de String
	*/
	public function name()
	{
		return $this->nom . ' ' . $this->prenom;
	}
	
	/*
	* Retourne vrai si le mot de passe est égal a la string donné en parametre
	*/
	public function compare_mdp($mdp) {
		return $this->password == md5($mdp);
	}

	/*
	* Retourne le type de l'utilisateur(éleves ou prof)
	*/
	public function type()
	{
		return "prof";
	}

	/*
	* A MODIFIER : ACCESSEUR
	* Retourne la valeur de droit (1 si administrateur, 0 sinon)
	*/
	public function get_droit()
	{
	return $this->droit;
	}

	/*
	* A MODIFIER : ACCESSEUR
	* retourne le login de l'utilisateur
	*/
	public function info_login()
	{
		return $this->login;
	}
	
	/*
	* Modifie et enregistre le mot de passe de l'utilisateur
	*/
	public function changer_pass($pass)
	{
		$this->password = md5($pass);
		mysql_query("UPDATE " . $this->type() . " SET pwd = '" . $this->password . "' WHERE login = '" . $this->login . "'");
	
	}
	
	
	/*
	* Ajoute un projet dans la base de données
	*/
	public function enregistrer_projet($nomtuteur2,$prenomtuteur2, $titre, $nb_wish, $nb_possible, $qualif, $remarque, $description, $domaine, $materiel,$niveau) 
	{
		if (!empty($nomtuteur2)) // Vérification du deuxieme tuteur entré : est-il non vide ?
			{
				$tut2 = mysql_query("SELECT login FROM prof WHERE (nom='" . strtoupper($nomtuteur2) . "' AND prenom='" . strtolower($prenomtuteur2) . "')") OR die ('Le nom du deuxième tuteur est incorrect');
				$tut2 = mysql_fetch_assoc($tut2);
				$tut2 = $tut2['login']; // on récupere le login du nom tapé
			}
			else
			{
				$tut2 = "";
			}				
			
		   $qualif = substr($qualif,0,-1); // supprime le dernier caractere pour éviter d'avoir une virgule en fin de chaine.
		   // dois-je protéger les variables ? les profs vont-ils s'amuser à mettre du html dans les blocs ?
		   if( $remarque == "")	$remarque = "Aucune";	
		   
		   if(empty($niveau)) die ('Il n\'y a pas de niveau !<script type="text/javascript">redirection("enregistrer_projet");</script>');

		   mysql_query("INSERT INTO projets VALUES('', '" . $this->login . "','" . $tut2 . "' , '" . $titre . "', '" . $nb_wish . "', '" . $nb_possible . "', '" . $description . "', '" . $qualif . "', '" . $domaine . "', '" . $materiel . "', '" . $remarque . "','" . $niveau . "')");
			echo '<p style="font-weight:bold;color:#26a200;">Projet ajouté !</p>';
	}
	
	/*
	* Ajoute les indisponibilités d'un prof
	*/
	public function ajouter_indisponibilite()
	{
		$jours = array('LU','MA','ME','JE','VE'); // Tableau de jours

		for ($j = 0 ; $j <= 4 ; $j++) // Pour chaque jour de la semaine : 5 jours
		{
			$semaine[$j] = ";"; // On itinialise chaque début de jour avec un ";" pour avoir un découpage correct plus tard
			for ($i = 1 ; $i <= 11 ; $i++) // Pour chaque heure de la journée : 11 heures (rajouter 7 heures pour chaque chiffre)
			{	
				if ($_POST[$jours[$j] . $i] != "")
				{
					$semaine[$j] .= $i . ';'; // On ajoute dans le tableau de chaque jour le numéro de l'heure indisponible
				}
			}		
		}
		mysql_query("INSERT INTO indisponibilite VALUES ('" . $this->login . "','" . $semaine[0] . "','" . $semaine[1] . "','" . $semaine[2] . "','" . $semaine[3] . "','" . $semaine[4] . "')");
		
		echo 'Disponibilités ajoutés';
	}
	
	/*
	* Permet de récupérer les indisponibilité de l'utilisateur
	*/
	public function recup_indisponibilites() {
		$retour = mysql_query('SELECT * FROM indisponibilite WHERE login = "'.$this->login.'"');
		$donnees = mysql_fetch_array($retour);
		return $donnees;		
	}
	
	/*
	* Permet de modifier les indisponibilités de l'utilisateur
	* Voir les commentaires de la méthode ajouter_indisponibilte pour détails
	*/
	public function modifier_indisponibilite() {
		$jours = array('LU','MA','ME','JE','VE'); 

		for ($j = 0 ; $j <= 4 ; $j++)
		{
			$semaine[$j] = ";";
			for ($i = 1 ; $i <= 11 ; $i++)
			{	
				if ($_POST[$jours[$j] . $i] != "")
				{
				$semaine[$j] .= $i . ';';
				}
			}		
		}
		mysql_query("UPDATE indisponibilite SET lundi = '" . $semaine[0] . "', mardi = '" . $semaine[1] . "', mercredi = '" . $semaine[2] . "', jeudi = '" . $semaine[3] . "', vendredi = '" . $semaine[4] . "' WHERE login = '".$this->login."'");
		echo 'Disponibilités modifiées !';
	}
	
	
/*--------------------------------------------------------------------------------
			Fonctions d'administration accessibles seulement si droit = 1
----------------------------------------------------------------------------------*/

	/*
	* Ecritute du fichier contenant les souhaits des binômes afin de le transmettre au responsable des affectations : M.COLETTA
	*/
	public function creer_fichier_souhaits()
	{
		$MonFichier = "../files/wishbin." . $_GET['niveau'] . ".txt"; // Chemin du fichier final
		$F = fopen($MonFichier,"w"); // On crée le fichier
		$texte = "";
		$sql = mysql_query("SELECT * FROM wish WHERE niveau= '" . $_GET['niveau'] . "'"); // on récupere tous les souhaits par niveau
		while ($data = mysql_fetch_array($sql))
		{
			$texte .= $data['id_bin'] . "," . $data['wish1'] . "," . $data['wish2'] . "," . $data['wish3'] . "," . $data['wish4'] . "," . $data['wish5'] . "\r\n"; // On crée ligne par ligne le fichier de souhaits
		}
		
		// pour écrire dans le fichier
		fwrite($F,$texte);
		fclose($F);

		echo '<a href="' . $MonFichier . '">Adresse du fichier texte pour les voeux formulé par les étudiants</a>';
	}

	/*
	* Ajouter a partir d'un fichier CSV les utilisateurs dans la base de donnée (est utilisé uniquement pour les éleves car les professeurs ne changent pas tous les ans)
	*/
	public function ajouter_multiutilisateur($fichier, $niveau)
	{
		$infosfichier = pathinfo($fichier['name']);
		if (strtolower($infosfichier['extension']) == "csv") // Vérification de l'extension
		{
			$nomfichier = "fichierBD_".$niveau.".csv"; // On donne un nom au fichier qui a été uploadé
			$chemin = '../files/'. $nomfichier; // On définit ou il sera placé
			move_uploaded_file($fichier['tmp_name'], $chemin); // On déplace le fichier dans le dossier "files" du serveur
			echo "Envoie effectué ! <br/>
			Traitement du fichier en cours...<br/><br />";
		
			$requete = "INSERT INTO eleves VALUES ";
			$f = fopen('../files/fichierBD_'.$niveau.'.csv', 'r'); // On ouvre le fichier uploadé
			while ($data = fgetcsv($f, 1000, "," )){ // On parcours le fichier ligne par ligne et on découpe chaque ligne en string a chaque ","
				$nbre = count($data);
				$requete .= "('" . $data[0] . "','" . $data[1] . "','" . $data[2] . "','" . $data[3] . "','" . $data[4] . "','" . $data[5] . "', '".$niveau."'),";
			}
			fclose($f); // On ferme le fichier
			$requete = substr($requete,0,-1); // On eleve la derniere requete car la derniere est créée uniquement par le retour a la ligne automatique dans le fichier (a vérifier)
	
			mysql_query($requete);
			
			if(preg_match("#Duplicate entry#", mysql_error())) // On vérifie s'il y a un doublon dans les logins
			{
				echo 'Un login équivalent a été trouvé dans la base de données, veuillez <a href="suppr_alluser.php">vider la table</a> ou <a href="suppr_user.php">supprimer un utilisateur</a>. Vérifiez qu\'il n\'y a pas un login identique pour deux éleves dans le fichier généré par le convertisseur.<br />Erreur MYSQL : '.mysql_error();
			}
			else
			{
				echo mysql_error();
				echo '<p style="font-weight:bold;color:#26a200;">Envoi correctement effectué !</p>';
			}			
		}
		else
		{
			echo 'Extension incorrecte, veuillez rééssayer';
		}
	}

	/*
	* Ajout ou modification des informations d'un utilisateur dans la base de donnée (un éleve ou un prof)
	*/
	public function ajouter_utilisateur()
	{
		if ($_POST['mdp'] == $_POST['mdp2'] && $_POST['mdp'] != "")
		{
			$_POST['gen'] ? $champgenerique = 1 : $champgenerique = 0;
			
			if ($_POST['mode'] == 'Ajouter')
			{
				if ($_POST['type'] == "eleves") 
				{
					mysql_query("INSERT INTO " . $_POST['type'] . " VALUES('" . $_POST['nom'] . "','" . $_POST['prenom'] . "','" . $_POST['groupe'] . "','" . strtolower($_POST['login']) . "','" . md5($_POST['mdp']) . "','" . $champgenerique . "','" . $_POST['niveau'] . "')");
				}
				else
				{					
					mysql_query("INSERT INTO " . $_POST['type'] . " VALUES('" . $_POST['nom'] . "','" . $_POST['prenom'] . "','" . strtolower($_POST['login']) . "','" . md5($_POST['mdp']) . "','" . $champgenerique . "')");
				}
			}
			else if ($_POST['mode'] == 'Modifier')
			{	
		
				if ($_POST['type'] == "eleves") 
				{	
					mysql_query("UPDATE " . $_POST['type'] . " SET nom='" . $_POST['nom'] . "',prenom='" . $_POST['prenom'] . "',groupe='" . $_POST['groupe'] . "',login='" . strtolower($_POST['login']) . "',pwd='" . md5($_POST['mdp']) . "',boolbin='" . $champgenerique . "',niveau='" . $_POST['niveau'] . "' WHERE login='" . $_POST['loginold'] . "'");
				}
				else
				{						
					mysql_query("UPDATE " . $_POST['type'] . " SET nom='" . $_POST['nom'] . "',prenom='" . $_POST['prenom'] . "',login='" . strtolower($_POST['login']) . "',pwd='" . md5($_POST['mdp']) . "',droit='" . $champgenerique . "' WHERE login='" . $_POST['loginold'] . "'");
				}	
			}			
			echo '<script type="text/javascript"> windows.Location =?page=gestion_users&type=' . $_POST['type'] . '</script>';
		}
		else
		{
		echo 'Erreur les deux mots de passes ne sont pas identiques';
		}
	
	}

	/*
	* Supprime un binôme 
	* $id : numéro du binôme a supprimer
	*/
	public function supprimer_binome($id)
	{
		$this->rajouter_binome_liste($id);
		mysql_query("DELETE	FROM binome WHERE num='" . $id . "'");
	}

	/*
	* Mise a zéro du boolbin des deux éleves d'un binôme
	* $id : numéro du binôme a traiter
	*/
	private function rajouter_binome_liste($id)
	{
		$binome = mysql_query("SELECT * FROM binome WHERE num='" . $id . "'");
		$binome = mysql_fetch_assoc($binome);
		mysql_query("UPDATE eleves SET boolbin='0' WHERE (login='" . $binome['nom1'] . "' OR login='" .$binome['nom2'] . "')");
	}
	
	/*
	* Effectue la modification des binomes
	* Il faut donc remettre boolbin a 0 puis remettre a 1 pour les deux nouveaux membres
	*/
	public function	modifier_binome()
	{
		$modif = mysql_query("SELECT nom1,nom2 FROM binome WHERE num='" . $_GET['id'] . "'");
		$modif = mysql_fetch_assoc($modif);
		mysql_query("UPDATE eleves SET boolbin='0' WHERE login='" . $modif['nom1'] . "' OR login='" . $modif['nom2'] . "'"); // mise à 0 des anciens noms
		mysql_query("UPDATE binome SET nom1='" . $_POST['nom1'] . "', nom2='" . $_POST['nom2'] . "', valide='1'"); //modification du tuple
		mysql_query("UPDATE eleves SET boolbin='1' WHERE login='" . $_POST['nom1'] . "' OR login='" . $_POST['nom2'] . "'"); // mise à 1 pour le nouveau binome
	}

	/*
	* Permet d'enregistrer le planning des dates pour chaque niveau
	*/
	public function enregistrer_date()
	{
		for ($i = 0 ; $i <= 9 ; $i++) // Pour chaque mois de l'année scolaire
		{
			$moi = $this->mois_en_chiffre($_POST['m' . $i], $mois); // On récupere le numéro du mois concerné
			$dates[$i] = mktime($_POST['h' . $i], $_POST['mm' . $i], 0, $moi, $_POST['j' . $i], $_POST['a' . $i]); // On crée le TIMESTAMP de chaque date entrée
		}
		
		$annee = $_POST['a1']; // On récupere l'année scolaire donnée
		mysql_query("INSERT INTO date VALUES('" .$annee	. "','" . $dates[0] . "','" . $dates[1] . "','" . $dates[2] . "','" . $dates[3] . "','" . $dates[4] . "','" . $dates[5] . "','" . $dates[6] . "','" . $dates[7] . "','" . $dates[8] . "','" . $dates[9] . "','" . $_POST['niveau'] . "')");
	}	
		
	/*
	* Renvoie le numéro de mois par rapport au mois en toute lettre
	*/	
	private function  mois_en_chiffre($val,$moi) 
	{
		$i = 0;
		while ($i < 12 && ($moi[$i] != $val))
		{
			$i++;	
		}
		return ($i + 1);
	}

	/*
	* Fonction de supression d'utilisateur
	*/
	public function supprimer_utilisateur($login,$type) 
	{
		$requete = "DELETE FROM " . $type;
		if($login != "all") 
			$requete .= " WHERE login='" . $login . "'";		
		mysql_query($requete);
	}

	/*
	* Permet d'ajouter une soutenance
	*/
	public function ajouter_soutenance()
	{
		$exist = mysql_query("SELECT id_bin FROM soutenance WHERE id_bin='" . $out . "'");
		$exist = mysql_fetch_assoc($exist);		
		if ($exist['id_bin'] == "")
		{
			$r = mysql_query("SELECT deb_soutenance FROM date ORDER BY annee DESC");
			$date = mysql_fetch_assoc($r);
			if($other) // cas date en dehors de la liste
				$jour_soutenance = mktime($_POST['h'],0,0,$_POST['m'],$_POST['j'],date("Y",$date['deb_soutenance']));
			else			
				$jour_soutenance = mktime($_POST['h'],0,0,date("m",$date['deb_soutenance']),$_POST['jours'],date("Y",$date['deb_soutenance']));		
			
			if (!isset($_GET['bin']))							
				mysql_query("INSERT INTO soutenance VALUES ('" . $_POST['bin'] . "','" . $jour_soutenance . "','" . $_POST['salle'] . "','" . $_POST['jure'] . "')");					
			else			
			mysql_query("UPDATE soutenance SET id_bin='" . $_POST['bin'] . "', date='" . $jour_soutenance . "', salle='" . $_POST['salle'] . "',tuteur_comp='" . $_POST['jure'] . "' WHERE id_bin='" . $_GET['bin'] . "'");
		}
		else
			echo 'Erreur ! La soutenance pour ce bin&ocirc;me a d&eacute;j&agrave; &eacute;t&eacute;.';

	}

	/*
	* Permet de récupérer le fichier d'affectation et de mettre a jour la base de données
	*/
	public function recuperer_affectation($fichier,$niveau)
	{
		$infosfichier = pathinfo($fichier['name']);
		if (strtolower($infosfichier['extension']) == "txt");
		{
			$nomfichier = "wishaffect.txt";
			$chemin = '../files/'. $nomfichier;
			move_uploaded_file($fichier['tmp_name'], $chemin);
			echo "Envoie effectué ! \n";
		}	
	
		$MonFichier = "../files/wishaffect.txt";
		$F = fopen($MonFichier,"r");
		$texte = "";	
		$motif = "#[0-9]+#"; // recherche d'un ou plusieurs chiffre
		while (!feof($F))
		{
			$texte = fgets($F,255);
			preg_match_all($motif,$texte,$out);  // renvoie dans le tableau out toute les occurences par rapport au motif		
			mysql_query("UPDATE binome SET id_proj='" . $out[0][1] . "' WHERE num='" . $out[0][0] . "' AND niveau='" . $niveau . "'");			
		
		}
		fclose($F);
	}
	
	
	/*
	*
	*/
	public function prof_disponibles_heure($jour, $heure) {
		$profs_dispos = array();
		$retour = mysql_query('SELECT * FROM indisponibilite');
		while($donnees = mysql_fetch_array($retour)) {
			$indispos_prof = explode(";", $donnees[$jour]); // liste des heures ou le prof n'est pas la le jour demandé
			if(!in_array($heure, $indispos_prof)) // si l'heure demandé ne fait pas partie de ses indisponibilités
				$profs_dispos[] = $donnees['login']; // on l'ajoute a la liste des profs disponibles
		}
		return $profs_dispos;
	}
	
}
?>