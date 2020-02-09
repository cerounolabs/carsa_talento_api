CREATE SEQUENCE sistema.FUNFICCOD_sequence;
CREATE SEQUENCE auditoria.FUNFICAID_sequence;

CREATE TABLE sistema.FUNFIC (
    FUNFICCOD integer NOT NULL DEFAULT nextval('sistema.FUNFICCOD_sequence'::regclass),
    FUNFICEST integer NOT NULL,
    FUNFICTDC integer NOT NULL,
    FUNFICTSC integer NOT NULL,
    FUNFICECC integer NOT NULL,
    FUNFICNAC integer NOT NULL,
    FUNFICCFU integer NOT NULL,
    FUNFICNO1 character varying(100) COLLATE pg_catalog."default" NOT NULL,
    FUNFICNO2 character varying(100) COLLATE pg_catalog."default",
    FUNFICAP1 character varying(100) COLLATE pg_catalog."default" NOT NULL,
    FUNFICAP2 character varying(100) COLLATE pg_catalog."default",
    FUNFICAP3 character varying(100) COLLATE pg_catalog."default",
    FUNFICDNU character(20) COLLATE pg_catalog."default" NOT NULL,
    FUNFICDVE date NOT NULL,
    FUNFICFNA date NOT NULL,
    FUNFICEMA character varying(100) COLLATE pg_catalog."default",
    FUNFICFOT character varying(100) COLLATE pg_catalog."default",
    FUNFICOBS character varying(5120) COLLATE pg_catalog."default",
    FUNFICAUS character(20) COLLATE pg_catalog."default" NOT NULL,
    FUNFICAFH timestamp without time zone NOT NULL,
    FUNFICAIP character(20) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT FUNFICCOD_pk PRIMARY KEY (FUNFICCOD)
);
 
CREATE TABLE auditoria.FUNFIC (
    FUNFICAID integer  NOT NULL DEFAULT nextval('auditoria.FUNFICAID_sequence'::regclass),
    FUNFICAME character(20) COLLATE pg_catalog."default" NOT NULL,
    FUNFICAUS character(20) COLLATE pg_catalog."default" NOT NULL,
    FUNFICAFH timestamp without time zone NOT NULL,
    FUNFICAIP character(20) COLLATE pg_catalog."default" NOT NULL,
    FUNFICCOD integer,
    FUNFICEST integer,
    FUNFICTDC integer,
    FUNFICTSC integer,
    FUNFICECC integer,
    FUNFICTNC integer,
    FUNFICCFU integer,
    FUNFICNO1 character varying(100) COLLATE pg_catalog."default",
    FUNFICNO2 character varying(100) COLLATE pg_catalog."default",
    FUNFICAP1 character varying(100) COLLATE pg_catalog."default",
    FUNFICAP2 character varying(100) COLLATE pg_catalog."default",
    FUNFICAP3 character varying(100) COLLATE pg_catalog."default",
    FUNFICDNU character(20) COLLATE pg_catalog."default",
    FUNFICDVE date,
    FUNFICFNA date,
    FUNFICEMA character varying(100) COLLATE pg_catalog."default",
    FUNFICFOT character varying(100) COLLATE pg_catalog."default",
    FUNFICOBS character varying(5120) COLLATE pg_catalog."default",
    CONSTRAINT FUNFICAID_pk PRIMARY KEY (FUNFICAID)
);

COMMENT ON TABLE sistema.FUNFIC IS 'FUNCIONARIO';
COMMENT ON TABLE auditoria.FUNFIC IS 'FUNCIONARIO';

ALTER TABLE sistema.FUNFIC ADD CONSTRAINT FUNFICEST_fk FOREIGN KEY (FUNFICEST) REFERENCES sistema.DOMFIC(DOMFICCOD);
ALTER TABLE sistema.FUNFIC ADD CONSTRAINT FUNFICTDC_fk FOREIGN KEY (FUNFICTDC) REFERENCES sistema.DOMFIC(DOMFICCOD);
ALTER TABLE sistema.FUNFIC ADD CONSTRAINT FUNFICTSC_fk FOREIGN KEY (FUNFICTSC) REFERENCES sistema.DOMFIC(DOMFICCOD);
ALTER TABLE sistema.FUNFIC ADD CONSTRAINT FUNFICECC_fk FOREIGN KEY (FUNFICECC) REFERENCES sistema.DOMFIC(DOMFICCOD);

ALTER TABLE sistema.FUNFIC OWNER to user_thholox;
ALTER TABLE auditoria.FUNFIC OWNER to user_thholox;

CREATE OR REPLACE FUNCTION auditoria.FUNFIC_functions() RETURNS TRIGGER AS $FUNFIC_functions$
  DECLARE
  BEGIN

    IF (TG_OP = 'INSERT') THEN
        INSERT INTO auditoria.FUNFIC(FUNFICAME, FUNFICAUS, FUNFICAFH, FUNFICAIP, FUNFICCOD, FUNFICEST, FUNFICTDC, FUNFICTSC, FUNFICECC, FUNFICTNC, FUNFICCFU, FUNFICNO1, FUNFICNO2, FUNFICAP1, FUNFICAP2, FUNFICAP3, FUNFICDNU, FUNFICDVE, FUNFICFNA, FUNFICEMA, FUNFICFOT, FUNFICOBS)
        VALUES ('INSERT AFTER', NEW.FUNFICAUS, NOW(), NEW.FUNFICAIP, NEW.FUNFICCOD, NEW.FUNFICEST, NEW.FUNFICTDC, NEW.FUNFICTSC, NEW.FUNFICECC, NEW.FUNFICTNC, NEW.FUNFICCFU, NEW.FUNFICNO1, NEW.FUNFICNO2, NEW.FUNFICAP1, NEW.FUNFICAP2, NEW.FUNFICAP3, NEW.FUNFICDNU, NEW.FUNFICDVE, NEW.FUNFICFNA, NEW.FUNFICEMA, NEW.FUNFICFOT, NEW.FUNFICOBS);
        RETURN NULL;
    
    ELSEIF (TG_OP = 'UPDATE') THEN
        INSERT INTO auditoria.FUNFIC(FUNFICAME, FUNFICAUS, FUNFICAFH, FUNFICAIP, FUNFICCOD, FUNFICEST, FUNFICTDC, FUNFICTSC, FUNFICECC, FUNFICTNC, FUNFICCFU, FUNFICNO1, FUNFICNO2, FUNFICAP1, FUNFICAP2, FUNFICAP3, FUNFICDNU, FUNFICDVE, FUNFICFNA, FUNFICEMA, FUNFICFOT, FUNFICOBS)
        VALUES ('UPDATE BEFORE', OLD.FUNFICAUS, NOW(), OLD.FUNFICAIP, OLD.FUNFICCOD, OLD.FUNFICEST, OLD.FUNFICTDC, OLD.FUNFICTSC, OLD.FUNFICECC, OLD.FUNFICTNC, OLD.FUNFICCFU, OLD.FUNFICNO1, OLD.FUNFICNO2, OLD.FUNFICAP1, OLD.FUNFICAP2, OLD.FUNFICAP3, OLD.FUNFICDNU, OLD.FUNFICDVE, OLD.FUNFICFNA, OLD.FUNFICEMA, OLD.FUNFICFOT, OLD.FUNFICOBS);

        INSERT INTO auditoria.FUNFIC(FUNFICAME, FUNFICAUS, FUNFICAFH, FUNFICAIP, FUNFICCOD, FUNFICEST, FUNFICTDC, FUNFICTSC, FUNFICECC, FUNFICTNC, FUNFICCFU, FUNFICNO1, FUNFICNO2, FUNFICAP1, FUNFICAP2, FUNFICAP3, FUNFICDNU, FUNFICDVE, FUNFICFNA, FUNFICEMA, FUNFICFOT, FUNFICOBS)
        VALUES ('UPDATE AFTER', NEW.FUNFICAUS, NOW(), NEW.FUNFICAIP, NEW.FUNFICCOD, NEW.FUNFICEST, NEW.FUNFICTDC, NEW.FUNFICTSC, NEW.FUNFICECC, NEW.FUNFICTNC, NEW.FUNFICCFU, NEW.FUNFICNO1, NEW.FUNFICNO2, NEW.FUNFICAP1, NEW.FUNFICAP2, NEW.FUNFICAP3, NEW.FUNFICDNU, NEW.FUNFICDVE, NEW.FUNFICFNA, NEW.FUNFICEMA, NEW.FUNFICFOT, NEW.FUNFICOBS);
        RETURN NULL;

    ELSEIF (TG_OP = 'DELETE') THEN
        INSERT INTO auditoria.FUNFIC(FUNFICAME, FUNFICAUS, FUNFICAFH, FUNFICAIP, FUNFICCOD, FUNFICEST, FUNFICTDC, FUNFICTSC, FUNFICECC, FUNFICTNC, FUNFICCFU, FUNFICNO1, FUNFICNO2, FUNFICAP1, FUNFICAP2, FUNFICAP3, FUNFICDNU, FUNFICDVE, FUNFICFNA, FUNFICEMA, FUNFICFOT, FUNFICOBS)
        VALUES ('DELETE BEFORE', OLD.FUNFICAUS, NOW(), OLD.FUNFICAIP, OLD.FUNFICCOD, OLD.FUNFICEST, OLD.FUNFICTDC, OLD.FUNFICTSC, OLD.FUNFICECC, OLD.FUNFICTNC, OLD.FUNFICCFU, OLD.FUNFICNO1, OLD.FUNFICNO2, OLD.FUNFICAP1, OLD.FUNFICAP2, OLD.FUNFICAP3, OLD.FUNFICDNU, OLD.FUNFICDVE, OLD.FUNFICFNA, OLD.FUNFICEMA, OLD.FUNFICFOT, OLD.FUNFICOBS);
        RETURN NULL;
    
    END IF;
  END;

$FUNFIC_functions$ LANGUAGE plpgsql;

CREATE TRIGGER FUNFIC_trigger_before
    BEFORE UPDATE OR DELETE ON sistema.FUNFIC
    FOR EACH ROW
    EXECUTE PROCEDURE auditoria.FUNFIC_functions();

CREATE TRIGGER FUNFIC_trigger_after
    AFTER INSERT ON sistema.FUNFIC
    FOR EACH ROW
    EXECUTE PROCEDURE auditoria.FUNFIC_functions();