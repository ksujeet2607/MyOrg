function makeTimer() {
			var birth_date = $('#dob').attr('name')+" 24:00:00 PDT";
			var endTime = new Date(birth_date);	
			
			var endTime = (Date.parse(endTime)) / 1000;

			var now = new Date();
			var now = (Date.parse(now) / 1000);

			var timeLeft = now - endTime;

			var days = Math.floor(timeLeft / 86400); 
			var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
			var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
			var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

			if (hours < "10") { hours = "0" + hours; }
			if (minutes < "10") { minutes = "0" + minutes; }
			if (seconds < "10") { seconds = "0" + seconds; }

			$("#dob_days").html(days + "<span>Days</span>");
			$("#dob_hours").html(hours + "<span>Hours</span>");
			$("#dob_minutes").html(minutes + "<span>Minutes</span>");
			$("#dob_seconds").html(seconds + "<span>Seconds</span>");		

	}
	
function makeLeftTimer() {
			$myArray = $('#dob').attr('name').split('-');
			
			var date_after_sixty = parseInt($myArray[0])+60+"-"+$myArray[1]+"-"+$myArray[2]+" 24:00:00 PDT";
			
			var endTime = new Date(date_after_sixty);
			
			var endTime = (Date.parse(endTime)) / 1000;

			var now = new Date();
			var now = (Date.parse(now) / 1000);

			var timeLeft = endTime - now;
			//var nik = new Date(timeLeft);
			//alert(nik);
			var days = Math.floor(timeLeft / 86400); 
			var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
			var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
			var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

			if (hours < "10") { hours = "0" + hours; }
			if (minutes < "10") { minutes = "0" + minutes; }
			if (seconds < "10") { seconds = "0" + seconds; }

			$("#left_days").html(days + "<span>Days</span>");
			$("#left_hours").html(hours + "<span>Hours</span>");
			$("#left_minutes").html(minutes + "<span>Minutes</span>");
			$("#left_seconds").html(seconds + "<span>Seconds</span>");		

	}	

	setInterval(function() { makeTimer(); }, 1000);
	setInterval(function() { makeLeftTimer(); }, 1000);