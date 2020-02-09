CREATE SEQUENCE sistema.DOMFICCOD_sequence;
CREATE SEQUENCE auditoria.DOMFICAID_sequence;

CREATE TABLE sistema.DOMFIC (
  DOMFICCOD integer NOT NULL DEFAULT nextval('sistema.DOMFICCOD_sequence'::regclass),
  DOMFICEST integer NOT NULL,
  DOMFICNOM character varying(100) COLLATE pg_catalog."default" NOT NULL,
  DOMFICEQU character varying(100) COLLATE pg_catalog."default",
  DOMFICVAL character(50) COLLATE pg_catalog."default" NOT NULL,
  DOMFICOBS character varying(5120) COLLATE pg_catalog."default",
  DOMFICAUS character(20) COLLATE pg_catalog."default" NOT NULL,
  DOMFICAFH timestamp without time zone NOT NULL,
  DOMFICAIP character(20) COLLATE pg_catalog."default" NOT NULL,
  CONSTRAINT DOMFICCOD_pk PRIMARY KEY (DOMFICCOD)
);

CREATE TABLE auditoria.DOMFIC (
  DOMFICAID integer NOT NULL DEFAULT nextval('auditoria.DOMFICAID_sequence'::regclass),
  DOMFICAME character(20) COLLATE pg_catalog."default" NOT NULL,
  DOMFICAUS character(20) COLLATE pg_catalog."default" NOT NULL,
  DOMFICAFH timestamp without time zone NOT NULL,
  DOMFICAIP character(20) COLLATE pg_catalog."default" NOT NULL,
  DOMFICCOD integer,
  DOMFICEST integer,
  DOMFICNOM character varying(100) COLLATE pg_catalog."default",
  DOMFICEQU character varying(100) COLLATE pg_catalog."default",
  DOMFICVAL character(50) COLLATE pg_catalog."default",
  DOMFICOBS character varying(5120) COLLATE pg_catalog."default",
  CONSTRAINT DOMFICAID_pk PRIMARY KEY (DOMFICAID)
);

COMMENT ON TABLE sistema.DOMFIC IS 'DOMINIO';
COMMENT ON TABLE auditoria.DOMFIC IS 'DOMINIO';

ALTER TABLE sistema.DOMFIC OWNER to user_thholox;
ALTER TABLE auditoria.DOMFIC OWNER to user_thholox;

CREATE OR REPLACE FUNCTION auditoria.DOMFIC_functions() RETURNS TRIGGER AS $DOMFIC_functions$
  DECLARE
  BEGIN

    IF (TG_OP = 'INSERT') THEN
        INSERT INTO auditoria.DOMFIC(DOMFICAME, DOMFICAUS, DOMFICAFH, DOMFICAIP, DOMFICCOD, DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS)
        VALUES ('INSERT AFTER', NEW.DOMFICAUS, NOW(), NEW.DOMFICAIP, NEW.DOMFICCOD, NEW.DOMFICEST, NEW.DOMFICNOM, NEW.DOMFICEQU, NEW.DOMFICVAL, NEW.DOMFICOBS);
        RETURN NULL;
    
    ELSEIF (TG_OP = 'UPDATE') THEN
        INSERT INTO auditoria.DOMFIC(DOMFICAME, DOMFICAUS, DOMFICAFH, DOMFICAIP, DOMFICCOD, DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS)
        VALUES ('UPDATE BEFORE', OLD.DOMFICAUS, NOW(), OLD.DOMFICAIP, OLD.DOMFICCOD, OLD.DOMFICEST, OLD.DOMFICNOM, OLD.DOMFICEQU, OLD.DOMFICVAL, OLD.DOMFICOBS);

        INSERT INTO auditoria.DOMFIC(DOMFICAME, DOMFICAUS, DOMFICAFH, DOMFICAIP, DOMFICCOD, DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS)
        VALUES ('UPDATE AFTER', NEW.DOMFICAUS, NOW(), NEW.DOMFICAIP, NEW.DOMFICCOD, NEW.DOMFICEST, NEW.DOMFICNOM, NEW.DOMFICEQU, NEW.DOMFICVAL, NEW.DOMFICOBS);
        RETURN NULL;

    ELSEIF (TG_OP = 'DELETE') THEN
        INSERT INTO auditoria.DOMFIC(DOMFICAME, DOMFICAUS, DOMFICAFH, DOMFICAIP, DOMFICCOD, DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS)
        VALUES ('DELETE BEFORE', OLD.DOMFICAUS, NOW(), OLD.DOMFICAIP, OLD.DOMFICCOD, OLD.DOMFICEST, OLD.DOMFICNOM, OLD.DOMFICEQU, OLD.DOMFICVAL, OLD.DOMFICOBS);
        RETURN NULL;
    
    END IF;
  END;

$DOMFIC_functions$ LANGUAGE plpgsql;

CREATE TRIGGER DOMFIC_trigger_before
    BEFORE UPDATE OR DELETE ON sistema.DOMFIC
    FOR EACH ROW
    EXECUTE PROCEDURE auditoria.DOMFIC_functions();

CREATE TRIGGER DOMFIC_trigger_after
    AFTER INSERT ON sistema.DOMFIC
    FOR EACH ROW
    EXECUTE PROCEDURE auditoria.DOMFIC_functions();
  
INSERT INTO sistema.DOMFIC (DOMFICEST, DOMFICNOM, DOMFICVAL, DOMFICEQU, DOMFICAUS, DOMFICAFH, DOMFICAIP)
VALUES 
(1, 'ACTIVO', 'DOMINIOESTADO', NULL, 'MIGRACION', NOW(), '192.168.16.9'),
(1, 'INACTIVO', 'DOMINIOESTADO', NULL, 'MIGRACION', NOW(), '192.168.16.9'),
(1, 'BLOQUEADO', 'DOMINIOESTADO', NULL, 'MIGRACION', NOW(), '192.168.16.9'),
(1, 'CÉDULA DE IDENTIDAD POLICIAL', 'PERSONADOCUMENTO', '1', 'MIGRACION', NOW(), '192.168.16.9'),
(1, 'REGISTRO ÚNICO DE CONTRIBUYENTE', 'PERSONADOCUMENTO', '2', 'MIGRACION', NOW(), '192.168.16.9'),
(1, 'MASCULINO', 'PERSONASEXO', 'M', 'MIGRACION', NOW(), '192.168.16.9'),
(1, 'FEMENINO', 'PERSONASEXO', 'F', 'MIGRACION', NOW(), '192.168.16.9');

ALTER TABLE sistema.DOMFIC ADD CONSTRAINT DOMFICEST_fk FOREIGN KEY (DOMFICEST) REFERENCES sistema.DOMFIC(DOMFICCOD);
