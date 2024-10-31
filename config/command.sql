create database otc_control;
grant all on otc_control.* to otc_control@localhost identified by 'ehtpobhkdbnm';

-- 2024/10/28
grant all on otc_control.* to otc_control_user@localhost identified by 'ehtpobhkdbnm';



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


-- 20240423
create table category (
	id int not null auto_increment primary key,
	otc_48_id int,
	cat_name varchar(100),
	subcat_name varchar(100)
);

insert into category (otc_48_id, cat_name, subcat_name) values (1, "精神神経用薬", "かぜ薬（内用）");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "精神神経用薬", "かぜ薬（外用）");
insert into category (otc_48_id, cat_name, subcat_name) values (2, "精神神経用薬", "解熱鎮痛薬");
insert into category (otc_48_id, cat_name, subcat_name) values (3, "精神神経用薬", "催眠鎮静薬");
insert into category (otc_48_id, cat_name, subcat_name) values (4, "精神神経用薬", "眠気防止薬");
insert into category (otc_48_id, cat_name, subcat_name) values (5, "精神神経用薬", "鎮うん薬（乗物酔防止薬，つわり用薬を含む）");
insert into category (otc_48_id, cat_name, subcat_name) values (6, "精神神経用薬", "小児鎮静薬（小児五疳薬等）");
insert into category (otc_48_id, cat_name, subcat_name) values (7, "精神神経用薬", "その他の精神神経用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (8, "消化器官用薬", "ヒスタミンＨ２受容体拮抗剤含有薬");
insert into category (otc_48_id, cat_name, subcat_name) values (9, "消化器官用薬", "制酸薬");
insert into category (otc_48_id, cat_name, subcat_name) values (10, "消化器官用薬", "健胃薬");
insert into category (otc_48_id, cat_name, subcat_name) values (11, "消化器官用薬", "整腸薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "消化器官用薬", "消化薬");
insert into category (otc_48_id, cat_name, subcat_name) values (12, "消化器官用薬", "制酸・健胃・消化・整腸を２以上標榜するもの");
insert into category (otc_48_id, cat_name, subcat_name) values (13, "消化器官用薬", "胃腸鎮痛鎮けい薬");
insert into category (otc_48_id, cat_name, subcat_name) values (14, "消化器官用薬", "止瀉薬");
insert into category (otc_48_id, cat_name, subcat_name) values (15, "消化器官用薬", "瀉下薬（下剤）");
insert into category (otc_48_id, cat_name, subcat_name) values (16, "消化器官用薬", "浣腸薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "消化器官用薬", "駆虫薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "消化器官用薬", "その他の消化器官用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (17, "循環器・血液用薬", "強心薬（センソ含有製剤等）");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "循環器・血液用薬", "血管補強薬");
insert into category (otc_48_id, cat_name, subcat_name) values (18, "循環器・血液用薬", "動脈硬化用薬（リノール酸，レシチン主薬製剤等）");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "循環器・血液用薬", "貧血用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (19, "循環器・血液用薬", "その他の循環器・血液用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (20, "呼吸器官用薬", "鎮咳去痰薬");
insert into category (otc_48_id, cat_name, subcat_name) values (21, "呼吸器官用薬", "含嗽薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "呼吸器官用薬", "その他の呼吸器官用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (22, "泌尿生殖器官及び肛門用薬", "内用痔疾用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (22, "泌尿生殖器官及び肛門用薬", "外用痔疾用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (23, "泌尿生殖器官及び肛門用薬", "その他の泌尿生殖器官及び肛門用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミンＡ主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミンＤ主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミンＥ主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミンＢ１主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミンＢ２主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミンＢ６主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミンＣ主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミンＡＤ主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミンＢ２Ｂ６主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミンＥＣ主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミンＢ１Ｂ６Ｂ12主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "ビタミン含有保健薬（ビタミン剤等）");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "カルシウム主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "タンパク・アミノ酸主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "生薬主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (24, "滋養強壮保健薬", "薬用酒");
insert into category (otc_48_id, cat_name, subcat_name) values (25, "滋養強壮保健薬", "その他の滋養強壮保健薬");
insert into category (otc_48_id, cat_name, subcat_name) values (26, "女性用薬", "婦人薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "女性用薬", "避妊薬");
insert into category (otc_48_id, cat_name, subcat_name) values (27, "女性用薬", "その他の女性用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (28, "アレルギー用薬", "抗ヒスタミン薬主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (29, "アレルギー用薬", "その他のアレルギー用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (30, "外皮用薬", "殺菌消毒薬（特殊絆創膏を含む）");
insert into category (otc_48_id, cat_name, subcat_name) values (31, "外皮用薬", "しもやけ・あかぎれ用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (32, "外皮用薬", "化膿性疾患用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (33, "外皮用薬", "鎮痛・鎮痒・収れん・消炎薬（パップ剤を含む）");
insert into category (otc_48_id, cat_name, subcat_name) values (34, "外皮用薬", "みずむし・たむし用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (35, "外皮用薬", "皮膚軟化薬（吸出しを含む）");
insert into category (otc_48_id, cat_name, subcat_name) values (36, "外皮用薬", "毛髪用薬（発毛，養毛，ふけ，かゆみ止め用薬等）");
insert into category (otc_48_id, cat_name, subcat_name) values (37, "外皮用薬", "その他の外皮用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (38, "眼科用薬", "一般点眼薬");
insert into category (otc_48_id, cat_name, subcat_name) values (39, "眼科用薬", "抗菌性点眼薬");
insert into category (otc_48_id, cat_name, subcat_name) values (40, "眼科用薬", "アレルギー用点眼薬");
insert into category (otc_48_id, cat_name, subcat_name) values (38, "眼科用薬", "人工涙液");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "眼科用薬", "コンタクトレンズ装着液");
insert into category (otc_48_id, cat_name, subcat_name) values (38, "眼科用薬", "洗眼薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "眼科用薬", "その他の眼科用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (41, "耳鼻科用薬", "鼻炎用内服薬");
insert into category (otc_48_id, cat_name, subcat_name) values (41, "耳鼻科用薬", "鼻炎用点鼻薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "耳鼻科用薬", "点耳薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "耳鼻科用薬", "その他の耳鼻科用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (42, "歯科口腔用薬", "口腔咽喉薬（せき，たんを標榜しないトローチ剤を含む）");
insert into category (otc_48_id, cat_name, subcat_name) values (43, "歯科口腔用薬", "口内炎用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (44, "歯科口腔用薬", "歯痛・歯槽膿漏薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "歯科口腔用薬", "その他の歯科口腔用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (45, "禁煙補助剤", "禁煙補助剤");
insert into category (otc_48_id, cat_name, subcat_name) values (46, "漢方製剤", "漢方製剤（210処方）");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "漢方製剤", "その他の漢方製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "生薬製剤（他の薬効群に属さない製剤）", "生薬製剤（他の薬効群に属さない製剤）");
insert into category (otc_48_id, cat_name, subcat_name) values (47, "公衆衛生用薬", "消毒薬");
insert into category (otc_48_id, cat_name, subcat_name) values (48, "公衆衛生用薬", "殺虫薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "一般用検査薬", "一般用検査薬（尿糖・尿タンパク）");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "一般用検査薬", "一般用検査薬（妊娠検査）");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "その他（いずれの薬効群にも属さない製剤）", "その他（いずれの薬効群にも属さない製剤）");

alter table otc_list add category_id int after tokutei_kiki;

-- 追加カテゴリ
insert into category (otc_48_id, cat_name, subcat_name) values (null, "消化器官用薬", "消化器官用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "滋養強壮保健薬", "ビタミン主薬製剤");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "外皮用薬", "抗ウイルス薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "眼科用薬", "眼科用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "公衆衛生用薬", "殺そ薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "公衆衛生用薬", "その他の公衆衛生用薬");
insert into category (otc_48_id, cat_name, subcat_name) values (null, "一般用検査薬", "その他の一般検査薬");





-- 2024/10/29 編集の履歴を残すためのテーブル
create table nums_change_log (
	id int not null auto_increment primary key,
	otc_id int not null,
	old_nums int,
	new_nums int,
	memo text,
	created datetime,
	modified datetime
);

