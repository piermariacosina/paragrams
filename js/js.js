var jq = jQuery, Siteinfo;

jq(function( $ )
{
	jq( "#messages_to_user" ).dialog({ 
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