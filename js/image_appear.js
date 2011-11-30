jQuery(function ($) {
 	$(document).ready(function(){					
 		
 		$(".article").mouseover(function() {
 		    $(this).find("img").animate({
 		   
 		    opacity:1,
 		    height:"224px"
 		    },'fast');
 		  })
 		 $(".article").mouseout(function() {
 		     $(this).find("img").animate({  
	 		     opacity:0,
	 		     height:"0px"
 		     },'fast');
 		   })
  	});
 });