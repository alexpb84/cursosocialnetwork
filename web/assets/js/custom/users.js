$(document).ready(function(){

	var ias = jQuery.ias({
		container: '.box-users',
		item: '.user-item',
		pagination: '.pagination',
		next: '.pagination .next_link',
		triggerPageThreshold: 5
	});

	ias.extension(new IASTriggerExtension({
		text: 'Ver más personas',
		offset: 3
	}));

	ias.extension(new IASSpinnerExtension({
		src: URL+'/../assets/images/ajax-loader.gif'
	}));

	ias.extension(new IASNoneLeftExtension({
		text: 'No hay más personas'
	}));

	ias.on('ready', function(event){
		followButtons();
		unfollowButtons()
	});

	ias.on('rendered', function(event){
		followButtons();
		unfollowButtons()
	});
});

function followButtons(){
	$(".btn-follow").unbind("click").click(function(){

		$(this).addClass("hidden");
		$(this).parent().find(".btn-unfollow").removeClass("hidden");

		$.ajax({
			url: URL+'/follow',
			data: {followed: $(this).attr("data-followed")},
			type: 'POST',
			success: function(response){
				console.log(response);
			}
		});
	});
}

function unfollowButtons(){
	$(".btn-unfollow").unbind("click").click(function(){

		$(this).addClass("hidden");
		$(this).parent().find(".btn-follow").removeClass("hidden");

		$.ajax({
			url: URL+'/unfollow',
			data: {followed: $(this).attr("data-followed")},
			type: 'POST',
			success: function(response){
				console.log(response);
			}
		});
	});
}