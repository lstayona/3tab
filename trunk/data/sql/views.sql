DROP view team_margins;
DROP VIEW debater_results;
DROP VIEW team_results;


CREATE VIEW team_results AS
SELECT
  debates_teams_xrefs.id AS debate_team_xref_id,
  team_votes.votes AS team_vote_count,
  opponent_debates_teams_xrefs.id AS opponent_debate_team_xref_id,
  opponent_team_votes.votes AS opponent_team_vote_count,
  CASE WHEN team_votes.votes > opponent_team_votes.votes THEN 1 ELSE 0 END AS majority_team_score,
  CASE WHEN team_votes.votes > opponent_team_votes.votes THEN debates_teams_xrefs.id ELSE opponent_debates_teams_xrefs.id END AS winning_debate_team_xref_id
FROM teams
JOIN debates_teams_xrefs ON debates_teams_xrefs.team_id = teams.id
JOIN debates ON debates.id = debates_teams_xrefs.debate_id
JOIN rounds ON rounds.id = debates.round_id
JOIN debates_teams_xrefs AS opponent_debates_teams_xrefs ON opponent_debates_teams_xrefs.debate_id = debates.id AND opponent_debates_teams_xrefs.team_id <> debates_teams_xrefs.team_id
JOIN teams AS opponent_teams ON opponent_teams.id = opponent_debates_teams_xrefs.team_id
JOIN (
SELECT 
  debates_teams_xrefs.id AS debate_team_xref_id,
  SUM(team_score_sheets.score) AS votes
FROM teams
JOIN debates_teams_xrefs ON debates_teams_xrefs.team_id = teams.id
JOIN team_score_sheets ON team_score_sheets.debate_team_xref_id = debates_teams_xrefs.id
GROUP BY debates_teams_xrefs.id) AS team_votes ON team_votes.debate_team_xref_id = debates_teams_xrefs.id
JOIN (
SELECT 
  debates_teams_xrefs.id AS debate_team_xref_id,
  SUM(team_score_sheets.score) AS votes
FROM teams
JOIN debates_teams_xrefs ON debates_teams_xrefs.team_id = teams.id
JOIN team_score_sheets ON team_score_sheets.debate_team_xref_id = debates_teams_xrefs.id
GROUP BY debates_teams_xrefs.id) AS opponent_team_votes ON opponent_team_votes.debate_team_xref_id = opponent_debates_teams_xrefs.id;


CREATE VIEW debater_results AS
SELECT
  debates_teams_xrefs.id AS debate_team_xref_id,
  debaters.id AS debater_id,
  speaker_score_sheets.speaking_position,
  AVG(speaker_score_sheets.score) AS averaged_score
FROM team_results
JOIN team_score_sheets ON team_results.winning_debate_team_xref_id = team_score_sheets.debate_team_xref_id AND team_score_sheets.score = team_results.majority_team_score
JOIN adjudicator_allocations ON adjudicator_allocations.id = team_score_sheets.adjudicator_allocation_id
JOIN debates ON debates.id = adjudicator_allocations.debate_id
JOIN debates_teams_xrefs ON debates_teams_xrefs.debate_id = debates.id
JOIN teams ON teams.id = debates_teams_xrefs.team_id
JOIN speaker_score_sheets ON speaker_score_sheets.debate_team_xref_id = debates_teams_xrefs.id AND adjudicator_allocations.id = speaker_score_sheets.adjudicator_allocation_id
JOIN debaters ON debaters.id = speaker_score_sheets.debater_id
JOIN rounds ON rounds.id = debates.round_id
JOIN adjudicators ON adjudicators.id = adjudicator_allocations.adjudicator_id
WHERE team_results.majority_team_score = 1
GROUP BY 
  debates_teams_xrefs.id,
  debaters.id,
  speaker_score_sheets.speaking_position;


CREATE VIEW team_margins AS
SELECT
  team_results.debate_team_xref_id,
  team_results.majority_team_score,
  SUM(debater_results.averaged_score) AS team_speaker_score,
  SUM(debater_results.averaged_score) - SUM(opponent_debater_results.averaged_score) AS margin
FROM team_results
JOIN debater_results ON debater_results.debate_team_xref_id = team_results.debate_team_xref_id
JOIN debater_results AS opponent_debater_results ON opponent_debater_results.debate_team_xref_id = team_results.opponent_debate_team_xref_id AND opponent_debater_results.speaking_position = debater_results.speaking_position
GROUP BY team_results.debate_team_xref_id, team_results.majority_team_score;
