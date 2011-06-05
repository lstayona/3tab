
-----------------------------------------------------------------------------
-- institutions
-----------------------------------------------------------------------------

DROP TABLE "institutions" CASCADE;

DROP SEQUENCE "institutions_seq";

CREATE SEQUENCE "institutions_seq";


CREATE TABLE "institutions"
(
	"id" INTEGER  NOT NULL,
	"code" VARCHAR(20)  NOT NULL,
	"name" VARCHAR  NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "institutions_code" UNIQUE ("code")
);

COMMENT ON TABLE "institutions" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- teams
-----------------------------------------------------------------------------

DROP TABLE "teams" CASCADE;

DROP SEQUENCE "teams_seq";

CREATE SEQUENCE "teams_seq";


CREATE TABLE "teams"
(
	"id" INTEGER  NOT NULL,
	"name" VARCHAR(50)  NOT NULL,
	"institution_id" INTEGER  NOT NULL,
	"swing" BOOLEAN default 'f' NOT NULL,
	"active" BOOLEAN default 't' NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "teams_name" UNIQUE ("name")
);

COMMENT ON TABLE "teams" IS '';


SET search_path TO public;
ALTER TABLE "teams" ADD CONSTRAINT "teams_FK_1" FOREIGN KEY ("institution_id") REFERENCES "institutions" ("id");

-----------------------------------------------------------------------------
-- debaters
-----------------------------------------------------------------------------

DROP TABLE "debaters" CASCADE;

DROP SEQUENCE "debaters_seq";

CREATE SEQUENCE "debaters_seq";


CREATE TABLE "debaters"
(
	"id" INTEGER  NOT NULL,
	"name" VARCHAR(100)  NOT NULL,
	"team_id" INTEGER,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "debaters_name" UNIQUE ("name")
);

COMMENT ON TABLE "debaters" IS '';


SET search_path TO public;
ALTER TABLE "debaters" ADD CONSTRAINT "debaters_FK_1" FOREIGN KEY ("team_id") REFERENCES "teams" ("id");

-----------------------------------------------------------------------------
-- adjudicators
-----------------------------------------------------------------------------

DROP TABLE "adjudicators" CASCADE;

DROP SEQUENCE "adjudicators_seq";

CREATE SEQUENCE "adjudicators_seq";


CREATE TABLE "adjudicators"
(
	"id" INTEGER  NOT NULL,
	"name" VARCHAR(100)  NOT NULL,
	"test_score" FLOAT  NOT NULL,
	"institution_id" INTEGER  NOT NULL,
	"active" BOOLEAN default 't' NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "adjudicators_name" UNIQUE ("name")
);

COMMENT ON TABLE "adjudicators" IS '';


SET search_path TO public;
ALTER TABLE "adjudicators" ADD CONSTRAINT "adjudicators_FK_1" FOREIGN KEY ("institution_id") REFERENCES "institutions" ("id");

-----------------------------------------------------------------------------
-- rounds
-----------------------------------------------------------------------------

DROP TABLE "rounds" CASCADE;

DROP SEQUENCE "rounds_seq";

CREATE SEQUENCE "rounds_seq";


CREATE TABLE "rounds"
(
	"id" INTEGER  NOT NULL,
	"name" VARCHAR  NOT NULL,
	"type" INTEGER  NOT NULL,
	"status" INTEGER default 1 NOT NULL,
	"preceded_by_round_id" INTEGER,
	"feedback_weightage" FLOAT default 0 NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "rounds_name" UNIQUE ("name")
);

COMMENT ON TABLE "rounds" IS '';


SET search_path TO public;
ALTER TABLE "rounds" ADD CONSTRAINT "rounds_FK_1" FOREIGN KEY ("preceded_by_round_id") REFERENCES "rounds" ("id");

-----------------------------------------------------------------------------
-- venues
-----------------------------------------------------------------------------

DROP TABLE "venues" CASCADE;

DROP SEQUENCE "venues_seq";

CREATE SEQUENCE "venues_seq";


CREATE TABLE "venues"
(
	"id" INTEGER  NOT NULL,
	"name" VARCHAR  NOT NULL,
	"active" BOOLEAN default 't' NOT NULL,
	"priority" INTEGER default 1 NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "venues_name" UNIQUE ("name")
);

COMMENT ON TABLE "venues" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- debates
-----------------------------------------------------------------------------

DROP TABLE "debates" CASCADE;

DROP SEQUENCE "debates_seq";

CREATE SEQUENCE "debates_seq";


CREATE TABLE "debates"
(
	"id" INTEGER  NOT NULL,
	"round_id" INTEGER  NOT NULL,
	"venue_id" INTEGER  NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "debates_round_id_venue_id" UNIQUE ("round_id","venue_id")
);

COMMENT ON TABLE "debates" IS '';


SET search_path TO public;
ALTER TABLE "debates" ADD CONSTRAINT "debates_FK_1" FOREIGN KEY ("round_id") REFERENCES "rounds" ("id");

ALTER TABLE "debates" ADD CONSTRAINT "debates_FK_2" FOREIGN KEY ("venue_id") REFERENCES "venues" ("id");

-----------------------------------------------------------------------------
-- debates_teams_xrefs
-----------------------------------------------------------------------------

DROP TABLE "debates_teams_xrefs" CASCADE;

DROP SEQUENCE "debates_teams_xrefs_seq";

CREATE SEQUENCE "debates_teams_xrefs_seq";


CREATE TABLE "debates_teams_xrefs"
(
	"id" INTEGER  NOT NULL,
	"debate_id" INTEGER  NOT NULL,
	"team_id" INTEGER  NOT NULL,
	"position" INTEGER  NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "debates_teams_xrefs_debate_id_team_id" UNIQUE ("debate_id","team_id")
);

COMMENT ON TABLE "debates_teams_xrefs" IS '';


SET search_path TO public;
ALTER TABLE "debates_teams_xrefs" ADD CONSTRAINT "debates_teams_xrefs_FK_1" FOREIGN KEY ("debate_id") REFERENCES "debates" ("id");

ALTER TABLE "debates_teams_xrefs" ADD CONSTRAINT "debates_teams_xrefs_FK_2" FOREIGN KEY ("team_id") REFERENCES "teams" ("id");

-----------------------------------------------------------------------------
-- adjudicator_allocations
-----------------------------------------------------------------------------

DROP TABLE "adjudicator_allocations" CASCADE;

DROP SEQUENCE "adjudicator_allocations_seq";

CREATE SEQUENCE "adjudicator_allocations_seq";


CREATE TABLE "adjudicator_allocations"
(
	"id" INTEGER  NOT NULL,
	"debate_id" INTEGER  NOT NULL,
	"adjudicator_id" INTEGER  NOT NULL,
	"type" INTEGER  NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "adjudicator_allocations_debate_id_adjudicator_id" UNIQUE ("debate_id","adjudicator_id")
);

COMMENT ON TABLE "adjudicator_allocations" IS '';


SET search_path TO public;
ALTER TABLE "adjudicator_allocations" ADD CONSTRAINT "adjudicator_allocations_FK_1" FOREIGN KEY ("debate_id") REFERENCES "debates" ("id");

ALTER TABLE "adjudicator_allocations" ADD CONSTRAINT "adjudicator_allocations_FK_2" FOREIGN KEY ("adjudicator_id") REFERENCES "adjudicators" ("id");

-----------------------------------------------------------------------------
-- trainee_allocations
-----------------------------------------------------------------------------

DROP TABLE "trainee_allocations" CASCADE;

DROP SEQUENCE "trainee_allocations_seq";

CREATE SEQUENCE "trainee_allocations_seq";


CREATE TABLE "trainee_allocations"
(
	"id" INTEGER  NOT NULL,
	"trainee_id" INTEGER  NOT NULL,
	"chair_id" INTEGER  NOT NULL,
	"round_id" INTEGER  NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "trainee_allocations_trainee_id_chair_id_round_id" UNIQUE ("trainee_id","chair_id","round_id")
);

COMMENT ON TABLE "trainee_allocations" IS '';


SET search_path TO public;
ALTER TABLE "trainee_allocations" ADD CONSTRAINT "trainee_allocations_FK_1" FOREIGN KEY ("trainee_id") REFERENCES "adjudicators" ("id");

ALTER TABLE "trainee_allocations" ADD CONSTRAINT "trainee_allocations_FK_2" FOREIGN KEY ("chair_id") REFERENCES "adjudicators" ("id");

ALTER TABLE "trainee_allocations" ADD CONSTRAINT "trainee_allocations_FK_3" FOREIGN KEY ("round_id") REFERENCES "rounds" ("id");

-----------------------------------------------------------------------------
-- team_score_sheets
-----------------------------------------------------------------------------

DROP TABLE "team_score_sheets" CASCADE;

DROP SEQUENCE "team_score_sheets_seq";

CREATE SEQUENCE "team_score_sheets_seq";


CREATE TABLE "team_score_sheets"
(
	"id" INTEGER  NOT NULL,
	"adjudicator_allocation_id" INTEGER  NOT NULL,
	"debate_team_xref_id" INTEGER  NOT NULL,
	"score" INTEGER  NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "team_score_sheets" IS '';


SET search_path TO public;
ALTER TABLE "team_score_sheets" ADD CONSTRAINT "team_score_sheets_FK_1" FOREIGN KEY ("adjudicator_allocation_id") REFERENCES "adjudicator_allocations" ("id");

ALTER TABLE "team_score_sheets" ADD CONSTRAINT "team_score_sheets_FK_2" FOREIGN KEY ("debate_team_xref_id") REFERENCES "debates_teams_xrefs" ("id");

-----------------------------------------------------------------------------
-- speaker_score_sheets
-----------------------------------------------------------------------------

DROP TABLE "speaker_score_sheets" CASCADE;

DROP SEQUENCE "speaker_score_sheets_seq";

CREATE SEQUENCE "speaker_score_sheets_seq";


CREATE TABLE "speaker_score_sheets"
(
	"id" INTEGER  NOT NULL,
	"adjudicator_allocation_id" INTEGER  NOT NULL,
	"debate_team_xref_id" INTEGER  NOT NULL,
	"debater_id" INTEGER  NOT NULL,
	"score" FLOAT  NOT NULL,
	"speaking_position" INTEGER  NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "speaker_score_sheets" IS '';


SET search_path TO public;
ALTER TABLE "speaker_score_sheets" ADD CONSTRAINT "speaker_score_sheets_FK_1" FOREIGN KEY ("adjudicator_allocation_id") REFERENCES "adjudicator_allocations" ("id");

ALTER TABLE "speaker_score_sheets" ADD CONSTRAINT "speaker_score_sheets_FK_2" FOREIGN KEY ("debate_team_xref_id") REFERENCES "debates_teams_xrefs" ("id");

ALTER TABLE "speaker_score_sheets" ADD CONSTRAINT "speaker_score_sheets_FK_3" FOREIGN KEY ("debater_id") REFERENCES "debaters" ("id");

-----------------------------------------------------------------------------
-- adjudicator_feedback_sheets
-----------------------------------------------------------------------------

DROP TABLE "adjudicator_feedback_sheets" CASCADE;

DROP SEQUENCE "adjudicator_feedback_sheets_seq";

CREATE SEQUENCE "adjudicator_feedback_sheets_seq";


CREATE TABLE "adjudicator_feedback_sheets"
(
	"id" INTEGER  NOT NULL,
	"adjudicator_id" INTEGER  NOT NULL,
	"adjudicator_allocation_id" INTEGER,
	"debate_team_xref_id" INTEGER,
	"comments" VARCHAR(500),
	"score" FLOAT  NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "adjudicator_feedback_sheets" IS '';


SET search_path TO public;
ALTER TABLE "adjudicator_feedback_sheets" ADD CONSTRAINT "adjudicator_feedback_sheets_FK_1" FOREIGN KEY ("adjudicator_id") REFERENCES "adjudicators" ("id");

ALTER TABLE "adjudicator_feedback_sheets" ADD CONSTRAINT "adjudicator_feedback_sheets_FK_2" FOREIGN KEY ("adjudicator_allocation_id") REFERENCES "adjudicator_allocations" ("id");

ALTER TABLE "adjudicator_feedback_sheets" ADD CONSTRAINT "adjudicator_feedback_sheets_FK_3" FOREIGN KEY ("debate_team_xref_id") REFERENCES "debates_teams_xrefs" ("id");

-----------------------------------------------------------------------------
-- team_scores
-----------------------------------------------------------------------------

DROP TABLE "team_scores" CASCADE;

DROP SEQUENCE "team_scores_seq";

CREATE SEQUENCE "team_scores_seq";


CREATE TABLE "team_scores"
(
	"id" INTEGER  NOT NULL,
	"team_id" INTEGER  NOT NULL,
	"total_team_score" INTEGER default 0 NOT NULL,
	"total_speaker_score" FLOAT default 0 NOT NULL,
	"total_margin" FLOAT default 0 NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "team_scores_team_id" UNIQUE ("team_id")
);

COMMENT ON TABLE "team_scores" IS '';


SET search_path TO public;
ALTER TABLE "team_scores" ADD CONSTRAINT "team_scores_FK_1" FOREIGN KEY ("team_id") REFERENCES "teams" ("id");

-----------------------------------------------------------------------------
-- speaker_scores
-----------------------------------------------------------------------------

DROP TABLE "speaker_scores" CASCADE;

DROP SEQUENCE "speaker_scores_seq";

CREATE SEQUENCE "speaker_scores_seq";


CREATE TABLE "speaker_scores"
(
	"id" INTEGER  NOT NULL,
	"debater_id" INTEGER  NOT NULL,
	"total_speaker_score" FLOAT default 0 NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "speaker_scores_debater_id" UNIQUE ("debater_id")
);

COMMENT ON TABLE "speaker_scores" IS '';


SET search_path TO public;
ALTER TABLE "speaker_scores" ADD CONSTRAINT "speaker_scores_FK_1" FOREIGN KEY ("debater_id") REFERENCES "debaters" ("id");

-----------------------------------------------------------------------------
-- adjudicator_conflicts
-----------------------------------------------------------------------------

DROP TABLE "adjudicator_conflicts" CASCADE;

DROP SEQUENCE "adjudicator_conflicts_seq";

CREATE SEQUENCE "adjudicator_conflicts_seq";


CREATE TABLE "adjudicator_conflicts"
(
	"id" INTEGER  NOT NULL,
	"team_id" INTEGER  NOT NULL,
	"adjudicator_id" INTEGER  NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "adjudicator_conflicts" IS '';


SET search_path TO public;
ALTER TABLE "adjudicator_conflicts" ADD CONSTRAINT "adjudicator_conflicts_FK_1" FOREIGN KEY ("team_id") REFERENCES "teams" ("id");

ALTER TABLE "adjudicator_conflicts" ADD CONSTRAINT "adjudicator_conflicts_FK_2" FOREIGN KEY ("adjudicator_id") REFERENCES "adjudicators" ("id");
