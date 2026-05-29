CREATE DATABASE IF NOT EXISTS himaprosif;
USE himaprosif;

/*==============================================================*/
/* Table: ANGGOTA                                               */
/*==============================================================*/
create table ANGGOTA
(
   ID_ANGGOTA           char(6) not null,
   NAMA_ANGGOTA         varchar(50),
   JENIS_KELAMIN        char(1),
   ALAMAT               varchar(100),
   TANGGAL_LAHIR        date,
   NO_TELPON            varchar(15),
   EMAIL                varchar(50),
   primary key (ID_ANGGOTA)
);

/*==============================================================*/
/* Table: DEPARTEMEN                                            */
/*==============================================================*/
create table DEPARTEMEN
(
   ID_DEPARTEMEN        char(2) not null,
   NAMA_DEPARTEMEN      varchar(30),
   primary key (ID_DEPARTEMEN)
);

/*==============================================================*/
/* Table: JABATAN                                               */
/*==============================================================*/
create table JABATAN
(
   ID_JABATAN           char(2) not null,
   NAMA_JABATAN         varchar(50),
   primary key (ID_JABATAN)
);

/*==============================================================*/
/* Table: PERIODE                                               */
/*==============================================================*/
create table PERIODE
(
   ID_PERIODE           char(4) not null,
   TAHUN_MULAI          smallint,
   TAHUN_SELESAI        smallint,
   STATUS_AKTIF         smallint,
   primary key (ID_PERIODE)
);

/*==============================================================*/
/* Table: PROGRAM_KERJA                                         */
/*==============================================================*/
create table PROGRAM_KERJA
(
   ID_PROKER            char(5) not null,
   ID_PERIODE           char(4) not null,
   ID_DEPARTEMEN        char(2) not null,
   NAMA_PROKER          varchar(100),
   PENANGGUNG_JAWAB     varchar(100),
   WAKTU_PELAKSANAAN    varchar(50),
   STATUS               varchar(20) not null default 'Belum Terlaksana',
   primary key (ID_PROKER)
);

/*==============================================================*/
/* Table: STRUKTUR_KEPENGURUSAN                                 */
/*==============================================================*/
create table STRUKTUR_KEPENGURUSAN
(
   ID_STRUKTUR          char(8) not null,
   ID_ANGGOTA           char(6) not null,
   ID_DEPARTEMEN        char(2) not null,
   ID_JABATAN           char(2) not null,
   ID_PERIODE           char(4) not null,
   primary key (ID_STRUKTUR)
);

/*==============================================================*/
/* Table: PARTISIPAN                                            */
/*==============================================================*/
create table PARTISIPAN
(
   ID_ANGGOTA           char(6) not null,
   ID_PROKER            char(5) not null,
   ID_PARTISIPASI       char(4) not null,
   PERAN_PADA_PROKER    varchar(20),
   primary key (ID_ANGGOTA, ID_PROKER, ID_PARTISIPASI)
);

alter table PARTISIPAN add constraint FK_BERPARTISIPASI foreign key (ID_PROKER)
      references PROGRAM_KERJA (ID_PROKER) on delete restrict on update restrict;

alter table PARTISIPAN add constraint FK_MENJADI foreign key (ID_ANGGOTA)
      references ANGGOTA (ID_ANGGOTA) on delete restrict on update restrict;

alter table PROGRAM_KERJA add constraint FK_MELAKUKAN foreign key (ID_DEPARTEMEN)
      references DEPARTEMEN (ID_DEPARTEMEN) on delete restrict on update restrict;

alter table PROGRAM_KERJA add constraint FK_SELAMA foreign key (ID_PERIODE)
      references PERIODE (ID_PERIODE) on delete restrict on update restrict;

alter table STRUKTUR_KEPENGURUSAN add constraint FK_BERADA_DI foreign key (ID_ANGGOTA)
      references ANGGOTA (ID_ANGGOTA) on delete restrict on update restrict;

alter table STRUKTUR_KEPENGURUSAN add constraint FK_DIMILIKI foreign key (ID_JABATAN)
      references JABATAN (ID_JABATAN) on delete restrict on update restrict;

alter table STRUKTUR_KEPENGURUSAN add constraint FK_MEMILIKI foreign key (ID_PERIODE)
      references PERIODE (ID_PERIODE) on delete restrict on update restrict;

alter table STRUKTUR_KEPENGURUSAN add constraint FK_MEMPUNYAI foreign key (ID_DEPARTEMEN)
      references DEPARTEMEN (ID_DEPARTEMEN) on delete restrict on update restrict;
