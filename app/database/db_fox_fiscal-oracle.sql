CREATE TABLE tbl_cidades( 
      id number(10)    NOT NULL , 
      cidades varchar  (100)    NOT NULL , 
      uf_id number(10)    NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_empresa( 
      id number(10)    NOT NULL , 
      empresa varchar  (50)    DEFAULT 'VIVARA'  NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_lojas( 
      id number(10)    NOT NULL , 
      empresa_id number(10)    NOT NULL , 
      status_id number(10)    NOT NULL , 
      numCapta varchar  (20)    NOT NULL , 
      loja varchar  (20)   , 
      uf_id number(10)    NOT NULL , 
      endereco varchar  (60)   , 
      cidades_id number(10)    NOT NULL , 
      cep varchar  (20)    DEFAULT '00000-000' , 
      shopping varchar  (30)   , 
      cnpj varchar  (30)    NOT NULL , 
      inscEstadual varchar  (30)   , 
      inscMunicipal varchar  (30)   , 
      nire varchar  (30)   , 
      responsavel_id number(10)    NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_pais( 
      id number(10)    NOT NULL , 
      pais varchar  (50)    NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_prazos( 
      id number(10)    NOT NULL , 
      uf_id number(10)    NOT NULL , 
      data_icms varchar  (20)    NOT NULL , 
      data_iss varchar  (20)    NOT NULL , 
      data_fecop varchar  (20)   , 
      data_difal varchar  (20)   , 
      data_antecipado varchar  (20)   , 
      data_sped varchar  (20)   , 
      data_declaracao varchar  (20)    NOT NULL , 
      ciap varchar  (20)   , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_responsaveis( 
      id number(10)    NOT NULL , 
      responsavel varchar  (50)    NOT NULL , 
      re varchar  (20)    NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_senhasEstaduais( 
      id number(10)    NOT NULL , 
      loja_id number(10)    NOT NULL , 
      uf_id number(10)    NOT NULL , 
      login varchar  (50)    NOT NULL , 
      senha varchar  (80)    NOT NULL , 
      local varchar  (250)    NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_senhasMunicipais( 
      id number(10)    NOT NULL , 
      loja_id number(10)    NOT NULL , 
      uf_id number(10)    NOT NULL , 
      cidades_id number(10)    NOT NULL , 
      login varchar  (50)    NOT NULL , 
      senha varchar  (80)    NOT NULL , 
      local varchar  (250)    NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_status( 
      id number(10)    NOT NULL , 
      status varchar  (50)    NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_uf( 
      id number(10)    NOT NULL , 
      uf varchar  (4)    NOT NULL , 
      pais_id number(10)    NOT NULL , 
 PRIMARY KEY (id)); 

  
  
 ALTER TABLE tbl_cidades ADD CONSTRAINT fk_municipios_1 FOREIGN KEY (uf_id) references tbl_uf(id); 
ALTER TABLE tbl_lojas ADD CONSTRAINT fk_cadastro_loja_2 FOREIGN KEY (status_id) references tbl_status(id); 
ALTER TABLE tbl_lojas ADD CONSTRAINT fk_cadastro_loja_2 FOREIGN KEY (cidades_id) references tbl_cidades(id); 
ALTER TABLE tbl_lojas ADD CONSTRAINT fk_cadastro_loja_3 FOREIGN KEY (empresa_id) references tbl_empresa(id); 
ALTER TABLE tbl_lojas ADD CONSTRAINT fk_cadastro_loja_4 FOREIGN KEY (responsavel_id) references tbl_responsaveis(id); 
ALTER TABLE tbl_lojas ADD CONSTRAINT fk_cadastro_loja_5 FOREIGN KEY (uf_id) references tbl_uf(id); 
ALTER TABLE tbl_prazos ADD CONSTRAINT fk_new_table_10_1 FOREIGN KEY (uf_id) references tbl_uf(id); 
ALTER TABLE tbl_senhasEstaduais ADD CONSTRAINT fk_senhas_estaduais_1 FOREIGN KEY (loja_id) references tbl_lojas(id); 
ALTER TABLE tbl_senhasEstaduais ADD CONSTRAINT fk_tbl_senhas_estaduais_2 FOREIGN KEY (uf_id) references tbl_uf(id); 
ALTER TABLE tbl_senhasMunicipais ADD CONSTRAINT fk_senhas_municipais_1 FOREIGN KEY (loja_id) references tbl_lojas(id); 
ALTER TABLE tbl_senhasMunicipais ADD CONSTRAINT fk_tbl_senhas_municipais_2 FOREIGN KEY (uf_id) references tbl_uf(id); 
ALTER TABLE tbl_senhasMunicipais ADD CONSTRAINT fk_tbl_senhasMunicipais_3 FOREIGN KEY (cidades_id) references tbl_cidades(id); 
ALTER TABLE tbl_uf ADD CONSTRAINT fk_estados_1 FOREIGN KEY (pais_id) references tbl_pais(id); 
 CREATE SEQUENCE tbl_cidades_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_cidades_id_seq_tr 

BEFORE INSERT ON tbl_cidades FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_cidades_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tbl_empresa_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_empresa_id_seq_tr 

BEFORE INSERT ON tbl_empresa FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_empresa_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tbl_lojas_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_lojas_id_seq_tr 

BEFORE INSERT ON tbl_lojas FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_lojas_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tbl_pais_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_pais_id_seq_tr 

BEFORE INSERT ON tbl_pais FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_pais_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tbl_prazos_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_prazos_id_seq_tr 

BEFORE INSERT ON tbl_prazos FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_prazos_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tbl_responsaveis_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_responsaveis_id_seq_tr 

BEFORE INSERT ON tbl_responsaveis FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_responsaveis_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tbl_senhasEstaduais_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_senhasEstaduais_id_seq_tr 

BEFORE INSERT ON tbl_senhasEstaduais FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_senhasEstaduais_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tbl_senhasMunicipais_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_senhasMunicipais_id_seq_tr 

BEFORE INSERT ON tbl_senhasMunicipais FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_senhasMunicipais_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tbl_status_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_status_id_seq_tr 

BEFORE INSERT ON tbl_status FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_status_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tbl_uf_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_uf_id_seq_tr 

BEFORE INSERT ON tbl_uf FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_uf_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 
  
