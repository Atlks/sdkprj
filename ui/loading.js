// JavaScript Document
//   <div id="progressbar"><div class="progress-label">Loading...</div></div>
function  start_load()
{

 var progressbar = $( "#progressbar" ),
      progressLabel = $( ".progress-label" );
	  progressLabel.text("..Loading...");
	  	 $("#progressbar").show();
 
    progressbar.progressbar({
      value: false,
      change: function() {
        progressLabel.text( progressbar.progressbar( "value" ) + "%" );
      },
      complete: function() {
		  //Complete
        progressLabel.text( "Complete!" );
      }
    });
 
    function progress() {
      var val = progressbar.progressbar( "value" ) || 0;
 
      progressbar.progressbar( "value", val + 1 );
 
      if ( val < 99 ) {
        setTimeout( progress, 180 );
      }
    }
 
    setTimeout( progress, 1000 );
	window.setTimeout(function()
	{
		 $("#progressbar").hide();
	},15000);

}
 $("#progressbar").hide();