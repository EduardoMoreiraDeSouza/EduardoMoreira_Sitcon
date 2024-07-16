# EduardoMoreira_Sitcon
Repositório dedicado à realização de um teste

## Configurações da Conexão Com o Banco de Dados:

* Servidor: localhost
* Usuário: root
* Senha:
* Nome do Banco de Dados: teste_sitcon
* Port: 3306

## Estrutura do Banco de Dados:

CREATE DATABASE teste_sitcon;

USE teste_sitcon;

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT,
    nome VARCHAR(40),
    dataNasc DATE,
    cpf VARCHAR(11),
    status VARCHAR(7),

    CONSTRAINT PK_id_pacientes PRIMARY KEY (id),
    CONSTRAINT UC_cpf_pacientes UNIQUE (cpf)

) DEFAULT CHARSET = utf8;

CREATE TABLE profissional (
    id INT AUTO_INCREMENT,
    nome VARCHAR(40),
    status VARCHAR(7),

    CONSTRAINT PK_id_profissional PRIMARY KEY (id)

) DEFAULT CHARSET = utf8;

CREATE TABLE tipoSolicitacao (
    id INT AUTO_INCREMENT,
    descricao VARCHAR(40),
    status VARCHAR(7),

    CONSTRAINT PK_id_tipoSolicitacao PRIMARY KEY (id)

) DEFAULT CHARSET = utf8;

CREATE TABLE procedimentos (
    id INT AUTO_INCREMENT,
    descricao VARCHAR(40),
    tipoSolicitacao_id INT,
    status VARCHAR(7),

    CONSTRAINT PK_id_procedimentos PRIMARY KEY (id),
    CONSTRAINT FK_tipo_id_procedimentos FOREIGN KEY (tipoSolicitacao_id)
    REFERENCES tipoSolicitacao (id) ON DELETE CASCADE ON UPDATE CASCADE

) DEFAULT CHARSET = utf8;

CREATE TABLE profissionalAtende (
    id INT AUTO_INCREMENT,
    procedimento_id INT,
    profissional_id INT,
    status VARCHAR(7),

    CONSTRAINT PK_id_profissionalATende PRIMARY KEY (id),
    CONSTRAINT FK_procedimento_id_profissionalAtende FOREIGN KEY (procedimento_id)
    REFERENCES procedimentos(id) ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT FK_profissional_id_profissionalAtende FOREIGN KEY (profissional_id)
    REFERENCES profissional(id) ON DELETE CASCADE ON UPDATE CASCADE

) DEFAULT CHARSET = utf8;

## Inserção dos Dados:

insert into pacientes (id, nome, dataNasc, CPF, status) values (1,'Augusto Fernandes','20000810', 21029829309, 'ativo');
insert into pacientes (id, nome, dataNasc, CPF, status) values (2,'Maria Silva Oliveira','19990321', 21029829308, '
ativo');
insert into pacientes (id, nome, dataNasc, CPF, status) values (3,'Alfonse Smikchuz','20021002', 21029829307, 'ativo');
insert into pacientes (id, nome, dataNasc, CPF, status) values (4,'Nagela Perreira','19970516', 21029829306, 'ativo');
insert into pacientes (id, nome, dataNasc, CPF, status) values (6,'João Paulo Ferreira','19950626', 21029829305, '
inativo');
insert into pacientes (id, nome, dataNasc, CPF, status) values (5,'Gustavo Hernanes','20010710', 21029829304, 'ativo');
insert into pacientes (id, nome, dataNasc, CPF, status) values (9,'Zira Silva','20030214', 21029829303, 'ativo');
insert into pacientes (id, nome, dataNasc, CPF, status) values (8,'Helena Marques','20000111', 21029829302, 'ativo');
insert into pacientes (id, nome, dataNasc, CPF, status) values (7,'Julio Costa Martins','19801123', 21029829301, '
ativo');
insert into pacientes (id, nome, dataNasc, CPF, status) values (10,'João Bicalho','19930312', 21029829300, 'inativo');
insert into pacientes (id, nome, dataNasc, CPF, status) values (12,'Carolina Rosa Silva','20011224', 21029829390, '
ativo');
insert into pacientes (id, nome, dataNasc, CPF, status) values (11,'Paulina Araujo','20020810', 21029829399, 'ativo');

insert into profissional (id, nome, status) values (1,'Orlando Nobrega', 'ativo');
insert into profissional (id, nome, status) values (2,'Rafaela Tenorio', 'ativo');
insert into profissional (id, nome, status) values (3,'João Paulo Nobrega', 'ativo');

insert into tipoSolicitacao (id, descricao, status) values (1,'Consulta', 'ativo');
insert into tipoSolicitacao (id, descricao, status) values (2,'Exames Laboratoriais', 'ativo');

insert into procedimentos (id, descricao, tipoSolicitacao_id, status) values (1,'Consulta Pediátrica ', 1, 'ativo');
insert into procedimentos (id, descricao, tipoSolicitacao_id, status) values (2,'Consulta Clínico Geral', 1, 'ativo');
insert into procedimentos (id, descricao, tipoSolicitacao_id, status) values (3,'Hemograma', 2, 'ativo');
insert into procedimentos (id, descricao, tipoSolicitacao_id, status) values (4,'Glicemia', 2, 'ativo');
insert into procedimentos (id, descricao, tipoSolicitacao_id, status) values (5,'Colesterol', 2, 'ativo');
insert into procedimentos (id, descricao, tipoSolicitacao_id, status) values (6,'Triglicerídeos', 2, 'ativo');

insert into profissionalAtende (id, procedimento_id, profissional_id, status) values ('0', 1, 2, 'ativo');
insert into profissionalAtende (id, procedimento_id, profissional_id, status) values ('0', 2, 2, 'ativo');
insert into profissionalAtende (id, procedimento_id, profissional_id, status) values ('0', 2, 3, 'ativo');
insert into profissionalAtende (id, procedimento_id, profissional_id, status) values ('0', 1, 3, 'inativo');
insert into profissionalAtende (id, procedimento_id, profissional_id, status) values ('0', 3, 1, 'ativo');
insert into profissionalAtende (id, procedimento_id, profissional_id, status) values ('0', 4, 1, 'ativo');
insert into profissionalAtende (id, procedimento_id, profissional_id, status) values ('0', 5, 1, 'ativo');
insert into profissionalAtende (id, procedimento_id, profissional_id, status) values ('0', 6, 1, 'ativo');


## Herança das classes PHP:

* ConexaoBancoDados
* * ExecutarQueryMysql