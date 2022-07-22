create database otc_control;
grant all on otc_control.* to otc_control@localhost identified by 'ehtpobhkdbnm';

create table otc_list (
	id int not null auto_increment primary key,
	jan bigint,
	class int,
	name varchar(80),
	kana varchar(80),
	size varchar(80),
	purchase_price double(7,2),
	selling_price int,
	tax_include_price int,
	img varchar(50),
	inventory tinyint default 0,
	stock_nums int,
	self_med boolean,
	created datetime,
	modified datetime
);

alter table otc_list add hygiene tinyint default 0 after self_med;

create table otc_class (
	id int not null auto_increment primary key,
	class_name varchar(50)
);

insert into otc_class (class_name) values ("要指導医薬品");
insert into otc_class (class_name) values ("第１類医薬品");
insert into otc_class (class_name) values ("第２類医薬品");
insert into otc_class (class_name) values ("第３類医薬品");
insert into otc_class (class_name) values ("その他");

create table sales_record (
	id int not null auto_increment primary key,
	mg_id int not null,
	otc_id int not null,
	sale_nums int,
	actual_price int,
	created datetime,
	modified datetime
);

create table warehousing (
	id int not null auto_increment primary key,
	date date,
	otc_id int not null,
	enter_nums int,
	actual_price double(7,2),
	created datetime,
	modified datetime
);


alter table otc_list add tax tinyint default 8 after selling_price;


update otc_list set tax_include_price=round(selling_price*(1+tax/100)),modified=now() where class=5


// 20190905

create table wholesale (
	id int not null auto_increment primary key,
	name varchar(255)
);
insert into wholesale (name) values ("e健康ショップ");
insert into wholesale (name) values ("国分ネット卸");
insert into wholesale (name) values ("alf-web");
insert into wholesale (name) values ("order-epi");
insert into wholesale (name) values ("大木");
insert into wholesale (name) values ("その他");

alter table otc_list add wholesale int default 5 after self_med;


// 20201014
create table saleData (
	id int not null auto_increment primary key,
	date date,
	otc_id int not null,
	nums int,
	created datetime,
	modified datetime
);


-- 20210614
alter table warehousing add limit_date date after actual_price;

-- 20210909
alter table otc_list add tokutei_kiki tinyint default 0 after hygiene;
alter table warehousing add lot_no varchar(255) after limit_date;

-- 20210910
alter table saledata add user_name varchar(50) after nums;
alter table saledata add user_address varchar(255) after user_name;
alter table saledata add notes text after user_address;

-- 20220722
create table inventory (
	id int not null auto_increment primary key,
	date date,
	otc_id int not null,
	otc_name varchar(80),
	otc_kana varchar(80),
	otc_size varchar(80),
	otc_purchase_price int,
	otc_selling_price int,
	tax int,
	otc_tax_include_price int,
	otc_self_med tinyint,
	otc_wholesale varchar(20),
	otc_hygine tinyint,
	otc_class_name varchar(10),
	nums int,
	created datetime,
	modified datetime
);

