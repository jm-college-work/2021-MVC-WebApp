<script type="text/javascript">
//Set up some variables to be used by the timer
var c=0;  //loop counter
var timer_is_on=0;  //timer status 0=off 1=on

//Timer functions
function doTimer()  { //Start timer to start the AJAX process
if (!timer_is_on)
  {
  timer_is_on=1;
  timedCount();
  }
}

function timedCount(){ //when the timer is running this calls the updateDivContent() function every 1000mSecs
updateDivContent(); //each time this function is called the dynamic content is updated
c=c+1;  //this just keeps track of the number of times this function is called
if (timer_is_on)
	{
	setTimeout("timedCount()",1000);  //The setTimeout() method calls a function or 
                                          //evaluates an expression after a specified number
                                          //of milliseconds.
	}
}

function stopTimer() { //Stop timer
	timer_is_on=0;
}


function updateDivContent(){ //Gets the specified URL and inserts content into the specified <DIV> element(chat)
//Set up some variables
//httpRequest: handle for the XMLHttpRequest request object
var httpRequest;

// urlToFetch: URL of the dynamic content 
// Note the randNum variable being added to make the request unique
// This is required to overcome caching at the browser
var urlToFetch = '<?php echo __THIS_URI_ROOT; //from the CONFIG/config.php file?>index.php?pageID=chat&&randNum=' + new Date().getTime();

//Create the appropriate XMLHttpRequest object for the browser being used: 
//The XMLHttpRequest object can be used to request data from a web server
try{// Opera 8.0+, Firefox, Safari   	
      httpRequest  = new XMLHttpRequest();
      
	}
catch (e){//Something went wrong
        alert("Your browser does not support live updates");
        return false;
	}
 
httpRequest.open("GET",urlToFetch,true);  //Specifies the type of request

httpRequest.send(); //Sends an HTTP request to the server and receives a response.

httpRequest.onreadystatechange=function(){  // Action to be performed when the document is read
  if (httpRequest.readyState==4 && httpRequest.status==200)  //When readyState=4 and status=200 the response is ready
    {
	document.getElementById("chat").innerHTML=httpRequest.responseText+'<p><font color="red"><i>Live CHAT update counter:'+c+'</i></font>';
    }
    else{
        document.getElementById("chat").innerHTML='<p><font color="red"><i>Live CHAT NOT RESPONDING - update counter:'+c+'</i></font> <p><b>Attempting to update from: </b>'+urlToFetch;
    }
  }
}
</script>

