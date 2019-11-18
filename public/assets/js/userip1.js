		var z = null;
		$.getJSON("https://api.ipify.org?format=jsonp&callback=?",
		  function(json) {
			z = json.ip;
		  }
		);