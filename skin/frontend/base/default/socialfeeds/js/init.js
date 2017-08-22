
//Init the popup for instagram images only
jQuery(document).ready(function(){
	jQuery(".popup").popup({
		transparentLayer : true,
		gallery : true,
		galleryTitle : "Instagram",
		imgaeDesc : true,
		galleryCounter : true,
		imageDesc : true,
		autoSize : false,
		boxHeight : 600,
		boxWidth : 500,
		shadowLength : 0,
		transition : 0,
		onOpen : function() {
			console.log("opened the box .popup");
		},
		onClose : function() {
			console.log("closed the box .popup");
		}
	}); 
}); 

//Frontend Scroller 
jQuery(document).ready(function(){ 
		jQuery(".tab_container").mCustomScrollbar({
			theme:"minimal"
		});  
}); 

//Frontend Tabs
jQuery(document).ready(function(){
	//Default Action
	jQuery(".tab_content").hide(); //Hide all content
	jQuery("ul.tabs li:first").addClass("active").show();//Activate first tab
	jQuery(".tab_content:first").show();//Show first tab content				 
	//On Click Event
	jQuery("ul.tabs li").click(function(){
		jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
		jQuery(this).addClass("active"); //Add "active" class to selected tab
		jQuery(".tab_content").hide(); //Hide all tab content
		var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		jQuery(activeTab).fadeIn(); //Fade in the active content
		return false;
	});			 
});
 