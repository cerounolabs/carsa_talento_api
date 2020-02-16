CREATE SEQUENCE sistema.LOGACCCOD_sequence;
CREATE SEQUENCE auditoria.LOGACCAID_sequence;

CREATE TABLE sistema.LOGACC (
  LOGACCCOD integer NOT NULL DEFAULT nextval('sistema.LOGACCCOD_sequence'::regclass),
  LOGACCEST integer NOT NULL,
  LOGACCSIC integer NOT NULL,
  LOGACCFUC integer NOT NULL,
  LOGACCBAN character(1) COLLATE pg_catalog."default" NOT NULL,
  LOGACCOBS character varying(5120) COLLATE pg_catalog."default",
  LOGACCAUS character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGACCAFH timestamp without time zone NOT NULL,
  LOGACCAIP character(20) COLLATE pg_catalog."default" NOT NULL,
  CONSTRAINT LOGACCCOD_pk PRIMARY KEY (LOGACCCOD)
);

CREATE TABLE auditoria.LOGACC (
  LOGACCAID integer NOT NULL DEFAULT nextval('auditoria.LOGACCAID_sequence'::regclass),
  LOGACCAME character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGACCAUS character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGACCAFH timestamp without time zone NOT NULL,
  LOGACCAIP character(20) COLLATE pg_catalog."default" NOT NULL,
  LOGACCCOD integer,
  LOGACCEST integer,
  LOGACCSIC integer,
  LOGACCFUC integer,
  LOGACCBAN character(1) COLLATE pg_catalog."default",
  LOGACCOBS character varying(5120) COLLATE pg_catalog."default",
  CONSTRAINT LOGACCAID_pk PRIMARY KEY (LOGACCAID)
);

COMMENT ON TABLE sistema.LOGACC IS 'LOGIN ACCESO';
COMMENT ON TABLE auditoria.LOGACC IS 'LOGIN ACCESO';

ALTER TABLE sistema.LOGACC ADD CONSTRAINT LOGACCEST_fk FOREIGN KEY (LOGACCEST) REFERENCES sistema.DOMFIC(DOMFICCOD);
ALTER TABLE sistema.LOGACC ADD CONSTRAINT LOGACCSIC_fk FOREIGN KEY (LOGACCSIC) REFERENCES sistema.LOGFIC(LOGFICCOD);
ALTER TABLE sistema.LOGACC ADD CONSTRAINT LOGACCFUC_fk FOREIGN KEY (LOGACCFUC) REFERENCES sistema.LOGFIC(LOGFICCOD);

ALTER TABLE sistema.LOGACC OWNER to user_thholox;
ALTER TABLE auditoria.LOGACC OWNER to user_thholox;

CREATE OR REPLACE FUNCTION auditoria.LOGACC_functions() RETURNS TRIGGER AS $LOGACC_functions$
  DECLARE
  BEGIN

    IF (TG_OP = 'INSERT') THEN
        INSERT INTO auditoria.LOGACC(LOGACCAME, LOGACCAUS, LOGACCAFH, LOGACCAIP, LOGACCCOD, LOGACCEST, LOGACCSIC, LOGACCFUC, LOGACCBAN, LOGACCOBS)
        VALUES ('INSERT AFTER', NEW.LOGACCAUS, NOW(), NEW.LOGACCAIP, NEW.LOGACCCOD, NEW.LOGACCEST, NEW.LOGACCSIC, NEW.LOGACCFUC, NEW.LOGACCBAN, NEW.LOGACCOBS);
        RETURN NEW;
    
    ELSEIF (TG_OP = 'UPDATE') THEN
        INSERT INTO auditoria.LOGACC(LOGACCAME, LOGACCAUS, LOGACCAFH, LOGACCAIP, LOGACCCOD, LOGACCEST, LOGACCSIC, LOGACCFUC, LOGACCBAN, LOGACCOBS) VALUES 
        ('UPDATE BEFORE', OLD.LOGACCAUS, NOW(), OLD.LOGACCAIP, OLD.LOGACCCOD, OLD.LOGACCEST, OLD.LOGACCSIC, OLD.LOGACCFUC, OLD.LOGACCBAN, OLD.LOGACCOBS),
        ('UPDATE AFTER', NEW.LOGACCAUS, NOW(), NEW.LOGACCAIP, NEW.LOGACCCOD, NEW.LOGACCEST, NEW.LOGACCSIC, NEW.LOGACCFUC, NEW.LOGACCBAN, NEW.LOGACCOBS);
        RETURN NEW;

    ELSEIF (TG_OP = 'DELETE') THEN
        INSERT INTO auditoria.LOGACC(LOGACCAME, LOGACCAUS, LOGACCAFH, LOGACCAIP, LOGACCCOD, LOGACCEST, LOGACCSIC, LOGACCFUC, LOGACCBAN, LOGACCOBS)
        VALUES ('DELETE BEFORE', OLD.LOGACCAUS, NOW(), OLD.LOGACCAIP, OLD.LOGACCCOD, OLD.LOGACCEST, OLD.LOGACCSIC, OLD.LOGACCFUC, OLD.LOGACCBAN, OLD.LOGACCOBS);
        RETURN NEW;
    
    END IF;
  END;

$LOGACC_functions$ LANGUAGE plpgsql;

CREATE TRIGGER LOGACC_trigger_before
    BEFORE UPDATE OR DELETE ON sistema.LOGACC
    FOR EACH ROW
    EXECUTE PROCEDURE auditoria.LOGACC_functions();

CREATE TRIGGER LOGACC_trigger_after
    AFTER INSERT ON sistema.LOGACC
    FOR EACH ROW
    EXECUTE PROCEDURE auditoria.LOGACC_functions();