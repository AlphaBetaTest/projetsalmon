import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.util.StringTokenizer;


public class Convert {
	
	private FileReader fichier_in; // Flux d'entrée pour pouvoir lire le fichier
	private FileWriter fichier_out; // Flux de sortie pour pouvoir écrire sur le fichier
	
	public Convert(String niveau, String fichier) {
		
		FileReader fichier_in;
		FileWriter fichier_out;
		
		try {
			this.fichier_in = new FileReader(new File(fichier)); // on ouvre le fichier 
			this.fichier_out = new FileWriter(new File("resultat_"+niveau+".csv")); // on crée le nouveau fichier
		}
		catch (FileNotFoundException e) {
		// TODO Auto-generated catch block
		e.printStackTrace();
		} 
		catch (IOException e) {
		// TODO Auto-generated catch block
		e.printStackTrace();
		}		
	}
	
	public boolean convertir(String niveau) {			
		StringTokenizer ST; // ST pour pouvoir découper les chaines de caractères du fichier
		int i = 0; // caractère lu
		int nbr_carac=0; // nombre de caractères lus
		String test=""; // chaine finale pour un étudiant
		String login="";
		String resultat=""; // chaine contenant tous les étudiants
		
		try {
			while((i = this.fichier_in.read()) != -1) { // tant qu'il y a des caractères à lire dans le fichier
				
				if(i != '"' && i!='\r' && i!='\n') { // on récupère les valeurs qui nous intéressent (c'est à dire les données et pas les quotes ou les retours à la ligne)
					test+=(char)i; // on rajoute ça dans notre chaine finale
				}
				
				if(i == '\n') {	// si il s'agit d'une nouvelle ligne
					ST = new StringTokenizer(test, ","); // on découpe la chaine où est stocké le nom et prénom de l'étudiant
					while(ST.hasMoreTokens()) { // tant qu'il y a des données à lire
							login = ST.nextToken(); // le premier morceau découpé correspond au login
						if(nbr_carac == 0) { // on vérifie qu'on a parcouru tous les morceaux découpés par le ST
							if(niveau == "A2") { // si on traite des A2, on ne rajoute pas de groupe
								test+=","+login.toLowerCase()+",f02368945726d5fc2a14eb576f7276c0,0\r\n";
							}
							else { // si on traite des AS ou LP, dans ce cas il faut rajouter un groupe fictif pour coller à la BD à chaque étudiant
								test+=",A,"+login.toLowerCase()+",f02368945726d5fc2a14eb576f7276c0,0\r\n";
							}
						}
						nbr_carac++; // le nombre de morceaux lus par ST augmente
					}
					nbr_carac=0; // on réinitialise le nombre de morceaux lus par ST puisqu'on change de ligne
					resultat+=test;
					test="";
				}
			}
			this.fichier_out.write(resultat); // on écrit notre string dans le fichier final
			fichier_in.close();
			this.fichier_out.close();
			return true;
		}
		catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			return false;
		} 
		catch (IOException e) {
			// TODO Auto-generated catch block
			return false;
		}	
	}
	
}
