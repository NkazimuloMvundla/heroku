var menu = new Menu();

function Menu()
{
	var mainMenuDefault = false;
	this.setMainMenuDefault = setMainMenuDefault;
	this.showMainMenu = showMainMenu;
	this.showSubMainMenu = showSubMainMenu;

	function setMainMenuDefault()
	{
		mainMenuDefault = true;
		
		var mainMenuObj = document.getElementById("mainMenu");
		mainMenuObj.style.display="block";
	}

	function showMainMenu(val)
	{
		if(mainMenuDefault)
		{
			return;
		}
		var mainMenuObj = document.getElementById("mainMenu");
		if(val)
			mainMenuObj.style.display="block";
		else
			mainMenuObj.style.display="none";

	}


	function showSubMainMenu(child,act,parent1,position)
	{	
	

		var browser = navigator.appName;
		var b_version=navigator.appVersion;
		//document.getElementById(child).style.display = 'none';
		if (act == "show")
		{
			showMainMenu(true);

			var p = document.getElementById(parent1);
			var c = document.getElementById(child );
			if(p)
			{
				p.className = 'activeLeft';
			}
			if(c)
			{
				   c["at_position"]="x";
				   var top1  = (c["at_position"] == "y") ? p.offsetHeight : 0;
				   var left = (c["at_position"] == "x") ? p.offsetWidth : 0;
			}
			
			for (; p; p = p.offsetParent)
			{
			  top1 += p.offsetTop;
			  left += p.offsetLeft;
			}
			
			if(browser.match("Microsoft Internet Explorer") == "Microsoft Internet Explorer")
			{
			   var ieObjdiv = document.getElementById(child);
			   if(ieObjdiv)
			   {
				ieObjdiv.className = "";
				ieObjdiv.className = "subMenuie";  
			   }
			}
			
			
			//alert("top["+top+"]&left["+left+"]");
			if(c)
			{
				top1 =  calculateSubMenuTopPosition(c,top1,parent1);
				
				c.style.display = 'block'; 
				c.style.position   = "absolute";
				c.style.top        = top1 +'px';
				c.style.left       = left+'px';
				c.style.zIndex = '10000000';
			}
		 }
		 else if (act == "hide")
		 {
			// showMainMenu(false);

			if(document.getElementById(child))
			{
				document.getElementById(child).style.display = 'none';
			}
			var p = document.getElementById(parent1);
			if(p)
			{
				p.className = 'normalLeft';
			}
		 }
		   
	}
	
	function calculateSubMenuTopPosition(c,top1,parent1)
	{
		try
		{
			if(top1>=150)
			{
				var divHTML = $(c).html();
				var divHTMLLength = divHTML.length;
				
				if(jQuery.browser.msie)
				{
					var browserVersion = jQuery.browser.version;
					if(browserVersion)
					{
						browserVersion = parseInt(browserVersion);
						if(browserVersion<10)
						{
							divHTMLLength = divHTMLLength*2;
						}
					}
					
				}
				
				top1 = top1 - (top1/15); 
				
				if(divHTMLLength>=0)
				{
					var firstMenu = document.getElementById("cshow0");
					var firstMenu_top  = $(firstMenu).offset().top;
					var scrollTop = $(document).scrollTop();
					
					if(scrollTop<firstMenu_top)
						scrollTop = firstMenu_top;
					
					
					if(divHTMLLength<8000)
					{	
						divHTMLLength = parseInt(divHTMLLength/50);
						if(divHTMLLength>50)
						{
							top1 = top1 - divHTMLLength;
						}
					}		
					else
					{
						top1 = scrollTop;
					}					
						
					if(top1<scrollTop)
					{	
						top1 = scrollTop;
					}
				}
			}
		}
		catch(Exception)
		{
			
		}
		
		try
		{
			var solidBg = $(c).find(".solidBg");
			if(solidBg)
			{					
				var firstMenu = document.getElementById("cshow0");
				var firstMenu_top  = $(firstMenu).offset().top;
						
				var currentMenu_top  = $("#"+parent1).position().top;
				currentMenu_top=currentMenu_top-top1+firstMenu_top;
				
				var solidBgTop = (currentMenu_top)+"px";
				solidBg.css('display', 'block');
				solidBg.css('position', 'relative');
				solidBg.css('top', solidBgTop);
			}
		
		}
		catch(Exception)
		{
			
		}
		
		return top1;
	
	}
	
}