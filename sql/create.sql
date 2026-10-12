drop database if exists inscription;

create database inscription character set utf8mb4 collate utf8mb4_unicode_ci;

use inscription;

create table etat
(
    id      tinyint unsigned not null,
    libelle varchar(40)      not null,
    constraint pk_etat primary key (id)
) engine=innodb;

create table dossier
(
    id               int unsigned auto_increment,
    nom              varchar(20) not null,
    prenom           varchar(20) not null,
    sexe             varchar(1)  not null,
    nom_responsable   varchar(40) not null,
    titre_responsable varchar(10) not null,
    rue_responsable   varchar(40) not null,
    cp_responsable    varchar(5)  not null,
    ville_responsable varchar(25) not null,
    date_inscription  date        not null,
    date_relance      date  default null,
    id_etat           tinyint unsigned not null default 0,
    constraint pk_dossier primary key (id),
    constraint fk_dossier_etat foreign key (id_etat) references etat (id)
) engine=innodb;

create table piece
(
    id      int unsigned auto_increment,
    libelle mediumtext not null,
    constraint pk_papier primary key (id)
) engine=innodb;

create table piece_manquante
(
    id_dossier  int unsigned,
    id_piece    int unsigned,
    constraint pk_manquer primary key (id_dossier, id_piece),
    constraint fk_manquer_dossier foreign key (id_dossier) references dossier (id) on delete cascade,
    constraint fk_manquer_papier foreign key (id_piece) references piece (id) on delete cascade
) engine=innodb;