/**
 * @author suthen
 */
jQuery.noConflict();

jQuery(document).ready(
    function()
    {
        jQuery(".speaker_scores").blur(
            function(event)
            {
                alert("Yo!");
            }
        );
    }
);

