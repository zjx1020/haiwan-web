create database if not exists fdc default charset utf8 COLLATE utf8_general_ci;
use fdc;
create table if not exists user (
    account varchar(30) not null,
    name varchar(30) not null,
    password varchar(20) not null,
    sex tinyint not null,
    phone varchar(20) not null,
    email varchar(128) not null,
    birth date not null,
    join_date date not null,
    left_count tinyint not null,
    primary key(account)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists dance (
    name varchar(128) not null,
    country varchar(128) not null,
    kind tinyint not null,
    dance_level tinyint not null,
    description text not null,
    dance_count int not null,
    primary key(name)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists activity (
    id int not null auto_increment,
    time date not null,
    name varchar(128) not null,
    address varchar(1024) not null,
    cost int not null,
    income int not null,
    description text not null,
    kind tinyint not null,
    creator varchar(30) not null,
    primary key(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists activity_record (
    id bigint not null auto_increment,
    account varchar(30) not null,
    activity_id int not null,
    time datetime not null,
    primary key(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists pay_record (
    id bigint not null auto_increment,
    account varchar(30) not null,
    time datetime not null,
    money int not null,
    owner varchar(30) not null,
    description text not null,
    primary key(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists dance_record (
    id bigint not null auto_increment,
    dance_name varchar(128) not null,
    activity_id int not null,
    kind tinyint not null COMMENT '0=>联欢舞码，1=>复习舞码，2=>教学舞码',
    teacher varchar(128) not null,
    primary key(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists dance_leader (
    id bigint not null auto_increment,
    dance_name varchar(128) not null,
    account varchar(30) not null,
    time datetime not null,
    primary key(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists country (
    name varchar(128) not null,
    primary key(name)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists role (
    account varchar(30) not null,
    role varchar(30) not null,
    primary key(account),
    foreign key(account) references user(account)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
