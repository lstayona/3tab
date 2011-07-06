/**
 * @author suthen
 */
jQuery.noConflict();

jQuery(document).ready(
function()
{
    jQuery.each(jQuery(".adjudicator_selector"), function()
    {
        var parts = jQuery(this).attr('id').split('_');
        var suffix = parts[1] + '_' + parts[2];
        var selected_adjudicator_value = jQuery(this).val();
        var selected_adjudicator_text = jQuery(this).find(':selected').text(); 
        if (selected_adjudicator_value != '') {
            jQuery('#previous_adjudicator_value_' + suffix).val(selected_adjudicator_value);
            jQuery('#previous_adjudicator_text_' + suffix).val(selected_adjudicator_text);
            jQuery.each(jQuery(".adjudicator_selector").not(this), function() { 
                jQuery(this).find("option[value='"+selected_adjudicator_value+"']").remove();
            });
        }
    });

    jQuery('.adjudicator_selector').change(function()
    {
        var parts = jQuery(this).attr('id').split('_');
        var suffix = parts[1] + '_' + parts[2];
        var selected_adjudicator_value = jQuery(this).val();
        var selected_adjudicator_text = jQuery(this).find(':selected').text(); 
        var previous_selected_adjudicator_value = jQuery('#previous_adjudicator_value_' + suffix).val();
        var previous_selected_adjudicator_text = jQuery('#previous_adjudicator_text_' + suffix).val();

        jQuery('#previous_adjudicator_value_' + suffix).val(selected_adjudicator_value);
        jQuery('#previous_adjudicator_text_' + suffix).val(selected_adjudicator_text);

        if (selected_adjudicator_value != '') 
        {
            jQuery.each(jQuery(".adjudicator_selector").not(this), function() { 
                jQuery(this).find("option[value='"+selected_adjudicator_value+"']").remove();
            });
        }

        if (previous_selected_adjudicator_value != '')
        {            
            jQuery.each(jQuery(".adjudicator_selector").not(this), function() { 
                jQuery(this).append('<option value="'+previous_selected_adjudicator_value+'">'+previous_selected_adjudicator_text+'</option>');
            });
        }
    });
}
);

