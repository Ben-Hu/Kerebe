$(document).ready(function() {
	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	});
});

/* Toggles the class of the rating button with the given id and disables the 
 * other button. */
function toggleRating(id) {
	var other = 1 - id;
	$("#" + id).toggleClass("btn-primary");
	// If the rating was removed (the button was set to default)
	if ($("#" + id).attr("class") == "btn btn-default likedislike") {
		$("#" + other).removeAttr("disabled");
	} else { // The rating was added
		$("#" + other).prop("disabled", "disabled");
	}
}

/* Changes the rating on the page. */
function changeRating(id, action) {
	if (((id == 1) && (action == "A")) || ((id == 0) && (action == "D"))) {
		document.getElementById("rating").innerHTML++;
	} else if (((id == 1) && (action == "D")) || ((id == 0) && (action == "A"))) {
		document.getElementById("rating").innerHTML--;
	}
}
