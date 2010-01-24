<?php

class eleves
{
	private $login;
	private $nom;
	private $prenom;
	private $groupe;
	private $pwd;
	private $boolbin;  //entier qui est a 0 lorsque l'éleve n'a pas encore validé son binôme (monôme), 1 sinon (utilisé comme booléen)
	private $niveau;  //type de formation de l'élève (A2,LP:PGI,AS, etc)


	/*
	* Constructeur, permet de renseigner les attributs de l'objet
	* $login : login de l'utilsateur qui vient de se connecter
	*/

	public function __construct ($login) 
	{
		$r = mysql_query("SELECT * FROM eleves WHERE login='" . $login . "'");
		$ligne = mysql_fetch_assoc($r);
		$this->nom = $ligne['nom'];
		$this->prenom = $ligne['prenom'];
		$this->login = $login;
		$this->password = $ligne['pwd'];
		$this->boolbin = $ligne['boolbin'];
		$this->groupe = $ligne['groupe'];
		$this->niveau = $ligne['niveau'];
	}
	

	/*
	* Retourne le type de l'utilisateur (éleve ou prof)
	*/

	public function type()
	{
		return "eleves";
	}
	
	
	/*
	* Retourne la valeur de boolbin
	*/

	public function get_boolbin($valeur)
	{
		return ($this->boolbin == $valeur);
	}
	
	/*
	* Retourne 0 car les éleves ne peuvent pas être administrateur (voir classe prof)
	*/

	public function get_droit()
	{
		return 0;
	}
	
	/*
	* Retourne vrai si le mot de passe est égal a la string donné en parametre
	*/
	public function compare_mdp($mdp) {
		return $this->password == md5($mdp);
	}
	
	/*
	* Modifie et enregistre dans la base de donnée le mot de passe
	*/
	public function changer_pass($pass)
	{
		$this->password = md5($pass);
		mysql_query("UPDATE " . $this->type() . " SET pwd = '" . $this->password . "' WHERE login = '" . $this->login . "'");
	}

	/* A MODIFIER : ACCESSEUR
	* Retourne le login de l'utilisateur
	*/
	public function info_login()
	{ 
		return $this->login;
	}
	
	/* A MODIFIER : ACCESSEUR
	* Retourne le niveau de l'utilisateur
	*/
	public function info_niveau()
	{
		if ($this->niveau == "LP")		
			return $this->niveau . ":" . $this->groupe;
		
		else
			return $this->niveau;
	}
	
	/*
	* Retourne vrai si l'utilisateur est dans un binome validé
	*/
	public function est_en_binome() {
		$retour = mysql_query('SELECT * FROM binome WHERE nom1 = "'.$this->login.'" OR nom2 = "'.$this->login.'"');
		$donnees = mysql_fetch_array($retour);
		
		if($donnees['valide'] == 1) 
			return true;
		else
			return false;
	}

	/*
	* Retourne un texte qui sera affiché a l'utilisateur lors de son passage dans la page choisir_binome
	* pour l'informer qu'il a été choisi par une ou des personnes pour éventuellement orienter son choix
	*/
	public function partenaire()
	{
		$data = $this->requete_deja_choisi(); // On récupere le nom des utilisateurs qui nous ont choisit
		foreach($data as $value) {
			$req=mysql_query("SELECT nom,prenom FROM eleves WHERE login='".$value."'"); // On récupere le login de chaque personne
			$r= mysql_fetch_array($req);
			
			if ($value != "") // Si on a été choisi
			{
				echo '<p class="warning">'.ucfirst(strtolower($r['prenom'])) . ' ' . ucfirst(strtolower($r['nom'])) . ' veut être votre partenaire !</p>';
			}
		}
	}

	/*
	* Retourne vrai si l'utilisateur effectue une modification de son choix de binôme, faux sinon
	*/
	public function test_modif_choix()
	{
		$sql = mysql_query("SELECT nom1 FROM binome WHERE nom1='" . $this->login . "'");
		$names = mysql_fetch_assoc($sql);
		if ($names['nom1'] == "")
			return false;
		else
			return true;
	}

	/*
	* Retourne le login de l'utilisateur a partir de son nom et son prénom
	*/
	public function renseigner_login($nom,$prenom)
	{
		$r = mysql_query("SELECT login FROM eleves WHERE nom='" . $nom . "' AND prenom='" . $prenom . "'");
		$re = mysql_fetch_assoc($r);
		return $re['login'];
	}
	
	/*
	* Suprime les doublons : si nous ou le nom qu'on a choisi existe dans la table binome et qu'il n'est pas validé
	* alors c'est un doublon
	*/
	private function del_useless ($nom2)
	{
		mysql_query("DELETE FROM binome WHERE 
			(nom1='" . $this->login  . "' OR nom2='" . $this->login . "' 
			OR nom1='" . $nom2 . "' OR 	nom2='" . $nom2 . "') 
			AND valide='0'");
	}

	/*
	* Retourne les login des personnes qui nous ont choisi
	*/
	private function requete_deja_choisi()
	{
		$liste_eleves = array();
		$req = mysql_query("SELECT * FROM binome WHERE nom2 = '" . $this->login . "'");
		while($data = mysql_fetch_array($req)) {
			array_push($liste_eleves, $data['nom1']);
		}
		return $liste_eleves;
	}
	
	/*
	* Permet d'ajouter un binôme dans la base de données
	*/
	public function ajouter_binome($nomchoisi)
	{	
		$data = $this->requete_deja_choisi(); // On vérifie que personne ne nous a choisi
		
		if ($data[0] == "") // Si on a pas été choisi
			mysql_query("INSERT INTO binome VALUES('', '" . $this->login . "','" . $nomchoisi . "' , '0','','" . $this->info_niveau() . "')");		
		else // Si on a été choisie
		{
			if (in_array($nomchoisi, $data)) // Si on a été choisi par la personne qu'on désire
			{	
				mysql_query("UPDATE binome SET valide='1' WHERE nom2 ='" . $this->login . "'");  // Binôme valide car nom1 = nomchoisi			
				mysql_query("UPDATE eleves SET boolbin='1' WHERE login ='" . $this->login . "'"); // On enleve de la liste le binôme validé
				mysql_query("UPDATE eleves SET boolbin='1' WHERE login ='" . $nomchoisi . "'");			
				$this->del_useless($data['nom2']); // On supprime tous les couples de binomes qui sont inutiles
				$this->modif_boolbin(); // On modifie boolbin car le binome existe
			}
			else // Si on a pas été choisi par la personne qu'on désire
				mysql_query("INSERT INTO binome VALUES('', '" . $this->login . "','" . $nomchoisi . "' , '0','','" . $this->info_niveau() . "')");			
		}	
	}
	
	/*
	* Ajoute un monôme dans la base et met a jour boolbin
	*/
	public function ajouter_monome()
	{		
		mysql_query("INSERT INTO binome VALUES('', '" . $this->login . "','' , '1', '0','" . $this->info_niveau() . "')") or die('Probleme lors de l\'ajout du binome'); // valide = 1 car monome donc pas de soucis de deuxieme nom
		mysql_query("UPDATE eleves SET boolbin='1' WHERE login ='" . $this->login . "'"); // on retire le monôme de la liste

		$this->del_useless($session,$nom2);	
	}
	
	/*
	* Modifie le binome choisit lors d'une modification, valide le binome sinon
	*/
	public function modifier_binome($nomchoisi)
	{
		$data = $this->requete_deja_choisi();
		
		if (!in_array($nomchoisi, $data))	// Si on modifie pour une personne qui ne nous a pas choisi										
			mysql_query("UPDATE binome SET nom2 = '" . $nomchoisi . "' , valide = '0' WHERE nom1 = '" . $this->login ."'");		
		else // on modifie pour ne personne qui nous a choisi
		{											
			mysql_query("UPDATE binome SET nom2 = '" . $this->login . "' , valide ='1' WHERE nom1 = '" . $nomchoisi ."'");						
			mysql_query("UPDATE eleves SET boolbin='1' WHERE login ='" . $this->login . "'");							
			mysql_query("UPDATE eleves SET boolbin='1' WHERE login ='" . $nomchoisi . "'");
			$this->modif_boolbin();
			$this->del_useless($nomchoisi);		
		}
	}

	/*
	* modifie le monôme choisit par l'utilisateur
	*/
	public function modifier_monome()
	{
		$nom2 = "";
		mysql_query("UPDATE binome SET nom2 ='" . $nom2  . "' , valide = '1' WHERE nom1 = '" . $this->login . "'");				
		mysql_query("UPDATE eleves SET boolbin='1' WHERE login ='" . $this->login . "'");
		$this->del_useless($nom2);
	}
	
	// pour formulation_voeux
	
	/*
	*retourne le numéro du binôme dans lequel est l'utilisateur
	*/
	public function info_numbinome()
	{
		
		$req1 = mysql_query("SELECT num FROM binome WHERE ((nom1='" . $this->login . "' OR nom2 = '" . $this->login . "') AND valide='1')");
		$retour1 = mysql_fetch_assoc($req1);
		return $retour1['num'];
	}
	
	/*
	*récupération des 5 voeux du binôme (monôme) et ajout de ceux-ci dans la base 
	*/
	function traitement_voeux ($numbinome)
	{
	
		$req = mysql_query("SELECT * FROM projets");
		while ($donnees = mysql_fetch_array($req)) // pour chaque projets : on va vérifier que les numéros des souhaits correspondent
		{
			if ($_POST['proj' . $donnees['id_proj']] != "")
			{
				$i = $_POST['proj' . $donnees['id_proj']];
			
				switch($i)
				{
					case 1:
						$wish1 = $donnees['id_proj'];
						break;
					case 2:
						$wish2 = $donnees['id_proj'];
						break;
					case 3:
						$wish3 = $donnees['id_proj'];
						break;
					case 4:
						$wish4 = $donnees['id_proj'];
						break;
					case 5:
						$wish5 = $donnees['id_proj'];
						break;
					default:
						echo 'Erreur, vous avez saisi une mauvaise valeur';
						break;
				}				
			}
		}	
		if ($wish1 != "" && $wish2 != "" && $wish3 != "" && $wish4 != "" && $wish5 != "") // s'il y a bien 5 voeux
		{
			mysql_query("INSERT INTO wish VALUES ('" . $numbinome . "', '" . $wish1 . "', '" . $wish2 . "', '" . $wish3 . "', '" . $wish4 . "', '" . $wish5. "','" . $this->info_niveau() . "')"); // ajout des voeux dans la table
			return "Vous souhaits ont &eacute;t&eacute; pris en compte.";
		}
		else
			return "Mauvaise saisie, veuillez recommencer !";
	}

	/*
	*retourne vrai si l'utilisateur a encore le droit de modifier ou créer son binôme, faux sinon
	*/
	public function datecorrecte($attribut) 
	{
		$dat = mysql_query("SELECT " . $attribut . " FROM date WHERE niveau='" . substr($this->info_niveau(), 0, 2) . "'");
		$date = mysql_fetch_array($dat);
		$date = $date[$attribut];
		
		if (time() < $date)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	*Modifie la valeur de boolbin (fait passer a 1 si 0 et inversement)
	*/	
	public function modif_boolbin() 
	{
		$this->boolbin = abs($this->boolbin-1);	
	}
}
?>	
