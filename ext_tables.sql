#
# Table structure for table 'tx_slubprofileaccount_domain_model_user'
#
CREATE TABLE tx_slubprofileaccount_domain_model_user (
    uid int(11) unsigned DEFAULT 0 NOT NULL auto_increment,
    pid int(11) DEFAULT 0 NOT NULL,

    account_id varchar(255) NOT NULL,
    search_query int(11) unsigned DEFAULT 0 NOT NULL,
    dashboard_widgets text,

    tstamp int(11) unsigned DEFAULT 0 NOT NULL,
    crdate int(11) unsigned DEFAULT 0 NOT NULL,
    deleted tinyint(4) unsigned DEFAULT 0 NOT NULL,
    hidden tinyint(4) unsigned DEFAULT 0 NOT NULL,
    sys_language_uid int(11) DEFAULT 0 NOT NULL,
    l18n_parent int(11) DEFAULT 0 NOT NULL,
    l18n_diffsource mediumblob NOT NULL,
    fe_group int(11) DEFAULT 0 NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid),
);

#
# Table structure for table 'tx_slubprofileaccount_domain_model_searchquery'
#
CREATE TABLE tx_slubprofileaccount_domain_model_searchquery (
    uid int(11) unsigned DEFAULT 0 NOT NULL auto_increment,
    pid int(11) DEFAULT 0 NOT NULL,

    title varchar(255) NOT NULL,
    type varchar(255) NOT NULL,
    user int(11) unsigned DEFAULT 0 NOT NULL,
    query text,

    tstamp int(11) unsigned DEFAULT 0 NOT NULL,
    crdate int(11) unsigned DEFAULT 0 NOT NULL,
    deleted tinyint(4) unsigned DEFAULT 0 NOT NULL,
    hidden tinyint(4) unsigned DEFAULT 0 NOT NULL,
    sys_language_uid int(11) DEFAULT 0 NOT NULL,
    l18n_parent int(11) DEFAULT 0 NOT NULL,
    l18n_diffsource mediumblob NOT NULL,
    fe_group int(11) DEFAULT 0 NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid),
);

#
# Table structure for table 'tx_slubprofileaccount_domain_model_user_mm'
#
CREATE TABLE tx_slubprofileaccount_domain_model_user_mm (
    uid int(11) AUTO_INCREMENT NOT NULL,
    uid_local int(11) NOT NULL DEFAULT '0',
    uid_foreign int(11) NOT NULL DEFAULT '0',
    sorting int(11) NOT NULL DEFAULT '0',
    sorting_foreign int(11) NOT NULL DEFAULT '0',
    tablenames varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',

    PRIMARY KEY (uid)
);
