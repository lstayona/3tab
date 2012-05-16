jQuery.noConflict();

jQuery(document).ready(
function() {
	jQuery("#go_button").click(
		function(e)
		{
			window.location.href = jQuery("#thing_to_do").val();
		}
	);
}
);