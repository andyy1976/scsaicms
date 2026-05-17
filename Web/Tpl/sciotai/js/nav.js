function displaySubMenu(li) { 
	var subMenu = li.getElementsByTagName("ul")[0];
	if(subMenu){
	subMenu.style.display = "block";
	}
} 
function hideSubMenu(li) { 
	var subMenu = li.getElementsByTagName("ul")[0];
	if(subMenu) {
		subMenu.style.display = "none";
	}
} 