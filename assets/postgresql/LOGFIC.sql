CREATE SEQUENCE sistema.LOGFICCOD_sequence;
CREATE SEQUENCE auditoria.LOGFICAID_sequence;

CREATE TABLE sistema.LOGFIC (
  LOGFICCOD integer NOT NULL DEFAULT nextval('sistema.LOGFICCOD_sequence'::regclass),
  LOGFICEST integer NOT NULL,
  LOGFICNOM character varying(100) COLLATE pg_catalog."default" NOT NULL,
  LOGFICRPI character(1) COLLATE pg_catalog."default" NOT NULL,
  LOGFICOBS character varying(5120) COLLATE pg_catalog."default",
  LOGFICAUS character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGFICAFH timestamp without time zone NOT NULL,
  LOGFICAIP character(20) COLLATE pg_catalog."default" NOT NULL,
  CONSTRAINT LOGFICCOD_pk PRIMARY KEY (LOGFICCOD)
);

CREATE TABLE auditoria.LOGFIC (
  LOGFICAID integer NOT NULL DEFAULT nextval('auditoria.LOGFICAID_sequence'::regclass),
  LOGFICAME character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGFICAUS character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGFICAFH timestamp without time zone NOT NULL,
  LOGFICAIP character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGFICCOD integer,
  LOGFICEST integer,
  LOGFICNOM character varying(100) COLLATE pg_catalog."default",
  LOGFICRPI character(1) COLLATE pg_catalog."default",
  LOGFICOBS character varying(5120) COLLATE pg_catalog."default",
  CONSTRAINT LOGFICAID_pk PRIMARY KEY (LOGFICAID)
);

COMMENT ON TABLE sistema.LOGFIC IS 'LOGIN SISTEMA';
COMMENT ON TABLE auditoria.LOGFIC IS 'LOGIN SISTEMA';

ALTER TABLE sistema.LOGFIC ADD CONSTRAINT LOGFICEST_fk FOREIGN KEY (LOGFICEST) REFERENCES sistema.DOMFIC(DOMFICCOD);

ALTER TABLE sistema.LOGFIC OWNER to user_thholox;
ALTER TABLE auditoria.LOGFIC OWNER to user_thholox;

CREATE OR REPLACE FUNCTION auditoria.LOGFIC_functions() RETURNS TRIGGER AS $LOGFIC_functions$
  DECLARE
  BEGIN

    IF (TG_OP = 'INSERT') THEN
        INSERT INTO auditoria.LOGFIC(LOGFICAME, LOGFICAUS, LOGFICAFH, LOGFICAIP, LOGFICCOD, LOGFICEST, LOGFICNOM, LOGFICRPI, LOGFICOBS)
        VALUES ('INSERT AFTER', NEW.LOGFICAUS, NOW(), NEW.LOGFICAIP, NEW.LOGFICCOD, NEW.LOGFICEST, NEW.LOGFICNOM, NEW.LOGFICRPI, NEW.LOGFICOBS);
        RETURN NULL;
    
    ELSEIF (TG_OP = 'UPDATE') THEN
        INSERT INTO auditoria.LOGFIC(LOGFICAME, LOGFICAUS, LOGFICAFH, LOGFICAIP, LOGFICCOD, LOGFICEST, LOGFICNOM, LOGFICRPI, LOGFICOBS)
        VALUES ('UPDATE BEFORE', OLD.LOGFICAUS, NOW(), OLD.LOGFICAIP, OLD.LOGFICCOD, OLD.LOGFICEST, OLD.LOGFICNOM, OLD.LOGFICRPI, OLD.LOGFICOBS);

        INSERT INTO auditoria.LOGFIC(LOGFICAME, LOGFICAUS, LOGFICAFH, LOGFICAIP, LOGFICCOD, LOGFICEST, LOGFICNOM, LOGFICRPI, LOGFICOBS)
        VALUES ('UPDATE AFTER', NEW.LOGFICAUS, NOW(), NEW.LOGFICAIP, NEW.LOGFICCOD, NEW.LOGFICEST, NEW.LOGFICNOM, NEW.LOGFICRPI, NEW.LOGFICOBS);
        RETURN NULL;

    ELSEIF (TG_OP = 'DELETE') THEN
        INSERT INTO auditoria.LOGFIC(LOGFICAME, LOGFICAUS, LOGFICAFH, LOGFICAIP, LOGFICCOD, LOGFICEST, LOGFICNOM, LOGFICRPI, LOGFICOBS)
        VALUES ('DELETE BEFORE', OLD.LOGFICAUS, NOW(), OLD.LOGFICAIP, OLD.LOGFICCOD, OLD.LOGFICEST, OLD.LOGFICNOM, OLD.LOGFICRPI, OLD.LOGFICOBS);
        RETURN NULL;
    
    END IF;
  END;

$LOGFIC_functions$ LANGUAGE plpgsql;

CREATE TRIGGER LOGFIC_trigger_before
    BEFORE UPDATE OR DELETE ON sistema.LOGFIC
    FOR EACH ROW
    EXECUTE PROCEDURE auditoria.LOGFIC_functions();

CREATE TRIGGER LOGFIC_trigger_after
    AFTER INSERT ON sistema.LOGFIC
    FOR EACH ROW
    EXECUTE PROCEDURE auditoria.LOGFIC_functions();