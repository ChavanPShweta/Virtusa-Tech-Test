<?php

class CheckoutController extends CController {
	public function actionIndex() {
		$this->render( 'index');

	}	

	public function actionGetSpecialPrice() {
		$special_price = 0;
		if (app()->request->isAjaxRequest) {
			$product_sku = app()->request-getPost('product_sku', '');
			$product_quantity = app()->request-getPost('product_quantity', '');
			if( isset($product_sku) && $product_sku != '' ){
            	$model =  Product::model()->findByAttributes(array('sku'=>$product_sku));
				if($model) {
					$rule = false;
					$offer_details = json_decode($model->offer_details, true);
					foreach ($_SESSION["cart_products"] as $product) {
						foreach($offer_details as $data) {
							if($product["sku"] == $data["compare_sku"]) {
								$sku_quantity = $product["quantity"];
								$offer_price = $data["price"];
								$rule = true;
								break 2;
							}
						}
					}
					if($rule && $offer_details) {
						if($product_quantity == $sku_quantity || $product_quantity < $sku_quantity) {
							$special_price = $product_quantity*$offer_price;
						} else {
							$quantity = $product_quantity - $sku_quantity;
							$special_price = $sku_quantity*$offer_price + $quantity*$model->price;
						}
					} else {
						if($offer_details) {
							$offer_price = 0;
							foreach($offer_details as $data) {
								if($product_quantity == $data["quantity"]) {
									$offer_price = $offer_price + $data["price"];
									$product_quantity = $product_quantity - $data["quantity"];
								} else {
									$x = 0;
									while($x=0) {
										if($product_quantity < $data["quantity"]) {
											$x=1;
										} else {
										    $offer_price = $offer_price + $data["price"];
										    $product_quantity = $product_quantity - $data["quantity"];
                                        }
									}
								}
							}
							$normal_price = abs($product_quantity)*$model->price;
							$special_price = $offer_price+$normal_price;
						} else {
							$special_price = $product_quantity*$model->price;
						}
					}
				}
			}
		}
		echo CJSON::encode(array('success' => true, 'error' => '', 'special_price' => $special_price));
        	app()->end();
	}
}

?>