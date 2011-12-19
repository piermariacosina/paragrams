var jq = jQuery, Siteinfo;

jq(function( $ )
{
	//registerFlowFix();
	$( "#messages_to_user" ).dialog({ 
		autoOpen: false
		});
	$.backstretch(Siteinfo.site_url+"/images/bkgr_img.jpg");
});

function globalMessages( message )
{
	jq( "#messages_to_user" ).bind( "dialogopen", function(event, ui) 
	{
		jQuery(this).html(message);
	});
	jq( "#messages_to_user" ).dialog('open');
};
Number.prototype.roundNumber = function( rlength )
{
	var newnumber = Math.round(this*Math.pow(10,rlength))/Math.pow(10,rlength);
	return parseFloat(newnumber); // Output the result to the form field (change for your purposes)
};
function registerFlowFix()
{
	if( Siteinfo.slug == "indirizzo-di-casa-tua" && jq(".updated").is('div') )
	{
		window.location.href = Siteinfo.user;	
	}
};
// remove layerX and layerY webkit console errors
(function($){
    var all = $.event.props,
        len = all.length,
        res = [];
    while (len--) {
      var el = all[len];
      if (el != 'layerX' && el != 'layerY') res.push(el);
    }
    $.event.props = res;
}(jQuery));