<?php

class eleves
{
	private $login;
	private $nom;
	private $prenom;
	private $groupe;
	private $pwd;
	private $boolbin;  //entier qui est � 0 lorsque l'�l�ve n'a pas encore valid� son bin�me (mon�me), 1 sinon (utilis� comme bool�en)
	private $niveau;  //type de formation de l'�l�ve (A2,LP,AS)


	/*
	* Constructeur, Permet de renseigner les attributs de l'objet
	* $login login de l'utilsateur qui vient de se connecter
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
	* retourne le type de l'utilisateur (�l�ve ou prof)
	*/

	public function type()
	{
	return "eleves";
	}
	
	
	/*
	*retourne la valeur de boolbin
	*/

	public function get_boolbin($valeur)
	{
	return ($this->boolbin == $valeur);
	}
	
	/*
	*retourne 0 car les �l�ves ne peuvent pas �tre administrateur (voir classe prof)
	*/

	public function get_droit()
	{
	return 0;
	}

	
	/*
	*modifie et enregistre dans la base de donn�e le mot de passe
	*/
	public function changer_pass($pass)
	{
		$this->password = md5($pass);
		mysql_query("UPDATE " . $this->type() . " SET pwd = '" . $this->password . "' WHERE login = '" . $this->login . "'");
	
	}

	/*
	*retourne le login de l'utilisateur
	*/
	public function info_login()
	{ 
		return $this->login;
	}
	
	/*
	*retourne le niveau de l'utilisateur
	*/
	public function info_niveau()
	{
		if ($this->niveau == "LP")		
			return $this->niveau . ":" . $this->groupe;
		
		else
			return $this->niveau;
	}

	// Pour choose_binome

	/*
	* Retourne un texte qui sera affich� � l'utilisateur lors de son passage dans la page choisir_binome
	* pour l'informer qu'il a �t� choisi par une personne pour �ventuellement orienter son choix
	*/
	public function partenaire()
	{
		$data = $this->requete_deja_choisi(); // On r�cupere le nom de l'utilisateur qui nous a choisit
		$req=mysql_query("SELECT nom,prenom FROM eleves WHERE login='".$data['nom1']."'");
		$r=mysql_fetch_assoc($req);
		if ($data['nom2'] != "")
		{
			echo '<p style="font-weight:bold;color:#FF0000;">'.ucfirst(strtolower($r['prenom'])) . ' ' . ucfirst(strtolower($r['nom'])) . ' veut �tre votre partenaire !</p>';
		}
	}

	/*
	*retourne vrai si l'utilisateur effectue une modification de son choix de bin�me, faux sinon
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
	*retourne le login de l'utilisateur � partir de son nom et son pr�nom
	*/
	public function renseigner_login($nom,$prenom)
	{
		$r = mysql_query("SELECT login FROM eleves WHERE nom='" . $nom . "' AND prenom='" . $prenom . "'");
		$re = mysql_fetch_assoc($r);
		return $re['login'];
	}
	
	/*
	*suprime les doublons
	*/
	private function del_useless ($nom2)
	{
		mysql_query("DELETE FROM binome WHERE 
			(nom1='" . $this->login  . "' OR nom2='" . $this->login . "' 
			OR nom1='" . $nom2 . "' OR 	nom2='" . $nom2 . "') 
			AND valide='0'");
	}

	/*
	*retourne le login de la personne qui a choisit l'utilisateur
	*/
	private function requete_deja_choisi()
	{
		$req = mysql_query("SELECT nom1,nom2 FROM binome WHERE nom2 = '" . $this->login . "'");
		$data = mysql_fetch_assoc($req);
		return $data;
	}
	
	/*
	* Permet d'ajouter un bin�me dans la base de donn�es
	*/
	public function ajouter_binome($nomchoisi)
	{	
		$data = $this->requete_deja_choisi(); // On v�rifie que personne ne nous a choisi
		
		if ($data['nom2'] == "") // Si on a pas �t� choisi
			mysql_query("INSERT INTO binome VALUES('', '" . $this->login . "','" . $nomchoisi . "' , '0','','" . $this->info_niveau() . "')");		
		else // Si on a �t� choisie
		{
			if ($nomchoisi ==  $data['nom1']) // Si on a �t� choisi par la personne qu'on d�sire
			{							
				mysql_query("UPDATE binome SET valide='1' WHERE nom2 ='" . $this->login . "'");  // Bin�me valide car nom1 = nomchoisi			
				mysql_query("UPDATE eleves SET boolbin='1' WHERE login ='" . $this->login . "'"); // on enl�ve de la liste le bin�me valid�
				mysql_query("UPDATE eleves SET boolbin='1' WHERE login ='" . $nomchoisi . "'");			
				$this->del_useless($nom2);
				$this->modif_boolbin(); // On modifie boolbin car le binome existe
			}
			else // Si on a pas �t� choisi par la personne qu'on d�sire
				mysql_query("INSERT INTO binome VALUES('', '" . $this->login . "','" . $nom2 . "' , '0','','" . $this->info_niveau() . "')");			
		}	
	}
	
	/*
	*ajoute un mon�me dans la base et  met a jour boolbin
	*/
	public function ajouter_monome()
	{		
		mysql_query("INSERT INTO binome VALUES('', '" . $this->login . "','' , '1','" . $this->info_niveau() . "')"); // valide = 1 car monome donc pas de soucis de deuxi�me nom
		mysql_query("UPDATE eleves SET boolbin='1' WHERE login ='" . $this->login . "'"); // on retire le mon�me de la liste

		$this->del_useless($session,$nom2);	
	}
	
	/*
	*modifie le binome choisit lors d'une modification, valide le binome sinon
	*/
	public function modifier_binome($nomchoisi)
	{
		$this->requete_deja_choisi();
		
		if ($data['nom2'] == "")											
			mysql_query("UPDATE binome SET nom2 = '" . $nomchoisi . "' , valide = '0' WHERE nom1 = '" . $this->login ."'");		
		else
		{											
			mysql_query("UPDATE binome SET nom2 = '" . $this->login . "' , valide ='1' WHERE nom1 = '" . $nomchoisi ."'");						
			mysql_query("UPDATE eleves SET boolbin='1' WHERE login ='" . $this->login . "'");							
			mysql_query("UPDATE eleves SET boolbin='1' WHERE login ='" . $nomchoisi . "'");
			$this->del_useless($nomchoisi);
		
		}
	}

	/*
	*modifie le mon�me choisit par l'utilisateur
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
	*retourne le num�ro du bin�me
	*/
	public function info_numbinome()
	{
		
		$req1 = mysql_query("SELECT num FROM binome WHERE ((nom1='" . $this->login . "' OR nom2 = '" . $this->login . "') AND valide='1')");
		$retour1 = mysql_fetch_assoc($req1);	
		return $retour1['num'];
	}
	
	/*
	*r�cup�ration des 5 voeux du bin�me (mon�me) et ajoutde ceux-ci dans la base 
	*/
	function traitement_voeux ($numbinome)
	{
	
		$req = mysql_query("SELECT * FROM projets");
		while ( $donnees = mysql_fetch_array($req)) // affichage des projets
		{		
			if ($_POST['proj' . $donnees['id_proj']] != "")
			{
				$i = $_POST['proj' . $donnees['id_proj']];
			
				switch($i)
				{
					case 1:
						$wish1 = $_POST['proj' . $donnees['id_proj']];
						break;
					case 2:
						$wish2 = $_POST['proj' . $donnees['id_proj']];
						break;
					case 3:
						$wish3 = $_POST['proj' . $donnees['id_proj']];
						break;
					case 4:
						$wish4 = $_POST['proj' . $donnees['id_proj']];
						break;
					case 5:
						$wish5 = $_POST['proj' . $donnees['id_proj']];
						break;
					default:
						echo 'Erreur, vous avez saisi une mauvaise valeur';
						break;
				}				
			}
		}	
		if ($wish1 != "" && $wish2 != "" && $wish3 != "" && $wish4 != "" && $wish5 != "")
		{
			mysql_query("INSERT INTO wish VALUES ('" . $numbinome . "', '" . $wish1 . "', '" . $wish2 . "', '" . $wish3 . "', '" . $wish4 . "', '" . $wish5. "','" . $objet->info_niveau() . "')");
			return "Vous souhaits ont &eacute;t&eacute; pris en compte.";
		}
		else
			return "Mauvaise saisi, veuillez recommencer !";
	}

	/*
	*retourne vrai si l'utilisateur � encore le droit de modifier ou cr�er son bin�me, faux sinon
	*/
	public function datecorrecte($attribut) 
	{
		$dat = mysql_query("SELECT " . $attribut . " FROM date WHERE niveau='" . $this->info_niveau() . "'");
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