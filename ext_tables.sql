#
# Table structure for table 'tx_slubprofileaccount_domain_model_user'
#
CREATE TABLE tx_slubprofileaccount_domain_model_user (
    uid int(11) unsigned DEFAULT 0 NOT NULL auto_increment,
    pid int(11) DEFAULT 0 NOT NULL,

    account_id varchar(255) NOT NULL,
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
