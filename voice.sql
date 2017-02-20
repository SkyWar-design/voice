create table party (
	id int(11) NOT NULL primary key AUTO_INCREMENT,
	month int(11) NOT NULL,
	month_full varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	name  varchar(255) COLLATE utf8_unicode_ci NOT NULL
	);