function goToPage(){
      document.location.href="search_result.php?name="+$("#inputIcon").val()+"&country=Страна&genre=Жанр&from=не важно&to=не важно";
}
$(document).on('mousemove',function(e){
    if(e.pageY>800) $("#go_to_top").fadeIn("slow");
    else  $("#go_to_top").fadeOut("slow");
});
function add(a){
	var b="<?php echo $g;?>";
	if(a=="#add_genre"){
		$(a).after(b);
	}
}       