
$(document).on('mousemove',function(e){
    if(e.pageY>800) $("#go_to_top").fadeIn("slow");
    else  $("#go_to_top").fadeOut("slow");
});
// $(document).on('mousemove',function(e){
//     if(e.pageY<800) $("#go_to_bottom").fadeIn("slow");
//     else  $("#go_to_bottom").fadeOut("slow");
// });
function add(a){
	var b="<?php echo $g;?>";
	if(a=="#add_genre"){
		$(a).after(b);
	}
} 