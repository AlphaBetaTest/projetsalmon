import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.FlowLayout;
import java.awt.Font;
import java.awt.GridBagConstraints;
import java.awt.GridBagLayout;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextArea;
import javax.swing.JTextField;
import javax.swing.UIManager;
import javax.swing.UnsupportedLookAndFeelException;

public class Fenetre extends JFrame implements ActionListener {	
	
	private JPanel container = new JPanel();
	private JTextArea texte = new JTextArea(2, 32);
	private JLabel label = new JLabel("Niveau de la promotion :");
	private JLabel nom = new JLabel("Nom du fichier (avec extension) :");
	private JComboBox combo = new JComboBox();
	private JTextField champ = new JTextField();
	private JButton bouton = new JButton("Convertir");
	private JLabel erreur = new JLabel();
	
	public Fenetre() {
		this.setTitle("Convertisseur des fichiers promotion");
		this.setSize(400, 250);
		this.setLocationRelativeTo(null);
		this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		this.setResizable(false);
		
		JPanel txt = new JPanel();
		JPanel liste = new JPanel();
		JPanel zone_champ = new JPanel();
		JPanel zone_bouton = new JPanel();
		JPanel zone_erreur = new JPanel();
        
        Font police = new Font("Arial", Font.PLAIN, 12); 
        
        combo.addItem("A2");
        combo.addItem("AS");
        combo.addItem("LP_PGI");
        combo.addItem("LP_ACPI");
        combo.addItem("LP_API");

        texte.setLineWrap(true);
        texte.setWrapStyleWord(true);
        texte.setEditable(false);
        texte.setBackground(Color.getColor("f0f0f0"));
        
        champ.setColumns(20);
        
        txt.setFont(police);
        txt.add(texte);   
        texte.setText("Veuillez renseigner les informations ci-dessous pour lancer la conversion. Pensez à placer les fichiers à convertir dans le même dossier que le convertisseur.");
        texte.setFont(new Font("Arial", Font.BOLD, 12));
        
        liste.add(label);
        liste.add(combo);
        
        zone_champ.add(nom);
        zone_champ.add(champ);
        
        zone_bouton.add(bouton);
        
        zone_erreur.add(erreur);
        
        container.setFont(police);
        container.setBackground(Color.getColor("f0f0f0"));
        container.add(txt);
        container.add(liste);
        container.add(zone_champ);
        container.add(zone_bouton);
        container.add(zone_erreur);
        
        bouton.addActionListener(this);
        
        this.setContentPane(container);
        this.setVisible(true);
	}
	
	public void actionPerformed(ActionEvent arg0) {
		Convert mon_convertisseur = new Convert((String)combo.getSelectedItem(), champ.getText());
		
		if(mon_convertisseur.convertir((String)combo.getSelectedItem())) {
			this.erreur.setText("Fichier resultat_"+combo.getSelectedItem()+".csv créé !");
		}
		else {
			this.erreur.setText("Problème lors de la conversion, fichier introuvable, veuillez recommencer.");
		}		
	}
	
}
