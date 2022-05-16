--
-- Table structure for table `product`
--


CREATE TABLE IF NOT EXISTS `product` (
`id` int(10) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`sku` varchar(100) NOT NULL,
`image` varchar(255) NOT NULL,
`price` double(10,2) NOT NULL,
`offer_details` JSON,
`status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active | 0=Inactive',
`created_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE KEY `sku` (`sku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



/* offer_details column will contain data in JSON format

Example for SKU "A":
{
	["quantity":"3","price":"130"],
};
Example for SKU "C":	here we will insert the data in descending order with respect to quantity
{
	["quantity":"3","price":"50"],
	["quantity":"2","price":"38"],
}
Example for SKU "D":
{
	["compare_sku":"A","price":"5"],
};

Instead of using JSON format here, we can add a new child table or offer_details/rules of offer

CREATE TABLE IF NOT EXISTS `product_offer_details` (
`id` int(10) NOT NULL AUTO_INCREMENT,
`product_id` int(10) NOT NULL,
`compare_sku` varchar(100),
`quantity` int(10),
`price` double(10,2),
`status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active | 0=Inactive',
`created_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

*/