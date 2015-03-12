$(document).ready(function() {
	/* Modify ratings by clicking on a "like" or "dislike" button. */
	if (ifLiked != 0) { // if the user has rated this listing
		// Get the value of their rating.
		toggleRating(likedVal);
	} 
				
	$(".likedislike").click(function(e) {
		e.preventDefault();
		var theRating = $(this).attr("id");
		var other = 1 - theRating;
 		toggleRating(theRating);
		
		// Get the currentClass after toggling the rating button
		var currentClass = $(this).attr("class");
		
		// If the button was disabled
		if (currentClass == "btn btn-default likedislike") { 
			var theAction = "D"; // delete rating
		} else { // Something was rated
			var theAction = "A"; // add rating
		}
		changeRating(theRating, theAction);
		$.ajax({
			url: "listingfunctions.php",
			type: "POST",
			data: { f : "rate", username : user, rating : theRating, 
					listid : lid, action : theAction }
		});
			
	});

		
	/* Add input fields to allow editing of a listing. */
	$("#edit-listing").click(function() {
		$(".edit").each(function(i) {
			// Replace the listing information fields with input fields
			// for users to modify if needed.
			$(this).replaceWith("<input class='form-control' type='text'" + 
								" name='" + $(this).attr("name")  + 
								"' value='" + $(this).text() + 
								"' required />");
		});
		// Replace the "Edit" button with a "Save" button to save any
		// changes made when editing a listing.
		$(this).replaceWith("<button type='submit' " + 
							"class='btn btn-success' name='save' " +
							"id='save'>Save</button>");
	
		// Replace the delete button with a "Cancel" button to cancel editing.
		$("#delete").replaceWith("<button class='btn btn-danger'>Cancel" + 
								"</button>");
			
		// Replace the interest list with an editable tag list
		$(".tag").remove();
		$("#interests").attr("type", "text");
		$("#interests").attr("data-role", "tagsinput");
		$("#interests").tagsinput("refresh");
	});
	
	
	/* Delete a listing. */
	$("#delete").click(function() {
		var confirmBox = confirm("Are you sure you want to delete this space?");
		if (confirmBox == true) { // The user confirmed.
			$.ajax({
				url: "listingfunctions.php",
				type: "POST",
				data: { f : "delete", listid : lid }
			});
			// Redirect to the index page on deletion.
			window.location = "http://ec2-52-11-184-213.us-west-2.compute.amazonaws.com";
		}
	});
});

/* Functions for listing.php */

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