ALTER TABLE oxarticles 
ADD oxcalctest VARCHAR( 100 ) NOT NULL ,
ADD areacalc_opt1 VARCHAR( 100 ) NOT NULL ,
ADD areacalc_opt2 VARCHAR( 100 ) NOT NULL ; 


CREATE TABLE IF NOT EXISTS areacalc_typen (
  areacalctypeid varchar(100)  NOT NULL,
  oxidarticleid varchar(100)  NOT NULL,
  title varchar(100)  NOT NULL,
  title2 varchar(255)  NOT NULL,
  hoehe_min varchar(10)  NOT NULL DEFAULT '1',
  hoehe_max varchar(100)  NOT NULL,
  gewicht varchar(100)  NOT NULL DEFAULT '1',
  PRIMARY KEY (areacalctypeid)
) ;


CREATE TABLE IF NOT EXISTS areacalc_typen_staffel (
  areacalcstaffelid varchar(100)  NOT NULL,
  areacalctypeid varchar(100)  NOT NULL,
  staffel varchar(100)  NOT NULL,
  preis varchar(100)  NOT NULL,
  oxidarticleid varchar(100)  NOT NULL,
  PRIMARY KEY (areacalcstaffelid)
) ;