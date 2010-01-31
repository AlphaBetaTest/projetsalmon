import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.util.StringTokenizer;


public class Convert {
	
	private FileReader fichier_in; // Flux d'entr�e pour pouvoir lire le fichier
	private FileWriter fichier_out; // Flux de sortie pour pouvoir �crire sur le fichier
	
	public Convert(String niveau, String fichier) {
		
		FileReader fichier_in;
		FileWriter fichier_out;
		
		try {
			this.fichier_in = new FileReader(new File(fichier)); // on ouvre le fichier 
			this.fichier_out = new FileWriter(new File("resultat_"+niveau+".csv")); // on cr�e le nouveau fichier
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
		StringTokenizer ST; // ST pour pouvoir d�couper les chaines de caract�res du fichier
		int i = 0; // caract�re lu
		int nbr_carac=0; // nombre de caract�res lus
		String test=""; // chaine finale pour un �tudiant
		String login="";
		String resultat=""; // chaine contenant tous les �tudiants
		
		try {
			while((i = this.fichier_in.read()) != -1) { // tant qu'il y a des caract�res � lire dans le fichier
				
				if(i != '"' && i!='\r' && i!='\n') { // on r�cup�re les valeurs qui nous int�ressent (c'est � dire les donn�es et pas les quotes ou les retours � la ligne)
					test+=(char)i; // on rajoute �a dans notre chaine finale
				}
				
				if(i == '\n') {	// si il s'agit d'une nouvelle ligne
					ST = new StringTokenizer(test, ","); // on d�coupe la chaine o� est stock� le nom et pr�nom de l'�tudiant
					while(ST.hasMoreTokens()) { // tant qu'il y a des donn�es � lire
							login = ST.nextToken(); // le premier morceau d�coup� correspond au login
						if(nbr_carac == 0) { // on v�rifie qu'on a parcouru tous les morceaux d�coup�s par le ST
							if(niveau == "A2") { // si on traite des A2, on ne rajoute pas de groupe
								test+=","+login.toLowerCase()+",f02368945726d5fc2a14eb576f7276c0,0\r\n";
							}
							else { // si on traite des AS ou LP, dans ce cas il faut rajouter un groupe fictif pour coller � la BD � chaque �tudiant
								test+=",A,"+login.toLowerCase()+",f02368945726d5fc2a14eb576f7276c0,0\r\n";
							}
						}
						nbr_carac++; // le nombre de morceaux lus par ST augmente
					}
					nbr_carac=0; // on r�initialise le nombre de morceaux lus par ST puisqu'on change de ligne
					resultat+=test;
					test="";
				}
			}
			this.fichier_out.write(resultat); // on �crit notre string dans le fichier final
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
