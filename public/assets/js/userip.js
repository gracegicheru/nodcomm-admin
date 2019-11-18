		var userip = null;
		$.getJSON("https://api.ipify.org?format=jsonp&callback=?",
		  function(json) {
			userip = json.ip;
		  }
		);