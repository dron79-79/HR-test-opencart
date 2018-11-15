<?php
require_once DIR_SYSTEM.'library/tool/uploadxml/AbstractXMLReader.php';

class ProductXMLReader extends AbstractXMLReader{
    /*
	Парсит карточки товаров
    */
    protected function parseoffer() {
	
	if($this->reader->nodeType == XMLREADER::ELEMENT && $this->reader->localName == 'offer') {
	    
	    $offer['id'] = $this->reader->getAttribute('id');
	    while (!(($this->reader->nodeType == XMLREADER::END_ELEMENT)&&($this->reader->localName == 'offer'))){
		$this->reader->read();
		
		if($this->parseSimpleElement('price')){
		    $offer['price'] = $this->parseSimpleElement('price');
		}

		if( $this->parseSimpleElement('name')){
		    $offer['name'] = $this->parseSimpleElement('name');
		}
		
		if ($this->parseSimpleElement('description')){
		    $offer['description'] = $this->parseSimpleElement('description');
		}
		
		if($this->parseAttributeElement('param', 'Артикул')){
		    $offer['vendor_code'] = $this->parseAttributeElement('param', 'Артикул');
		}

		if($this->parseAttributeElement('param', 'Серия')) {
		    $offer['series'] = $this->parseAttributeElement('param', 'Серия');
		}

	    }
	   
	    $this->result['offer'][] = $offer;
	}
    }
    
    
    /**
     * Возвращает значение ближайшего заданного по имени элемента
     * @param string $name
     * @return boolean|string
     */
    protected function parseSimpleElement($name) {
		
	if ($this->reader->nodeType == XMLREADER::ELEMENT && $this->reader->localName == $name) {
	    $value = $this->reader->readString();
	    
	    return $value;
	} else {
	    
	    return false;
	}
    }
    
    /**
     * Возвращает значение элемента
     * @param string $element_name
     * @param string $attribute_name
     * @return boolean|string
     */
    protected function parseAttributeElement($element_name, $attribute_name) {
	
	if ($this->reader->nodeType == XMLREADER::ELEMENT 
		&& $this->reader->localName == $element_name 
		&& $this->reader->getAttribute('name') == $attribute_name ) {
	    $value = $this->reader->readString(); 
	    
	    return $value;
	} else {
	    
	    return false;
	}
    }

}
