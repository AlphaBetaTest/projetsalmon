<?php
$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit(1))
{
	echo '<h1>Enregistrer les dates</h1>';
	
	if (isset($_POST['m1']))
	{
		$verif = true;
		for($i = 0; $i<=10; $i++) {
			if(empty($_POST['j'.$i]))
				$verif = false;
		}
		
		for($j = 0; $j<=10; $j++) {
			if(empty($_POST['h'.$j]))
				$verif = false;
		}
		
		for($k = 0; $k<=10; $k++) {
			if(empty($_POST['mm'.$k]))
				$verif = false;
		}
		
		if($verif) {
			$m = array();
			$mm = array();
			$j = array();
			$a = array();
			$h = array();
			for ($i = 0 ; $i <= 10 ; $i++) // Pour chaque mois de l'année scolaire
			{
				$m[] = $_POST['m' . $i];
				$h[] = $_POST['h' . $i];
				$mm[] = $_POST['mm' . $i];
				$j[] = $_POST['j' . $i];
				$a[] = $_POST['a' . $i];	
			}
			
			$d = $objet->recup_dates_planning($_GET['niveau']);
			
			if(empty($d[0])) {
				$objet->enregistrer_date($m, $h, $mm, $j, $a, $_POST['a1'], $_GET['niveau']);
			}
			else {
				$objet->modifier_date($m, $h, $mm, $j, $a, $_POST['a1'], $_GET['niveau']);
			}
		}
		else { 
			echo'<p class="warning">Vous devez remplir tous les champs !</p>';		
		}		
	}
	
	$dates_enr = $objet->recup_dates_planning($_GET['niveau']);
	
	$mois = array("janvier","février","mars","avril","mai","juin","juillet","aout","septembre","octobre","novembre","décembre");
	$infos =array("Constitution des binômes","Proposition des projets par les enseignants","Début réunion de coordination des projets","Diffusion des sujets proposés","Choix <b>ordonnée</b> des sujets par les étudiants (<b>5 choix</b>)","Publication de l'attribution des sujets","Remise du rapport préliminaire (au tuteur)","Remise du rapport (au secrétariat)","Début soutenances de projets","Fin soutenances de projets", "Soutenance éleves parant a l'étranger <br />(ignorer si AS ou LP)");
	$annee = date("Y",time());
	
	echo '<table>	
	<form method="post" action="?page=enregistrer_date&niveau='.$_GET['niveau'].'">
	<tr>
		<td>Niveau</td>
		<td><select name="niveau" disabled="true">
				<option>'.$_GET['niveau'].'</option>
	        </select>
		</td>
	</tr>';
	
	for( $i = 0 ; $i <= 10 ; $i++)
	{	
		echo '
		<tr> 
			<td>' . $infos[$i] . '&nbsp;</td>
			<td> <input type="text" size="2" maxlength="2" name="j' . $i . '" value="'.$dates_enr[$i][0].'" />&nbsp; 
				<select name="m' . $i . '">';
			
			for ($j = 0 ; $j < 12 ; $j++)
			{
				if($dates_enr[$i][1] == $j+1) 
					$selec = 'selected="selected"';
				else
					$selec = "";
				echo '<option '.$selec.'>' . ucfirst($mois[$j]) . '</option>';
			}
		
		$a = $dates_enr[$i][2];
		$selec1="";
		$selec2="";
		if($a == $annee) $selec1 = 'selected="selected"'; else $selec2='selected="selected"';
		
		echo '</select>&nbsp; 
			<select name="a' . $i . '">
				<option '.$selec1.'>' . $annee . '</option>
				<option '.$selec2.'>' . ($annee + 1) . '</option>
			</select>&nbsp à &nbsp;
				<input type="text" size="2" maxlength="2" name="h' . $i . '" value="'.$dates_enr[$i][3].'" />&nbsp; h&nbsp; 
				<input type="text" size="2" maxlength="2" name="mm' . $i . '" value="'.$dates_enr[$i][4].'" /> &nbsp; &nbsp; &nbsp;
			</td>		
		</tr>';
	}
	
	echo '<tr>
			<td>&nbsp;</td>
			<td>
				<input type="submit" value="Envoyer"/>
			</td>
			</form>
		</table>';
	
	
	
}
else
{
echo 'Vous n\'avez pas acccs r cette page	
<script type="text/javascript">redirection("login");</script>';
}
?>