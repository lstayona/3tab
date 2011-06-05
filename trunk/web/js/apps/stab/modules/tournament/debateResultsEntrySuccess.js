/**
 * @author suthen
 */
jQuery.noConflict();

function getVotes()
{
    var affirmativeTeamVoters = [];
    var negativeTeamVoters = [];
    
    jQuery(".adjudicator_votes").each(
        function(index, domElement)
        {
            var adjudicatorVoteSelector = jQuery(this);
            var parts = adjudicatorVoteSelector.attr('id').split('_');
            var adjudicatorAllocationId = parts[2];
            
            if(adjudicatorVoteSelector.val() == jQuery('#affirmative_team_id').val())
            {
                affirmativeTeamVoters.push(parseInt(adjudicatorAllocationId));
            }
            else if(adjudicatorVoteSelector.val() == jQuery('#negative_team_id').val())
            {
                negativeTeamVoters.push(parseInt(adjudicatorAllocationId));
            }
            else
            {
                console.log("Adjudicator '" + adjudicatorAllocationId + "' voted for a team not in this debate.")
            }
        }
    );
    
    console.log("Affirmative voter count: " + affirmativeTeamVoters.length);
    console.log("Negative voter count: " + negativeTeamVoters.length);
    
    return {'affirmativeTeamVoters': affirmativeTeamVoters, 
    'negativeTeamVoters': negativeTeamVoters};
}

function getMajorityVotes(votes)
{
    if(votes.affirmativeTeamVoters.length > votes.negativeTeamVoters.length)
    {
        return votes.affirmativeTeamVoters;
    }
    else
    {
        return votes.negativeTeamVoters;
    }
}

function refreshSpeakerAverage(debateTeamXrefId, speakerPosition)
{
    var votes = getMajorityVotes(getVotes());
    var majorityTotal = 0.0;
    for(var i = 0; i < votes.length; i++)
    {
        console.log(jQuery("#speaker_scores_" + debateTeamXrefId + "_" + speakerPosition + "_scores_" + votes[i]).val());
        majorityTotal += parseFloat(jQuery("#speaker_scores_" + debateTeamXrefId + "_" + speakerPosition + "_scores_" + votes[i]).val());
    }
    var averageScore = majorityTotal / votes.length;
    jQuery("#speaker_scores_" + debateTeamXrefId + "_" + speakerPosition + "_average_score").text(averageScore);
    refreshTotalTeamScore(debateTeamXrefId);
}

function refreshAdjudicatorTotalForTeam(debateTeamXrefId, adjudicatorAllocationId)
{
    console.log("Refreshing adjudicatorAllocationId '" + adjudicatorAllocationId + "' for debateTeamXrefId '" + debateTeamXrefId + "'");
    
    var speakerTotal = 0;
    jQuery(".speaker_scores_" + debateTeamXrefId + '_' + adjudicatorAllocationId).each(
        function(index, domElement)
        {
            speakerTotal += parseFloat(jQuery(this).val());
        }
    );
    
    console.log(speakerTotal);
    jQuery("#total_speaker_scores_" + debateTeamXrefId + "_" + adjudicatorAllocationId).text(speakerTotal);
}

function refreshTotalTeamScore(debateTeamXrefId)
{
    var score = 0;
    jQuery(".average_speaker_score_" + debateTeamXrefId).each(
        function(index, domElement)
        {
            score += parseFloat(jQuery(this).text());
        }
    );
    
    jQuery("#total_average_speaker_scores_" + debateTeamXrefId).text(score);
}

function update()
{
    var parts = jQuery(this).attr('id').split('_');
    var debateTeamXrefId = parts[2];
    var speakerPosition = parts[3];
    var adjudicatorAllocationId = parts[5];
    console.log("debateTeamXrefId = " + debateTeamXrefId);
    console.log("speakerPosition = " + speakerPosition);
    console.log("adjudicatorAllocationId = " + adjudicatorAllocationId);
    refreshSpeakerAverage(debateTeamXrefId, speakerPosition);
    refreshAdjudicatorTotalForTeam(debateTeamXrefId, adjudicatorAllocationId);
}

jQuery(document).ready(
    function()
    {
        jQuery(".speaker_scores").blur(update);
        jQuery(".adjudicator_votes").change(
            function(event)
            {
                jQuery(".speaker_scores").each(
                    function(index, domElement)
                    {
                        update.apply(this);
                    }
                )
            }
        );
        refreshTotalTeamScore(jQuery("#affirmative_debate_team_xref_id").val());
        refreshTotalTeamScore(jQuery("#negative_debate_team_xref_id").val());
    }
);

