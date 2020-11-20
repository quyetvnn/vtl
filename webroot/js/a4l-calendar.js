var CALENDAR = {
	current_week: '',
	current_month: '',
	current_year: '',
	current_mode: '',
	current_date: '',
	init_calendar: function(){
		var tday = new Date();
		CALENDAR.current_date = tday.getDate();;
		CALENDAR.current_month = tday.getMonth()+1;
		CALENDAR.current_year = tday.getFullYear();
		CALENDAR.current_week = tday.getWeek();
		CALENDAR.current_mode = 'month';
		CALENDAR.render_date();
	},
	get_date_in_week: function(week, year){
		var weeks = [{week: week, date: []}];
		var d1 = new Date(year, 0, 1);
	    // numOfdaysPastSinceLastMonday = eval(d1.getDay()- 1);
	    numOfdaysPastSinceLastSunday = eval(d1.getDay() - 0);
	    d1.setDate(d1.getDate() - numOfdaysPastSinceLastSunday);
	    var weekNoToday = d1.getWeek();
	    var weeksInTheFuture = eval( week - weekNoToday );
	    d1.setDate( d1.getDate() + eval( 7 * weeksInTheFuture ) - 1 );
	    for(var i=0; i<7; i++){
	    	d1.setDate(d1.getDate() + 1);
	    	var date = d1.getDate();
	   		var week_day = d1.getDay();
	    	var obj = {week_day: week_day, date: date};
	    	weeks[0].date.push(obj)
	    }
	    CALENDAR.current_month = d1.getMonth()+1;
	    return weeks;
	},
	get_date_in_month: function(month, year){
		var monthIndex = month - 1; 
	   	var weeks = [];
	    var firstDate = new Date(year, monthIndex, 1);
	    var lastDate = new Date(year, monthIndex+1, 0);
	    var numDays = lastDate.getDate();
	   
	   	var start=1;
	   	var end = 7 - firstDate.getDay();
	   	while(start<=numDays){
	   		var first_date = new Date(year, monthIndex, start);
	   		var week = first_date.getWeek();
	   		var this_week = weeks.filter(function(itm){
			  return itm.week ==  week;
			});
			if(this_week.length==0){
				var obj = {week: week, date: []};
				var length = weeks.push(obj);
				this_week = weeks[length-1];
			}else{
				this_week = this_week[0];
			}
	   		for(var i=start; i<=end; i++){
	   			var tday = new Date(year, monthIndex, i);
	   			var week_day = tday.getDay();
	   			var date = tday.getDate();
				var obj = {week_day: week_day, date: date};
				this_week.date.push(obj);
	   		}
	       	start = end + 1;
	       	end = end + 7;
	       	if(end>numDays) end=numDays;    
	   	}        
	    return weeks;
	} ,
	render_next_calendar: function(){
		if(CALENDAR.current_mode=='month'){
			if(CALENDAR.current_month==12){
				CALENDAR.current_month = 1;
				current_year.current_year = current_year.current_year + 1;
			}else{
				CALENDAR.current_month = CALENDAR.current_month + 1;
			}
		}else{
			var last_date = new Date(current_year.current_year, 12, 0);
			last_week = last_date.getWeek();
			if(CALENDAR.current_week==last_week){
				CALENDAR.current_week = 1;
				current_year.current_year = current_year.current_year + 1;
			}else{
				CALENDAR.current_week = CALENDAR.current_week + 1;
			}
		}
		CALENDAR.render_date();
	},
	render_prev_calendar: function(){
		if(CALENDAR.current_mode=='month'){
			if(CALENDAR.current_month==1){
				CALENDAR.current_month = 12;
				CALENDAR.current_year = CALENDAR.current_year - 1;
			}else{
				CALENDAR.current_month = CALENDAR.current_month - 1;
			}
		}else{
			if(CALENDAR.current_week==1){
				CALENDAR.current_year = CALENDAR.current_year - 1;
				var last_date = new Date(CALENDAR.current_year, 12, 0);
				CALENDAR.current_week = last_date.getWeek();
				
			}else{
				CALENDAR.current_week = CALENDAR.current_week - 1;
			}
		}
		CALENDAR.render_date();
	},
	select_date: function(date, month, year){
		$(".col").removeClass('selected');
		$("#date-"+date).addClass('selected');
		CALENDAR.current_date = date;
	}
	switch_mode_calendar: function(mode){
		$(".mode-calendar").removeClass('active');
		$("#mode-"+mode).addClass('active');
		CALENDAR.current_mode = mode;
		CALENDAR.render_date();
	},
	render_date: function(){
		var weeks = [];
		if(CALENDAR.current_mode=='month'){
			weeks = CALENDAR.get_date_in_month(CALENDAR.current_month, CALENDAR.current_year);
		}else{
			weeks = CALENDAR.get_date_in_week(CALENDAR.current_week, CALENDAR.current_year);
		}
		var week_day = [0, 1, 2, 3, 4, 5, 6];
		var date_renderer = '';
		for(var i=0; i<weeks.length; i++){
			date_renderer += '<div class="row-data" >';
			for(var j=0; j<week_day.length; j++){
				var date = '';
				var filteredArray = weeks[i].date.filter(function(itm){
				  return itm.week_day ==  week_day[j];
				});
				if(filteredArray.length>0){
					date = filteredArray[0].date;
				}
				var cls = "col";
				if(date==''){
					cls += "disabled";
				}else if(date == tday.getDate() && CALENDAR.current_month == (tday.getMonth()+1)){
					cls += " selected current ";
				}
				date_renderer+='<div class="'+cls+'" id="date-'+date+'" onclick="select_date('+date+', '+CALENDAR.current_month+', '+CALENDAR.current_year+')">'+date+'</div>';
			}
			date_renderer+='</div>';
		}
		if(CALENDAR.current_mode=='week'){
			$("#date-render").addClass('circle-style');
		}else{
			$("#date-render").removeClass('circle-style');
		}
		var month_year_info = sprintf(lang.month_year_info, CALENDAR.current_month, CALENDAR.current_year);
		$("#month_year_info").html(month_year_info);
		$("#date-render").html(date_renderer);
	}
}