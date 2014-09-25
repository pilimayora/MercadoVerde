CREATE TABLE IF NOT EXISTS `PREFIX_marketplace_seller_product` (

  `id` int(10) unsigned NOT NULL auto_increment,

  `id_seller` int(10) unsigned NOT NULL,

  `price` decimal(20,6) NOT NULL DEFAULT '0.000000',

  `quantity` int(10) NOT NULL DEFAULT '0',

  `product_name` varchar(255) character set utf8 NOT NULL,

  `id_category` int(10) unsigned default 1,
  
  `short_description` text,

  `description` text,

  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ps_id_shop` int(11) NOT NULL,
  `id_shop` int(10) unsigned default 1,

   `date_add` datetime NOT NULL,

  `date_upd` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY  (`id`)

) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `PREFIX_marketplace_seller_product_category` (

  `id` int(10) unsigned NOT NULL auto_increment,

  `id_category` int(10) unsigned default 1,
  
  `id_seller_product` int(10) unsigned NOT NULL,
  
	`is_default` tinyint(1) unsigned NOT NULL DEFAULT 0,

  PRIMARY KEY  (`id`)

) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `PREFIX_marketplace_seller_info` (

	`id` int(10) unsigned NOT NULL auto_increment,

	`business_email` varchar(255) character set utf8 NOT NULL,

	`seller_name` varchar(255) character set utf8 NOT NULL,

	`shop_name` varchar(255) character set utf8 NOT NULL,
  `phone` varchar(32) DEFAULT NULL,
	`fax` varchar(32) DEFAULT NULL,

	

	`address` text,  

	`about_shop` text,

	`facebook_id` varchar(255) character set utf8 NOT NULL,

	`twitter_id` varchar(255) character set utf8 NOT NULL,

	`date_add` date NOT NULL,

	`dateupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

	PRIMARY KEY  (`id`)

) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `PREFIX_marketplace_shop` (

  `id` int(10) unsigned NOT NULL auto_increment,

  `shop_name` varchar(255) character set utf8 NOT NULL,

  `link_rewrite` varchar(255) character set utf8 NOT NULL,

  `id_customer` int(10) unsigned NOT NULL,

  `about_us` text,

  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',

   PRIMARY KEY  (`id`)

) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `PREFIX_marketplace_shop_product` ( 

  `id` int(10) unsigned NOT NULL auto_increment,

  `id_shop` int(10) unsigned NOT NULL,

  `id_product` int(10) unsigned NOT NULL,

  `marketplace_seller_id_product` int(10) unsigned NOT NULL,  

  PRIMARY KEY  (`id`)

) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_marketplace_customer` ( 

  `id` int(10) unsigned NOT NULL auto_increment,

  `marketplace_seller_id` int(10) unsigned NOT NULL,

  `id_customer` int(10) unsigned NOT NULL,

  `is_seller` tinyint(1) unsigned NOT NULL DEFAULT '0',

   PRIMARY KEY  (`id`)

) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_marketplace_product_image` (

  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,

  `seller_product_id` int(10) NOT NULL,

  `seller_product_image_id` varchar(15) NOT NULL,

  `active` tinyint(1) NOT NULL DEFAULT '0',

   PRIMARY KEY  (`id`)

) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `PREFIX_marketplace_commision` (

  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,

  `commision` int(10) NOT NULL,

  `customer_id` int(10) NOT NULL,

  `customer_name` varchar(255) NOT NULL,

   PRIMARY KEY  (`id`)

) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;





CREATE TABLE IF NOT EXISTS `PREFIX_marketplace_commision_calc` (

  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,

  `product_id` int(10) NOT NULL,

  `customer_id` int(10) NOT NULL,

  `customer_name` varchar(255) NOT NULL,

  `product_name` varchar(255) NOT NULL,

  `price` int(10) NOT NULL,

  `quantity` int(10) NOT NULL,

  `commision` float(10) NOT NULL,

  `id_order` bigint(10) NOT NULL,

  `date_add` DATETIME NOT NULL,

   PRIMARY KEY  (`id`)

) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `PREFIX_marketplace_payment_mode` (

  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,

  `payment_mode` varchar(255) NOT NULL,

  
   PRIMARY KEY  (`id`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `PREFIX_marketplace_customer_payment_detail` (

  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `id_customer` bigint(100) unsigned NOT NULL,

  `payment_mode_id` bigint(100) unsigned NOT NULL,
  
  `payment_detail` varchar(255) NOT NULL,
  
   PRIMARY KEY  (`id`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `PREFIX_customer_query` (

`id` bigint(100) unsigned NOT NULL auto_increment,
`id_product` int(11),
`title` varchar(1000),
`id_customer` int(11),
`id_customer_to` int(11),
`description` text,
`cust_email` varchar(1000),
`status` tinyint(1) NOT NULL DEFAULT '0',
`timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',

 PRIMARY KEY  (`id`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_query_records` (

`id` bigint(100) unsigned NOT NULL auto_increment,
`from` int(11),
`to` int(11),
`description` text,
`id_query` int(11),


PRIMARY KEY  (`id`)
)ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_seller_reviews` (

`id_review` bigint(100) unsigned NOT NULL auto_increment,
`id_seller` int(11),
`id_customer` int(11),
`customer_email` varchar(100),
`rating` int(11),
`review` text,
`timestamp` timestamp NOT NULL DEFAULT current_timestamp,
`active` tinyint(1),


PRIMARY KEY  (`id_review`)
)ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;
