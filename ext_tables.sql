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
  title tinytext,
  description text,
  content text,

  PRIMARY KEY (uid),
  KEY parent (pid)
);

#
# Table structure for table 'sys_category'
#
CREATE TABLE sys_category (
  content text
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

  PRIMARY KEY (uid),
  KEY parent (pid)
);

#
# Table structure for table 'pages'
#
CREATE TABLE pages (
  comments_active tinyint(4) DEFAULT '1' NOT NULL,
  comments text
);

#
# Table structure for table 'pages_language_overlay'
#
CREATE TABLE pages_language_overlay (
  comments_active tinyint(4) DEFAULT '1' NOT NULL,
  comments text
);

