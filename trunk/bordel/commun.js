/** Cette fonction vide un champ si sa valeur est égale a str */
function videChamp(obj,str)
{
	if(obj.value==str)
	obj.value = "";
}

/****************************
* Gestion du menu dynamique *
****************************/
function show(obj)
{
	obj.className=obj.className.replace(/normal/,'survol');
}

function hide(obj)
{
	obj.className=obj.className.replace(/survol/,'normal');
}


/****************************
* Gestion des formulaires *
****************************/
function champInt(obj)
{
	alert(obj.value.charAt(obj.value.length-1));
	if(isNaN(obj.value.charAt(obj.value.length-1)))
	{
	obj.value = obj.value.substr(0,obj.value.length-1);
	}
}

/**************************
*Pour la gestion des projets*
**************************/

		
function checknum(elem) 
{ 
	var valeur = elem.value; 
	var reg = new RegExp("[^1-5]", "gi"); 
	
	if(valeur.match(reg)) 
	{ 
		alert("Vous devez entrer un chiffre de 1 à 5");
		elem.value = "";
	}
}

function redirection(page)
{	
	var redir = 'window.location.replace("?page='+ page + '");';			
	setTimeout(redir,5000);
}

/************************
* Pour les indisponibilités *
*************************/
function active(elem) 
{ 

	if (elem.style.backgroundColor == '') 
	{ 
		//elem.disabled = false;
		elem.value = 'Indisponible';
		elem.style.backgroundColor = 'red';
		
	}
	else
	{
		//elem.disabled = true;
		elem.value= '';
		elem.style.backgroundColor = '';
	
	}
}

function desactive(elem)
{
	elem.style.backgroundColor = '';
	elem.value = '';

}

/*********************************************
Page avec gestion (soutenance,binome,utilisateur *
*********************************************/

function confirmation(page,rubr1,val1,rubr2,val2,cmb) 
{
	switch(cmb)
	{
		case 1:	
			var reponse = confirm("Etes-vous sur de vouloir supprimer l'utilisateur " + rubr1 + " ?");
		break;
	
		case 2:	
			var reponse = confirm("Etes-vous sur de vouloir vider la table ?");
		break;
		
		case 3:	
			var reponse = confirm("Etes-vous sur de vouloir supprimer ce binôme ? ");
		break;
	}
	if(reponse)
	{			
	  document.location = "?page=" + page + "&" + rubr1 + "=" + val1 + "&" + rubr2 + "=" + val2;
	}
}

