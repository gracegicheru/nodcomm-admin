$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var visitor_history = new Vue({
	el: '#chat-box-info',

	data: {
		navigation: [],
		history: null
	},

	created: function(){
		//
	},

	computed: {
		nav_present: function(){
			return this.navigation.length > 0;
		}
	},

	methods: {
		fetchNavigation: function(){
			var _class = $(".chat-content-container").attr("class");
			var _class2 = _class.split(' ');
			var _class3 = _class2[1].split('-');

			$.ajax({
				type: "post",
				url:  URL+"/visitor/navigation",
				data: {identifier: _class3[3]},
				dataType: "json",
				beforeSend: function(){
					$(".nav-present").addClass("hide");
					$(".no-nav").removeClass("hide").html('<div class="text-center" style="padding:20px;"><i class="fa fa-spin fa-pulse fa-fw"></i></div>');
				},
				success: function(res){
					if(res.status == "success"){
						if(res.data.length > 0){
							this.navigation = res.data;
							$(".nav-present").removeClass("hide");
							$(".no-nav").addClass("hide");
						}else{
							$(".no-nav").html('The visitor has no navigation records yet');
						}
						
						console.log(res.data);
					}
				}
			});
		},
		fetchInfo: function(){
			//
		},
		fetchHistory: function(){
			//
		}
	}
});