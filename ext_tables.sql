#
# Table structure for table 'tx_blog_domain_model_tag'
#
CREATE TABLE tx_blog_domain_model_tag (
  title varchar(255) DEFAULT '' NOT NULL,
  slug varchar(2048) DEFAULT '' NOT NULL,
  description text,
  content text,
);

#
# Table structure for table 'sys_category'
#
CREATE TABLE sys_category (
  record_type int(11) unsigned DEFAULT '1' NOT NULL,
  slug varchar(2048) DEFAULT '' NOT NULL,
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
  authors text,

  KEY post_crdate (crdate_year, crdate_month)
);

#
# Table structure for table 'tx_blog_domain_model_author'
#
CREATE TABLE tx_blog_domain_model_author (
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
  instagram varchar(255) DEFAULT '' NOT NULL,
  profile varchar(255) DEFAULT '' NOT NULL,
  bio text,
  posts text,
  details_page int(11) DEFAULT '0' NOT NULL,
);
