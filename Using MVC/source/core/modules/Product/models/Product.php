<?php

/**
 * This is the model class for table "product".
 */

class Product extends CFormModel {

	public function rules()
    	{
        	return array(
            		array('name, sku, image, price', 'required'),
			array('sku', 'length', 'max'=>100),
			array('name, image', 'length', 'max'=>255),
			array('creation_datetime, updated_datetime', 'safe'),
			array('creation_datetime','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
            		array('updated_datetime','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			// The following rule is used by search().
            		// Please remove those attributes that should not be searched.
            		array('id, connection_type, tax_id, tax_name, tax_description, country, creation_datetime, last_update', 'safe', 'on'=>'search'),
    		);
    	}
}

?>