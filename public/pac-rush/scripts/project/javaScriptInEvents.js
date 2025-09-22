function send_me(value1,value2,value3,value4,value5)
{

var today = new Date();

var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
var dateTime = date+' '+time;



   var url_st = "https://html5.b2mwap.com/score_api/get_user_score_uat.php";
   var parameters="game=Con3&user="+value1+"&score="+value2+"&id="+value3+"&date_time="+dateTime;
   
   const base_64_paramters = "data="+btoa(unescape(encodeURIComponent(parameters)));
		//alert(base_64_paramters);					
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.open("POST",url_st,true);
	
    xmlhttp.send(base_64_paramters);
						
				
	
			  

}


const scriptsInEvents = {

	async Start_Event1_Act1(runtime, localVars)
	{
		
		const params 
		= new URL(window.location.href).searchParams;
		var val1 = params.get('id'); 
		
		
		runtime.globalVars.my_id_grep=val1;
		runtime.globalVars.Timestamp=Date.now();
		runtime.globalVars.Time1=new Date().toLocaleTimeString([], { hour: '2-digit', minute: "2-digit", hour12: false });
		runtime.globalVars.Date=new Date().toISOString().slice(0, 10);
		
		
		//alert(val1);
		
		
	},

	async Global_Event68_Act1(runtime, localVars)
	{
		
		var today = new Date();
		
		var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
		var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
		runtime.globalVars.Date = date+' '+time;
		runtime.globalVars.Timestamp1 = Date.now();
		
		 
	}
};

globalThis.C3.JavaScriptInEvents = scriptsInEvents;
