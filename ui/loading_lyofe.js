// JavaScript Document
function start_load_lyofe()
{
        $('body').append('<div class="loading">search...</div>');
            setTimeout(function(){ $('.loading').remove() }, load_timeout*1000); // remove loading after 6s
			
}
	