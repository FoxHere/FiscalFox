CREATE TABLE tbl_cidades( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      cidades varchar  (100)   NOT NULL  , 
      uf_id int   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_empresa( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      empresa varchar  (50)   NOT NULL    DEFAULT 'VIVARA', 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_lojas( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
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
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_pais( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      pais varchar  (50)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_prazos( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      uf_id int   NOT NULL  , 
      data_icms varchar  (20)   NOT NULL  , 
      data_iss varchar  (20)   NOT NULL  , 
      data_fecop varchar  (20)   , 
      data_difal varchar  (20)   , 
      data_antecipado varchar  (20)   , 
      data_sped varchar  (20)   , 
      data_declaracao varchar  (20)   NOT NULL  , 
      ciap varchar  (20)   , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_responsaveis( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      responsavel varchar  (50)   NOT NULL  , 
      re varchar  (20)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_senhasEstaduais( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      loja_id int   NOT NULL  , 
      uf_id int   NOT NULL  , 
      login varchar  (50)   NOT NULL  , 
      senha varchar  (80)   NOT NULL  , 
      local varchar  (250)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_senhasMunicipais( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      loja_id int   NOT NULL  , 
      uf_id int   NOT NULL  , 
      cidades_id int   NOT NULL  , 
      login varchar  (50)   NOT NULL  , 
      senha varchar  (80)   NOT NULL  , 
      local varchar  (250)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_status( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      status varchar  (50)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE tbl_uf( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      uf varchar  (4)   NOT NULL  , 
      pais_id int   NOT NULL  , 
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

  
