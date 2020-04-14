#
# Table structure for table 'tx_blog_domain_model_tag'
#
CREATE TABLE tx_blog_domain_model_tag (
  uid int(11) NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,
  tstamp int(11) DEFAULT '0' NOT NULL,
  crdate int(11) DEFAULT '0' NOT NULL,
  cruser_id int(11) DEFAULT '0' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  deleted tinyint(4) DEFAULT '0' NOT NULL,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  t3ver_oid int(11) DEFAULT '0' NOT NULL,
  t3ver_id int(11) DEFAULT '0' NOT NULL,
  t3_origuid int(11) DEFAULT '0' NOT NULL,
  t3ver_wsid int(11) DEFAULT '0' NOT NULL,
  t3ver_label varchar(30) DEFAULT '' NOT NULL,
  t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
  t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
  t3ver_count int(11) DEFAULT '0' NOT NULL,
  t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
  t3ver_move_id int(11) DEFAULT '0' NOT NULL,
  sys_language_uid int(11) DEFAULT '0' NOT NULL,
  l18n_parent int(11) DEFAULT '0' NOT NULL,
  l18n_diffsource mediumblob NOT NULL,
  title tinytext,
  slug varchar(2048),
  description text,
  content text,

  PRIMARY KEY (uid),
  KEY parent (pid)
);

#
# Table structure for table 'tx_blog_tag_pages_mm'
#
CREATE TABLE tx_blog_tag_pages_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  sorting_foreign int(11) DEFAULT '0' NOT NULL,

  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'sys_category'
#
CREATE TABLE sys_category (
  record_type int(11) unsigned DEFAULT '1' NOT NULL,
  slug varchar(2048),
  content text,
  posts int(11) DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
  tx_blog_tag_content int(11) DEFAULT '0' NOT NULL,
  tx_blog_category_content int(11) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_blog_domain_model_comment'
#
CREATE TABLE tx_blog_domain_model_comment (
  uid int(11) NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,
  tstamp int(11) DEFAULT '0' NOT NULL,
  crdate int(11) DEFAULT '0' NOT NULL,
  cruser_id int(11) DEFAULT '0' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  deleted tinyint(4) DEFAULT '0' NOT NULL,
  hidden tinyint(4) DEFAULT '0' NOT NULL,

  author int(11) DEFAULT '0' NOT NULL,
  name varchar(100) DEFAULT '' NOT NULL,
  url varchar(255) DEFAULT '' NOT NULL,
  email varchar(255) DEFAULT '' NOT NULL,
  comment text,
  parentid int(11) DEFAULT '0' NOT NULL,
  parenttable varchar(255) DEFAULT '' NOT NULL,
  post_language_id int(11) DEFAULT '0' NOT NULL,
  hp varchar(1) DEFAULT '' NOT NULL,
  status int(11) DEFAULT '0' NOT NULL,

  PRIMARY KEY (uid),
  KEY parent (pid)
);

#
# Table structure for table 'pages'
#
CREATE TABLE pages (
  featured_image int(11) unsigned DEFAULT '0' NOT NULL,
  comments_active tinyint(4) DEFAULT '1' NOT NULL,
  publish_date int(11) DEFAULT '0' NOT NULL,
  archive_date int(11) DEFAULT '0' NOT NULL,
  crdate_month int(11) DEFAULT '0' NOT NULL,
  crdate_year int(11) DEFAULT '0' NOT NULL,
  comments text,
  tags text,
  authors text
);

#
# Table structure for table 'tx_blog_domain_model_author'
#
CREATE TABLE tx_blog_domain_model_author (
  uid int(11) NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,
  tstamp int(11) DEFAULT '0' NOT NULL,
  crdate int(11) DEFAULT '0' NOT NULL,
  cruser_id int(11) DEFAULT '0' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  deleted tinyint(4) DEFAULT '0' NOT NULL,
  hidden tinyint(4) DEFAULT '0' NOT NULL,

  name varchar(100) DEFAULT '' NOT NULL,
  slug varchar(2048),
  title varchar(100) DEFAULT '' NOT NULL,
  website varchar(255) DEFAULT '' NOT NULL,
  email varchar(255) DEFAULT '' NOT NULL,
  location varchar(255) DEFAULT '' NOT NULL,
  image int(11) DEFAULT '0' NOT NULL,
  avatar_provider varchar(255) DEFAULT '' NOT NULL,

  twitter varchar(255) DEFAULT '' NOT NULL,
  linkedin varchar(255) DEFAULT '' NOT NULL,
  xing varchar(255) DEFAULT '' NOT NULL,
  profile varchar(255) DEFAULT '' NOT NULL,

  bio text,
  posts text,
  details_page int(11) DEFAULT '0' NOT NULL,

  PRIMARY KEY (uid),
  KEY parent (pid)
);

#
# Table structure for table 'tx_blog_post_author_mm'
#
CREATE TABLE tx_blog_post_author_mm (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  sorting int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);
