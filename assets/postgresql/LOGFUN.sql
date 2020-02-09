CREATE SEQUENCE sistema.LOGFUNCOD_sequence;
CREATE SEQUENCE auditoria.LOGFUNAID_sequence;

CREATE TABLE sistema.LOGFUN (
  LOGFUNCOD integer NOT NULL DEFAULT nextval('sistema.LOGFUNCOD_sequence'::regclass),
  LOGFUNEST integer NOT NULL,
  LOGFUNLOC integer NOT NULL,
  LOGFUNFUC integer NOT NULL,
  LOGFUNDIP character varying(100) COLLATE pg_catalog."default" NOT NULL,
  LOGFUNOBS character varying(5120) COLLATE pg_catalog."default",
  LOGFUNAUS character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGFUNAFH timestamp without time zone NOT NULL,
  LOGFUNAIP character(20) COLLATE pg_catalog."default" NOT NULL,
  CONSTRAINT LOGFUNCOD_pk PRIMARY KEY (LOGFUNCOD)
);

CREATE TABLE auditoria.LOGFUN (
  LOGFUNAID integer NOT NULL DEFAULT nextval('auditoria.LOGFUNAID_sequence'::regclass),
  LOGFUNAME character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGFUNAUS character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGFUNAFH timestamp without time zone NOT NULL,
  LOGFUNAIP character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGFUNCOD integer,
  LOGFUNEST integer,
  LOGFUNLOC integer,
  LOGFUNFUC integer,
  LOGFUNDIP character varying(100) COLLATE pg_catalog."default",
  LOGFUNOBS character varying(5120) COLLATE pg_catalog."default",
  CONSTRAINT LOGFUNAID_pk PRIMARY KEY (LOGFUNAID)
);

COMMENT ON TABLE sistema.LOGFUN IS 'LOGIN FUNCIONARIO';
COMMENT ON TABLE auditoria.LOGFUN IS 'LOGIN FUNCIONARIO';

ALTER TABLE sistema.LOGFUN ADD CONSTRAINT LOGFUNEST_fk FOREIGN KEY (LOGFUNEST) REFERENCES sistema.DOMFIC(DOMFICCOD);
ALTER TABLE sistema.LOGFUN ADD CONSTRAINT LOGFUNLOC_fk FOREIGN KEY (LOGFUNLOC) REFERENCES sistema.LOGFIC(LOGFICCOD);
ALTER TABLE sistema.LOGFUN ADD CONSTRAINT LOGFUNFUC_fk FOREIGN KEY (LOGFUNFUC) REFERENCES sistema.FUNFIC(FUNFICCOD);

ALTER TABLE sistema.LOGFUN OWNER to user_thholox;
ALTER TABLE auditoria.LOGFUN OWNER to user_thholox;

CREATE OR REPLACE FUNCTION auditoria.LOGFUN_functions() RETURNS TRIGGER AS $LOGFUN_functions$
  DECLARE
  BEGIN

    IF (TG_OP = 'INSERT') THEN
        INSERT INTO auditoria.LOGFUN(LOGFUNAME, LOGFUNAUS, LOGFUNAFH, LOGFUNAIP, LOGFUNCOD, LOGFUNEST, LOGFUNLOC, LOGFUNFUC, LOGFUNDIP, LOGFUNOBS)
        VALUES ('INSERT AFTER', NEW.LOGFUNAUS, NOW(), NEW.LOGFUNAIP, NEW.LOGFUNCOD, NEW.LOGFUNEST, NEW.LOGFUNLOC, NEW.LOGFUNFUC, NEW.LOGFUNDIP, NEW.LOGFUNOBS);
        RETURN NULL;
    
    ELSEIF (TG_OP = 'UPDATE') THEN
        INSERT INTO auditoria.LOGFUN(LOGFUNAME, LOGFUNAUS, LOGFUNAFH, LOGFUNAIP, LOGFUNCOD, LOGFUNEST, LOGFUNLOC, LOGFUNFUC, LOGFUNDIP, LOGFUNOBS)
        VALUES ('UPDATE BEFORE', OLD.LOGFUNAUS, NOW(), OLD.LOGFUNAIP, OLD.LOGFUNCOD, OLD.LOGFUNEST, OLD.LOGFUNLOC, OLD.LOGFUNFUC, OLD.LOGFUNDIP, OLD.LOGFUNOBS);

        INSERT INTO auditoria.LOGFUN(LOGFUNAME, LOGFUNAUS, LOGFUNAFH, LOGFUNAIP, LOGFUNCOD, LOGFUNEST, LOGFUNLOC, LOGFUNFUC, LOGFUNDIP, LOGFUNOBS)
        VALUES ('INSERT AFTER', NEW.LOGFUNAUS, NOW(), NEW.LOGFUNAIP, NEW.LOGFUNCOD, NEW.LOGFUNEST, NEW.LOGFUNLOC, NEW.LOGFUNFUC, NEW.LOGFUNDIP, NEW.LOGFUNOBS);
        RETURN NULL;

    ELSEIF (TG_OP = 'DELETE') THEN
        INSERT INTO auditoria.LOGFUN(LOGFUNAME, LOGFUNAUS, LOGFUNAFH, LOGFUNAIP, LOGFUNCOD, LOGFUNEST, LOGFUNLOC, LOGFUNFUC, LOGFUNDIP, LOGFUNOBS)
        VALUES ('DELETE BEFORE', OLD.LOGFUNAUS, NOW(), OLD.LOGFUNAIP, OLD.LOGFUNCOD, OLD.LOGFUNEST, OLD.LOGFUNLOC, OLD.LOGFUNFUC, OLD.LOGFUNDIP, OLD.LOGFUNOBS);
        RETURN NULL;
    
    END IF;
  END;

$LOGFUN_functions$ LANGUAGE plpgsql;

CREATE TRIGGER LOGFUN_trigger_before
    BEFORE UPDATE OR DELETE ON sistema.LOGFUN
    FOR EACH ROW
    EXECUTE PROCEDURE auditoria.LOGFUN_functions();

CREATE TRIGGER LOGFUN_trigger_after
    AFTER INSERT ON sistema.LOGFUN
    FOR EACH ROW
    EXECUTE PROCEDURE auditoria.LOGFUN_functions();