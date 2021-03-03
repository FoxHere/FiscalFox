PRAGMA foreign_keys=OFF; 

CREATE TABLE tbl_cidades( 
      id  INTEGER    NOT NULL  , 
      cidades varchar  (100)   NOT NULL  , 
      uf_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(uf_id) REFERENCES tbl_uf(id)); 

 CREATE TABLE tbl_empresa( 
      id  INTEGER    NOT NULL  , 
      empresa varchar  (50)   NOT NULL    DEFAULT 'VIVARA', 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_lojas( 
      id  INTEGER    NOT NULL  , 
      empresa_id int   NOT NULL  , 
      status_id int   NOT NULL  , 
      numCapta varchar  (20)   NOT NULL  , 
      loja varchar  (20)   , 
      uf_id int   NOT NULL  , 
      endereco varchar  (60)   , 
      cidades_id int   NOT NULL  , 
      cep varchar  (20)     DEFAULT '00000-000', 
      shopping varchar  (30)   , 
      cnpj varchar  (30)   NOT NULL  , 
      inscEstadual varchar  (30)   , 
      inscMunicipal varchar  (30)   , 
      nire varchar  (30)   , 
      responsavel_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(status_id) REFERENCES tbl_status(id),
FOREIGN KEY(cidades_id) REFERENCES tbl_cidades(id),
FOREIGN KEY(empresa_id) REFERENCES tbl_empresa(id),
FOREIGN KEY(responsavel_id) REFERENCES tbl_responsaveis(id),
FOREIGN KEY(uf_id) REFERENCES tbl_uf(id)); 

 CREATE TABLE tbl_pais( 
      id  INTEGER    NOT NULL  , 
      pais varchar  (50)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_prazos( 
      id  INTEGER    NOT NULL  , 
      uf_id int   NOT NULL  , 
      data_icms varchar  (20)   NOT NULL  , 
      data_iss varchar  (20)   NOT NULL  , 
      data_fecop varchar  (20)   , 
      data_difal varchar  (20)   , 
      data_antecipado varchar  (20)   , 
      data_sped varchar  (20)   , 
      data_declaracao varchar  (20)   NOT NULL  , 
      ciap varchar  (20)   , 
 PRIMARY KEY (id),
FOREIGN KEY(uf_id) REFERENCES tbl_uf(id)); 

 CREATE TABLE tbl_responsaveis( 
      id  INTEGER    NOT NULL  , 
      responsavel varchar  (50)   NOT NULL  , 
      re varchar  (20)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_senhasEstaduais( 
      id  INTEGER    NOT NULL  , 
      loja_id int   NOT NULL  , 
      uf_id int   NOT NULL  , 
      login varchar  (50)   NOT NULL  , 
      senha varchar  (80)   NOT NULL  , 
      local varchar  (250)   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(loja_id) REFERENCES tbl_lojas(id),
FOREIGN KEY(uf_id) REFERENCES tbl_uf(id)); 

 CREATE TABLE tbl_senhasMunicipais( 
      id  INTEGER    NOT NULL  , 
      loja_id int   NOT NULL  , 
      uf_id int   NOT NULL  , 
      cidades_id int   NOT NULL  , 
      login varchar  (50)   NOT NULL  , 
      senha varchar  (80)   NOT NULL  , 
      local varchar  (250)   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(loja_id) REFERENCES tbl_lojas(id),
FOREIGN KEY(uf_id) REFERENCES tbl_uf(id),
FOREIGN KEY(cidades_id) REFERENCES tbl_cidades(id)); 

 CREATE TABLE tbl_status( 
      id  INTEGER    NOT NULL  , 
      status varchar  (50)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_uf( 
      id  INTEGER    NOT NULL  , 
      uf varchar  (4)   NOT NULL  , 
      pais_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(pais_id) REFERENCES tbl_pais(id)); 

  
 
  
