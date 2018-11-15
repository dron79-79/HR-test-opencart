<?php
require_once DIR_SYSTEM.'library/tool/uploadxml/ProductXMLReader.php';

class ModelToolUploadxml extends Model {
	
    /**
     * Импортируем в базу данных карточки товара из XML файла
     * @param string $url URI адрес источника
     * @param array $params 
     * @return boolean
     */
    public function actionUploadXml($url, $params=[]) {
	ini_set ( 'max_execution_time', 600);
	ini_set ( 'max_input_time', 600); 
	
	
	$pach = $this->getFileXml($url);
	
	$reader = new ProductXMLReader($pach);
	$reader->onEvent('afterParseElement', function($name, $context) {
	    $context->clearResult();
	});
	$reader->onEvent('parseoffer', function($context) {
	    $category_id = '20';
	    $store_id = 0;
	    $layout_id = 2;
	    $attribute_id = 2;
	    $language_id = 1;
	    $offer = $context->getResult()['offer'][0];
	    //print_r($offer);die();
	    
	    $this->db->query("INSERT INTO `" . DB_PREFIX . "product` SET `price` = '" . $this->db->escape($offer['price']) 
		    . "', `model` = '" . $this->db->escape($offer['vendor_code']) . "', `date_added` = NOW()");
	    $product_id = $this->db->getLastId(); // переработать код
	    
	    
	    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_to_store` SET `product_id` = '" . (int)$product_id 
		     . "', `store_id` = '" . $this->db->escape($store_id )."'" );
	  
	    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_to_category` SET `product_id` = '" . (int)$product_id 
		      . "', `category_id` = '" . $this->db->escape($category_id)."'" );
	    
	    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_description` SET `product_id` = '" . (int)$product_id 
		    . "', `name` = '" . $this->db->escape($offer['name'])  
		    . "', `description` = '" . $this->db->escape($offer['description']). "'");
	    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_to_layout` SET `product_id` = '" . (int)$product_id 
		   . "', `store_id` = '" . $this->db->escape($store_id )
		    . "', `layout_id` = '" . $this->db->escape($layout_id)."'" );
	    if (!empty($offer['series'])){
		 $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id 
			 . "', attribute_id = '" . (int)$attribute_id 
			 . "', language_id = '" . (int)$language_id 
			 . "', text = '"  .  $this->db->escape($offer['series']) . "'");
	    }
	   
	    
	});
	    
	    
	// запускаем парсинг
	$reader->parse();
	
	
	return true;
    }
    
    /**
     * Забираем файл к себе
     * @param string $url
     * @return string
     */
    protected function getFileXml($url){
	try{
	    if(!$ch = curl_init() ) throw new Exception('Curl init failed');
        
	    $options = [
		CURLOPT_URL            => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER     => [
		    'User-Agent' => 'Mozilla/5.0 (Windows NT 5.1; rv:34.0) Gecko/20100101 Firefox/34.0'
		]
	    ];
	    curl_setopt_array($ch, $options);
	    $file = curl_exec( $ch );
	    file_put_contents(DIR_DOWNLOAD.'file.xml', $file);
	    return DIR_DOWNLOAD.'file.xml';
 
	} catch(Exception $e){
	    echo $e->getMessage();

	}
    }
        
}