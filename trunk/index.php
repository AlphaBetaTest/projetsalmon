<?php	
		include('entete.php'); 
		include('head.html');
			
		require_once('class/prof.php');
		require_once('class/eleves.php');
		include_once('cfg.php');

		
		include('hautpage.html');
		include('menu.php');
	
		

			
		include($page);		
			
		include('footer.html'); 
?>