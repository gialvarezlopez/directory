(function ( $ ) {
 
    $.fn.weekly = function( options ) {
 
        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
            //color: "#556b2f",
            //backgroundColor: ""
            start_scroll : "12:00 AM",
            hour_format: 12,
            start_from: "12:00 AM",
        }, options );
 		
 		var element = this;
 		var days = ["Mon", "Tus","Wed","Thr","Fri","Sat","Sun"];

 		element.html("<div id='weekly_container'><div id='weekly_days'></div><div id='weekly_scroll'><div id='weekly_schedule'></div></div></div>");
 		
 		//=======================
 		//Create all days
 		//=======================
 		for(i=0; i < days.length; i++ )
 		{
 			$("body").find("#weekly_days").append("<span class='weekly_day_label' data-weeklyday='"+days[i]+"'>"+days[i]+"</span>");
 		}

 		$("#weekly_container").prepend("<i class='glyphicon glyphicon-calendar' id='weekly-icon'></i>");
 		var wIconWeek = $("body").find("#weekly-icon").outerWidth();
 		var hIconWeek = $("body").find("#weekly-icon").outerHeight();
 		var cDays = $("body").find("#weekly_days").outerWidth();
 		var hHour = $("body").find(".weekly_head_hour").outerHeight();

 		$("#weekly-icon").css({
 			"left": ( ( cDays/2 ) - (wIconWeek/2) )+"px",
 			"top": ( (hHour/2) + (hIconWeek)/2 )+"px",
			"position":"absolute",
 		});

 		var init;
 		switch( ($.trim(settings.start_from)).toUpperCase() )
 		{
 			case "12:0 AM":
 			case "00:00":
 				init = 0;
 				break;
 			case "01:00 AM":
 			case "01:00":
 				init = 1;
 				break;
 			case "02:00 AM":
 			case "02:00":
 				init = 2;
 				break;
 			case "03:00 AM":
 			case "03:00":
 				init = 3;
 				break;
 			case "04:00 AM":
 			case "04:00":
 				init = 4;
 				break;
 			case "05:00 AM":
 			case "05:00":
 				init = 5;
 				break;
 			case "06:00 AM":
 			case "06:00":
 				init = 6;
 				break;
 			case "07:00 AM":
 			case "07:00":
 				init = 7;
 				break;
 			case "08:00 AM":
 			case "08:00":
 				init = 8;
 				break;
 			case "09:00 AM":
 			case "09:00":
 				init = 9;
 				break;
 			case "10:00 AM":
 			case "10:00":
 				init = 10;
 				break;
 			case "11:00 AM":
 			case "11:00":
 				init = 11;
 				break;
 			case "12:00 PM":
 			case "12:00":
 				init = 12;
 				break;
 			case "01:00 PM":
 			case "13:00":
 				init = 13;
 				break;
 			case "02:00 PM":
 			case "14:00":
 				init = 14;
 				break;
 			case "03:00 PM":
 			case "15:00":
 				init = 15;
 				break;
 			case "04:00 PM":
 			case "16:00":
 				init = 16;
 				break;
 			case "05:00 PM":
 			case "17:00":
 				init = 17;
 				break;
 			case "06:00 PM":
 			case "18:00":
 				init = 18;
 				break;
 			case "07:00 PM":
 			case "19:00":
 				init = 19;
 				break;
 			case "08:00 PM":
 			case "20:00":
 				init = 20;
 				break;
 			case "09:00 PM":
 			case "21:00":
 				init = 21;
 				break;
 			case "10:00 PM":
 			case "22:00":
 				init = 22;
 				break;
 			case "11:00 PM":
 			case "23:00":
 				init = 23;
 				break;
 			default:
 				init = 0;																								
 		}

 		if( settings.hour_format == 12 )
 		{
 			var schedule = [
		 			"12:00 AM",
		 			"01:00 AM",
		 			"02:00 AM",
		 			"03:00 AM",
		 			"04:00 AM",
		 			"05:00 AM",
		 			"06:00 AM",
		 			"07:00 AM",
		 			"08:00 AM",
		 			"09:00 AM",
		 			"10:00 AM",
		 			"11:00 AM",
		 			"12:00 PM",
		 			"01:00 PM",
		 			"02:00 PM",
		 			"03:00 PM",
		 			"04:00 PM",
		 			"05:00 PM",
		 			"06:00 PM",
		 			"07:00 PM",
		 			"08:00 PM",
		 			"09:00 PM",
		 			"10:00 PM",
		 			"11:00 PM",
		 		];
 		}
 		else
 		{
 			var schedule = [
	 			"00:00",
	 			"01:00",
	 			"02:00",
	 			"03:00",
	 			"04:00",
	 			"05:00",
	 			"06:00",
	 			"07:00",
	 			"08:00",
	 			"09:00",
	 			"10:00",
	 			"11:00",
	 			"12:00",
	 			"13:00",
	 			"14:00",
	 			"15:00",
	 			"16:00",
	 			"17:00",
	 			"18:00",
	 			"19:00",
	 			"20:00",
	 			"21:00",
	 			"22:00",
	 			"23:00",
	 		];
 		}
 		
 		
 		//========================
	 	//Create the schedule
	 	//========================
	 	for(s=init; s < schedule.length; s++ )
	 	{
	 		var hour = schedule[s];
	 		$("body").find("#weekly_schedule").append("<div class='weekly_column_hour' data-weeklyhour='"+hour+"'></div>");

	 		var title = hour.replace(" ", "<br>");
	 		$("body").find("[data-weeklyhour='"+hour+"']").append("<span class='weekly_head_hour'>"+title+"</span>");
	 		for(i=0;i < days.length; i++)
	 		{
	 			//console.log("xxz");
	 			$("body").find("[data-weeklyhour='"+hour+"']").append("<span class='weekly_day_hour_label "+days[i]+"'>&nbsp;</span>");
	 		}

	 	}
 		
 		execute();
 		$(window).resize(function(){
 			execute();
 		});	

 		$("body").on("click",".weekly_day_hour_label",function(){
 			if( $(this).hasClass("active") )
 			{
 				$(this).removeClass("active");
 			}
 			else
 			{
 				$(this).addClass("active");	
 			}
 		});

 		$("body").on("click", ".weekly_head_hour", function(){
 			//console.log("antes");
 			//$(this).addClass("checkedAll");
 			if( $(this).hasClass("checkedAll") )
 			{
 				$(this).removeClass("checkedAll");
 				$(this).closest(".weekly_column_hour").find(".weekly_day_hour_label").removeClass("active");
 			}
 			else
 			{
 				$(this).addClass("checkedAll");
 				$(this).closest(".weekly_column_hour").find(".weekly_day_hour_label").addClass("active");
 			}
 			
 			//console.log("despues");
 		});
 		/*
 		//this.hide();
        // Greenify the collection based on the settings variable.
        return this.css({
            color: settings.color,
            backgroundColor: settings.backgroundColor
        });
 		*/
 		
 		function execute()
 		{
 			var widthDiv = 0;
	 		$(".weekly_column_hour").each(function(){
	 			var w = $(this).outerWidth();
	 			widthDiv = (widthDiv + w);
	 		});

	 		var wDay = $("#weekly_days").outerWidth();
	 		var hDay = $("#weekly_days").outerHeight();
	 		//widthDiv = (widthDiv - wDay);
	 		//console.log(wDay);

	 		var hHeader = $(".weekly_head_hour").outerHeight();

	 		$("#weekly_schedule").css({
	 				"width":widthDiv+"px",
	 				"left":wDay+"px",
	 				//"background-color":"red"
	 		});


	 		var head = $(".weekly_head_hour").height();
	 		$("#weekly_days").css("top",head+"px");



	 		var scroll =  element.parent().width(); //$(window).width();
	 		$("#weekly_scroll").css({
	 			"left":wDay+"px",
	 			"width":(scroll  - wDay)+"px",
	 			"height":(hDay+hHeader+18)+"px",
	 		});

	 		$("#weekly_container").css({"height":(hDay+hHeader+18)+"px"});
	 		//$( "#weekly_scroll" ).scrollLeft( 300 );

	 		var scroll_hour = settings.start_scroll;
	 		if( $("body").find("[data-weeklyhour='" + scroll_hour + "']") )
	 		{
	 			var pos = $("body").find("[data-weeklyhour='" + scroll_hour + "']").position().left;
	 			//pos = 10
	 			$( "#weekly_scroll" ).scrollLeft( (pos/2) );
	 			
	 		}

	 		console.log(pos/2);
	 		//$("").data("")
 		}
    };
 
}( jQuery ));