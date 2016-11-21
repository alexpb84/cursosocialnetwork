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