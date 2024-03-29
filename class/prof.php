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
	* Retourne le nom et le pr�nom de l'utilisateur sous forme de String
	*/
	public function name()
	{
		return $this->nom . ' ' . $this->prenom;
	}
	
	/*
	* Retourne vrai si le mot de passe est �gal a la string donn� en parametre
	*/
	public function compare_mdp($mdp) {
		return $this->password == md5($mdp);
	}

	/*
	* Retourne le type de l'utilisateur(�leves ou prof)
	*/
	public function type()
	{
		return "prof";
	}

	/*
	* A MODIFIER : ACCESSEUR
	* Retourne la valeur de droit (1 si administrateur, 0 sinon)
	*/
	public function get_droit($i)
	{
		return $this->droit == $i;
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
	* Ajoute un projet dans la base de donn�es
	*/
	public function enregistrer_projet($nomtuteur2,$prenomtuteur2, $titre, $nb_wish, $nb_possible, $qualif, $remarque, $description, $domaine, $materiel,$niveau, $groupe) 
	{
		if (!empty($nomtuteur2)) // V�rification du deuxieme tuteur entr� : est-il non vide ?
			{
				$tut2 = mysql_query("SELECT login FROM prof WHERE (nom='" . strtoupper($nomtuteur2) . "' AND prenom='" . strtolower($prenomtuteur2) . "')") OR die ('Le nom du deuxi�me tuteur est incorrect');
				$tut2 = mysql_fetch_assoc($tut2);
				$tut2 = $tut2['login']; // on r�cupere le login du nom tap�
			}
			else
			{
				$tut2 = "";
			}				
			
		   $qualif = substr($qualif,0,-1); // supprime le dernier caractere pour �viter d'avoir une virgule en fin de chaine.
		   // dois-je prot�ger les variables ? les profs vont-ils s'amuser � mettre du html dans les blocs ?
		   if( $remarque == "")	$remarque = "Aucune";	
		   
		   if(empty($niveau)) die ('<p class="warning">Il n\'y a pas de niveau !</p><script type="text/javascript">redirection("enregistrer_projet");</script>');

		   mysql_query("INSERT INTO projets VALUES('', '" . $this->login . "','" . addslashes($tut2) . "' , '" . addslashes($titre) . "', '" . addslashes($nb_wish) . "', '" . addslashes($nb_possible) . "', '" . addslashes($description) . "', '" . addslashes($qualif) . "', '" . addslashes($domaine) . "', '" . addslashes($materiel) . "', '" . addslashes($remarque) . "','" . addslashes($niveau) . "', '".addslashes($groupe)."')") or die('<p class="warning">Probleme lors de l\'ajout d\'un sujet : '.mysql_error().'</p>');
			echo '<p class="granted">Projet ajout� !</p>';
	}
	
	/*
	* R�cupere tous les sujets d'un professeur
	*/
	public function recup_sujets() {
		$sujets = array();
		$retour = mysql_query('SELECT * FROM projets WHERE tuteur1 = "'.$this->login.'" ORDER BY id_proj DESC');	
		while($donnees = mysql_fetch_array($retour)) {
			$sujets[] = $donnees;	
		}
		return $sujets;
	}
	
	/*
	* Permet de supprimer le sujet de parametre $id
	*/
	public function supprimer_sujet($id) {
		$retour = mysql_query('SELECT * FROM projets WHERE id_proj = "'.$id.'"');
		
		if(mysql_num_rows($retour) == 1) // ce projet existe t-il ?
			$donnees = mysql_fetch_array($retour);
		
		if($donnees['tuteur1'] == $this->login) { // appartient-il a l'utilisateur ?
			mysql_query('DELETE FROM projets WHERE id_proj = "'.$id.'"') or die('Erreur lors de la suppression du sujet');
			echo '<p class="granted">Projet supprim� !</p>';
		}
		else {
			echo '<p class="warning">Vous n\'avez pas le droit de supprimer ce sujet !</p>';	
		}
	}
	
	/*
	* Ajoute les indisponibilit�s d'un prof
	*/
	public function ajouter_indisponibilite()
	{
		$jours = array('LU','MA','ME','JE','VE'); // Tableau de jours

		for ($j = 0 ; $j <= 4 ; $j++) // Pour chaque jour de la semaine : 5 jours
		{
			$semaine[$j] = ";"; // On itinialise chaque d�but de jour avec un ";" pour avoir un d�coupage correct plus tard
			for ($i = 1 ; $i <= 11 ; $i++) // Pour chaque heure de la journ�e : 11 heures (rajouter 7 heures pour chaque chiffre)
			{	
				if ($_POST[$jours[$j] . $i] != "")
				{
					$semaine[$j] .= $i . ';'; // On ajoute dans le tableau de chaque jour le num�ro de l'heure indisponible
				}
			}		
		}
		mysql_query("INSERT INTO indisponibilite VALUES ('" . $this->login . "','" . $semaine[0] . "','" . $semaine[1] . "','" . $semaine[2] . "','" . $semaine[3] . "','" . $semaine[4] . "')");
		
		echo '<p class="granted">Disponibilit�s ajout�s</p>';
	}
	
	/*
	* Permet de r�cup�rer les indisponibilit� de l'utilisateur
	*/
	public function recup_indisponibilites($login) {
		$retour = mysql_query('SELECT * FROM indisponibilite WHERE login = "'.$login.'"');
		$donnees = mysql_fetch_array($retour);
		return $donnees;		
	}
	
	/*
	* Permet de modifier les indisponibilit�s de l'utilisateur
	* Voir les commentaires de la m�thode ajouter_indisponibilte pour d�tails
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
		echo '<p class="granted">Disponibilit�s modifi�es !</p>';
	}
	
	
/*--------------------------------------------------------------------------------
			Fonctions d'administration accessibles seulement si droit = 1
----------------------------------------------------------------------------------*/

	/*
	* Ecritute du fichier contenant les souhaits des bin�mes afin de le transmettre au responsable des affectations : M.COLETTA
	*/
	public function creer_fichier_souhaits($niveau)
	{
		$MonFichier = "../files/wishbin." . $niveau . ".txt"; // Chemin du fichier final
		$F = fopen($MonFichier,"w"); // On cr�e le fichier
		$texte = "";
		$sql = mysql_query("SELECT * FROM wish WHERE niveau= '" . $niveau . "'"); // on r�cupere tous les souhaits par niveau
		while ($data = mysql_fetch_array($sql))
		{
			$texte .= $data['id_bin'] . "," . $data['wish1'] . "," . $data['wish2'] . "," . $data['wish3'] . "," . $data['wish4'] . "," . $data['wish5'] . "\r\n"; // On cr�e ligne par ligne le fichier de souhaits
		}
		
		// pour �crire dans le fichier
		fwrite($F,$texte);
		fclose($F);

		echo '<p><a href="' . $MonFichier . '">Adresse du fichier texte pour les voeux formul� par les �tudiants</a></p>';
	}

	/*
	* Ajouter a partir d'un fichier CSV les utilisateurs dans la base de donn�e (est utilis� uniquement pour les �leves car les professeurs ne changent pas tous les ans)
	*/
	public function ajouter_multiutilisateur($fichier, $niveau)
	{
		$infosfichier = pathinfo($fichier['name']);
		if (strtolower($infosfichier['extension']) == "csv") // V�rification de l'extension
		{
			$nomfichier = "fichierBD_".$niveau.".csv"; // On donne un nom au fichier qui a �t� upload�
			$chemin = '../files/'. $nomfichier; // On d�finit ou il sera plac�
			move_uploaded_file($fichier['tmp_name'], $chemin); // On d�place le fichier dans le dossier "files" du serveur
			echo "<p class=\"granted\">Envoie effectu� ! <br/>
			Traitement du fichier en cours...</p>";
		
			$requete = "INSERT INTO eleves VALUES ";
			$f = fopen('../files/fichierBD_'.$niveau.'.csv', 'r'); // On ouvre le fichier upload�
			while ($data = fgetcsv($f, 1000, "," )){ // On parcours le fichier ligne par ligne et on d�coupe chaque ligne en string a chaque ","
				$nbre = count($data);
				$requete .= "('" . $data[0] . "','" . $data[1] . "','" . $data[2] . "','" . $data[3] . "','" . $data[4] . "','" . $data[5] . "', '".$niveau."'),";
			}
			fclose($f); // On ferme le fichier
			$requete = substr($requete,0,-1); // On eleve la derniere requete car la derniere est cr��e uniquement par le retour a la ligne automatique dans le fichier (a v�rifier)
	
			mysql_query($requete);
			
			if(preg_match("#Duplicate entry#", mysql_error())) // On v�rifie s'il y a un doublon dans les logins
			{
				echo '<p class="warning">Un login �quivalent a �t� trouv� dans la base de donn�es, veuillez <a href="suppr_alluser.php">vider la table</a> ou <a href="suppr_user.php">supprimer un utilisateur</a>. V�rifiez qu\'il n\'y a pas un login identique pour deux �leves dans le fichier g�n�r� par le convertisseur.<br />Erreur MYSQL : '.mysql_error().'</p>';
			}
			else
			{
				echo mysql_error();
				echo '<p class="granted">Envoi correctement effectu� !</p>';
			}			
		}
		else
		{
			echo '<p class="warning">Extension incorrecte, veuillez r��ssayer</p>';
		}
	}

	/*
	* Ajout ou modification des informations d'un utilisateur dans la base de donn�e (un �leve ou un prof)
	*/
	public function ajouter_utilisateur($mdp, $mdp2, $gen, $mode, $type, $nom, $prenom, $groupe, $login, $niveau, $loginold)
	{
		if ($mdp == $mdp2 && $mdp != "")
		{
			$gen ? $champgenerique = 1 : $champgenerique = 0;
			
			if ($mode == 'Ajouter')
			{
				if ($type == "eleves") 
				{
					mysql_query("INSERT INTO " . $type . " VALUES('" . $nom . "','" . $prenom . "','" . $groupe . "','" . strtolower($login) . "','" . md5($mdp) . "','" . $champgenerique . "','" . $niveau . "')");
				}
				else
				{					
					mysql_query("INSERT INTO " . $type . " VALUES('" . $nom . "','" . $prenom . "','" . strtolower($login) . "','" . md5($mdp) . "','" . $champgenerique . "')");
				}
			}
			else if ($mode == 'Modifier')
			{	
		
				if ($type == "eleves") 
				{	
					mysql_query("UPDATE " . $type . " SET nom='" . $nom . "',prenom='" . $prenom . "',groupe='" . $groupe . "',login='" . strtolower($login) . "',pwd='" . md5($mdp) . "',boolbin='" . $champgenerique . "',niveau='" . $niveau . "' WHERE login='" . $loginold . "'");
				}
				else
				{						
					mysql_query("UPDATE " . $type . " SET nom='" . $nom . "',prenom='" . $prenom . "',login='" . strtolower($login) . "',pwd='" . md5($mdp) . "',droit='" . $champgenerique . "' WHERE login='" . $loginold . "'");
				}	
			}			
			echo '<script type="text/javascript"> windows.Location =?page=gestion_users&type=' . $type . '</script>';
		}
		else
		{
		echo '<p class="warning">Erreur les deux mots de passes ne sont pas identiques</p>';
		}
	
	}

	/*
	* Supprime un bin�me 
	* $id : num�ro du bin�me a supprimer
	*/
	public function supprimer_binome($id)
	{
		$this->rajouter_binome_liste($id);
		mysql_query("DELETE	FROM binome WHERE num='" . $id . "'");
	}

	/*
	* Mise a z�ro du boolbin des deux �leves d'un bin�me
	* $id : num�ro du bin�me a traiter
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
	public function	modifier_binome($nom1, $nom2, $id)
	{
		$modif = mysql_query("SELECT nom1,nom2 FROM binome WHERE num='" . $id . "'");
		$modif = mysql_fetch_assoc($modif);
		mysql_query("UPDATE eleves SET boolbin='0' WHERE login='" . $modif['nom1'] . "' OR login='" . $modif['nom2'] . "'"); // mise � 0 des anciens noms
		mysql_query("UPDATE binome SET nom1='" . $nom1 . "', nom2='" . $nom2 . "', valide='1' WHERE num='".$id."'"); //modification du tuple
		mysql_query("UPDATE eleves SET boolbin='1' WHERE login='" . $nom1 . "' OR login='" . $nom2 . "'"); // mise � 1 pour le nouveau binome
	}

	/*
	* Permet d'enregistrer le planning des dates pour chaque niveau
	*/
	public function enregistrer_date($tab_m, $tab_h, $tab_mm, $tab_j, $tab_a, $annee, $niveau)
	{
		for ($i = 0 ; $i <= 10 ; $i++) // Pour chaque mois de l'ann�e scolaire
		{
			$mois = array("Janvier","F�vrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","D�cembre");
			$moi = $this->mois_en_chiffre($tab_m[$i], $mois); // On r�cupere le num�ro du mois concern�
			$dates[$i] = mktime($tab_h[$i], $tab_mm[$i], 0, $moi, $tab_j[$i], $tab_a[$i]); // On cr�e le TIMESTAMP de chaque date entr�e
		}
		
		if($niveau != "A2") $dates[10] == 0;
		
		mysql_query("INSERT INTO date VALUES('" .$annee	. "','" . $dates[0] . "','" . $dates[1] . "','" . $dates[2] . "','" . $dates[3] . "','" . $dates[4] . "','" . $dates[5] . "','" . $dates[6] . "','" . $dates[7] . "','" . $dates[8] . "','" . $dates[9] . "','" . $niveau . "', '".$dates[10]."')");
	}	
	
	/*
	* Permet de mettre a jour le planning des dates pour chaque niveau
	*/
	public function modifier_date($tab_m, $tab_h, $tab_mm, $tab_j, $tab_a, $annee, $niveau)
	{
		for ($i = 0 ; $i <= 10 ; $i++) // Pour chaque mois de l'ann�e scolaire
		{
			$mois = array("Janvier","F�vrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","D�cembre");
			$moi = $this->mois_en_chiffre($tab_m[$i], $mois); // On r�cupere le num�ro du mois concern�
			$dates[$i] = mktime($tab_h[$i], $tab_mm[$i], 0, $moi, $tab_j[$i], $tab_a[$i]); // On cr�e le TIMESTAMP de chaque date entr�e
		}
		
		if($niveau != "A2") $dates[10] == 0;
		
		mysql_query("UPDATE date SET annee='" .$annee. "', construction_binome='" .$dates[0]. "', enregistrement_projet='" .$dates[1] . "', reunion_coor='" . $dates[2] . "', diffusion_sujet='" . $dates[3] . "', formulation_voeux='" . $dates[4] . "', affectation_sujet='" . $dates[5] . "', rapport_pre='" . $dates[6] . "', remise_rapport='" . $dates[7] . "', deb_soutenance='" . $dates[8] . "', fin_soutenance='" . $dates[9] . "', soutenance_etranger='". $dates[10] ."' WHERE niveau='" . $niveau . "'") or die('<p class="warning">Erreur lors de la MAJ : </p>'.mysql_error());
	}	
		
	/*
	* Renvoie le num�ro de mois par rapport au mois en toute lettre
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
	* num_bin : num�ro du binome concern�
	* niveau : niveau du binome
	* jour : jour de la soutenance
	* heure : heure de la soutenance
	* salle : salle de la soutenance
	* jury : jury pr�sent a la soutenance
	* modif : si la soutenance est en train d'etre modifi�e ou non
	*/
	public function ajouter_soutenance($num_bin, $niveau, $jour, $heure, $salle, $jury, $modif)
	{
			$r = mysql_query("SELECT deb_soutenance FROM date WHERE niveau = '".$niveau."'");
			$date = mysql_fetch_assoc($r);
			
			// suivant le jour qu'on a donn�, on calcule le d�calage entre le premier jour des soutenance et le jour donn�
			switch($jour) { 
				case "lundi" : $valeur_j = date("d", $date['deb_soutenance'])+1-date("w", $date['deb_soutenance']); break;
				case "mardi" : $valeur_j = date("d", $date['deb_soutenance'])+2-date("w", $date['deb_soutenance']); break;
				case "mercredi" : $valeur_j = date("d", $date['deb_soutenance'])+3-date("w", $date['deb_soutenance']); break;
				case "jeudi" : $valeur_j = date("d", $date['deb_soutenance'])+4-date("w", $date['deb_soutenance']); break;
				case "vendredi" : $valeur_j = date("d", $date['deb_soutenance'])+5-date("w", $date['deb_soutenance']); break;
				default : $valeur_j = $jour;
			}
			
			$jour_soutenance = mktime($heure+7, 0, 0, date("m", $date['deb_soutenance']), $valeur_j, date("Y", $date['deb_soutenance']));

			if (!$modif) { // si on ne modifie pas
				mysql_query("INSERT INTO soutenance VALUES ('" . $num_bin . "','" . $jour_soutenance . "','" . $salle . "','" . $jury . "')");
				echo '<p class="granted">Soutenance ajout�e !</p>';
			}
			else {
				mysql_query("UPDATE soutenance SET date='" . $jour_soutenance . "', salle='" . $salle . "', tuteur_comp='" . $jury . "' WHERE id_bin='" . $num_bin . "'") or die('Pas de MAJ');
				echo '<p class="granted">Soutenance modifi�e !</p>';
			}
	}

	/*
	* Permet de r�cup�rer le fichier d'affectation et de mettre a jour la base de donn�es
	*/
	public function recuperer_affectation($fichier,$niveau)
	{
		$infosfichier = pathinfo($fichier['name']);
		if (strtolower($infosfichier['extension']) == "txt"); // si on a un fichier texte
		{
			$nomfichier = "wishaffect.txt"; // on le renomme
			$chemin = '../files/'. $nomfichier; // on d�fini son chemin de destination
			move_uploaded_file($fichier['tmp_name'], $chemin); // on l'envoi sur le serveur
			echo "<p class=\"granted\">Envoie effectu� ! </p>";
		}	
	
		$MonFichier = "../files/wishaffect.txt"; // on d�finit le fichier a analyser
		$F = fopen($MonFichier,"r"); // on l'ouvre en lecture
		$texte = "";	
		$motif = "#[0-9]+#"; // recherche d'un ou plusieurs chiffre : le premier chiffre de chaque ligne correspond au binome, le deuxieme est le num�ro de sujet
		while (!feof($F)) // on parcourt tout le fichier
		{
			$texte = fgets($F,255);
			preg_match_all($motif,$texte,$out);  // renvoie dans le tableau out toute les occurences par rapport au motif		
			mysql_query("UPDATE binome SET id_proj='" . $out[0][1] . "' WHERE num='" . $out[0][0] . "' AND niveau='" . $niveau . "'");			
		
		}
		fclose($F);
	}
	
	
	/*
	* renvoi la liste des professeurs disponibles a une heure et un jour donn�
	*/
	public function prof_disponibles_heure($jour, $heure) {
		$profs_dispos = array(); // tableau des profs disponibles
		$profs_indispos = array(); // tableau des profs indisponibles
		$retour = mysql_query('SELECT * FROM indisponibilite'); // on r�cupere les indisponibilit�s de tous les profs
		while($donnees = mysql_fetch_array($retour)) {
			$indispos_prof = explode(";", $donnees[$jour]); // liste des heures ou le prof n'est pas la le jour demand�
			if(!in_array($heure, $indispos_prof)) // si l'heure demand� ne fait pas partie de ses indisponibilit�s
				$profs_dispos[] = $donnees['login']; // on l'ajoute a la liste des profs disponibles
			
			if(in_array($heure, $indispos_prof)) // si l'heure demand�e fait parti des heures ou le prof n'est pas la
				$profs_indispos[] = $donnees['login'];
		}
		
		$ret = mysql_query('SELECT login FROM prof'); // on r�cupere tous les profs
		while($d = mysql_fetch_array($ret)) {
			if(!in_array($d['login'], $profs_indispos) && !in_array($d['login'], $profs_dispos)) // si le prof courant ne fait pas parti de ceux indisponibles, alors il est disponible
				$profs_dispos[] = $d['login'];
		}
		sort($profs_dispos);
		
		return $profs_dispos;
	}
	
	/*
	* Permet de r�cup�rer les dates du planning suivant le niveau donn�
	*/
	public function recup_dates_planning($niveau) {
		$retour = mysql_query('SELECT * FROM date WHERE niveau ="'.$niveau.'"');
		$donnees = mysql_fetch_array($retour);
		
		$valeurs = array();
		
		if(mysql_num_rows($retour) > 0) {
			$valeurs[0] = $donnees['construction_binome'];
			$valeurs[1] = $donnees['enregistrement_projet'];
			$valeurs[2] = $donnees['reunion_coor'];
			$valeurs[3] = $donnees['diffusion_sujet'];
			$valeurs[4] = $donnees['formulation_voeux'];	
			$valeurs[5] = $donnees['affectation_sujet'];
			$valeurs[6] = $donnees['rapport_pre'];
			$valeurs[7] = $donnees['remise_rapport'];
			$valeurs[8] = $donnees['deb_soutenance'];
			$valeurs[9] = $donnees['fin_soutenance'];
			$valeurs[10] = $donnees['soutenance_etranger'];
			
			$dates = array();
			
			for($i=0; $i<11; $i++) {
				$dates[$i][0] = date('d', $valeurs[$i]);
				$dates[$i][1] = date('m', $valeurs[$i]);
				$dates[$i][2] = date('Y', $valeurs[$i]);
				$dates[$i][3] = date('H', $valeurs[$i]);
				$dates[$i][4] = date('i', $valeurs[$i]);
			}
		}
		return $dates;
	}
	
	/*
	* Permet de remettre a z�ro les tables pass�es en parametre
	*/
	public function RAZ($b, $e, $d, $i, $s, $p, $souhaits) {
		if($b == "on") mysql_query('DELETE FROM binome') or die('Probl�mes suppression binomes');
		if($e == "on") mysql_query('DELETE FROM eleves') or die('Probl�me suppression eleves');
		if($d == "on") mysql_query('DELETE FROM date') or die('Probl�me suppression dates');
		if($i == "on") mysql_query('DELETE FROM indisponibilite') or die('Probl�me suppression indisponibilites');
		if($s == "on") mysql_query('DELETE FROM soutenance') or die('Probl�me suppression soutenances');
		if($p == "on") mysql_query('DELETE FROM projets') or die('Probl�me suppression projets');
		if($souhaits == "on") mysql_query('DELETE FROM wish') or die ('Probl�me suppression souhaits');

		echo '<p class="granted">Remise � z�ro effectu�e !</p>';
	}
	
	/*
	* G�nere le compteur projet/soutenance au format .csv
	*/
	public function generer_compteur_csv() {
		$fichier = fopen('../files/compteur_projet.csv', 'w'); // on cr�e le fichier CSV s'il n'existe pas dans le dossier files
		
		fputcsv($fichier, array("Nom", "Nombre de projet(s)", "D�tail", "Nombre de soutenances")); // on ajoute les intitul�s des colonnes dans le fichier
		
		$sql = mysql_query("SELECT login,nom,prenom FROM prof"); // on r�cupere tous les professeurs
		while ($donnees = mysql_fetch_array($sql)) // pour chaque prof
		{
	
			$compteurtot = mysql_query("SELECT count(id_proj) FROM projets WHERE (tuteur1 ='" . $donnees['login'] . "' OR tuteur2 = '" . $donnees['login'] . "')"); // nombre de projet total o� est le tuteur
			$compteurtot = mysql_fetch_assoc($compteurtot);	
			$compteurtot = $compteurtot['count(id_proj)'];
	
			$compteurprojet = mysql_query("SELECT count(id_proj) FROM projets WHERE (tuteur1 ='" . $donnees['login'] . "' AND tuteur2 = '')"); // nombre de projet (et non demi projet)
			$compteurprojet = mysql_fetch_assoc($compteurprojet);
			$compteurprojet = $compteurprojet['count(id_proj)'];	
			
			$compteurdemiprojet = $compteurtot - $compteurprojet; // la diff�rence des projets totaux et les projets complet	
			$nbdemiprojet = $compteurdemiprojet; // nombre de demi projet
			$compteurdemiprojet =  $compteurdemiprojet * 0.5;
			$compteurtot = $compteurdemiprojet + $compteurprojet;
			
			$ret = mysql_query("SELECT count(s.id_bin) FROM binome b,soutenance s,projets p WHERE (s.id_bin = b.num AND b.id_proj = p.id_proj) AND (p.tuteur1 ='" . $donnees['login'] . "' OR p.tuteur2 ='" . $donnees['login'] . "' OR s.tuteur_comp='" . $donnees['login'] . "')"); // on r�cupere le nombre de soutenances
			$nbsout = mysql_fetch_assoc($ret);
			fputcsv($fichier, array( // on ajoute tout dans le fichier
			$donnees['prenom'].' '.$donnees['nom'],
			$compteurtot,
			$compteurprojet.' projet(s) et '.$nbdemiprojet.' demi-projet(s))',
			$nbsout['count(s.id_bin)']));
		}
		fclose($fichier); // fermeture du fichier
	}	
}
?>