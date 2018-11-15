<?php
class ControllerToolUploadxml extends Controller {

    public function index() {

	$data['success'] = '';
	$data['error_warning'] = '';
	
	if (isset($this->request->get['link_xml'])) {
	    $this->load->model('tool/uploadxml');
	    $link_xml = $this->request->get['link_xml'];
	    $upload_info = $this->model_tool_uploadxml->actionUploadXml($link_xml, []);
	    if ($upload_info) {
		$data['success'] = 'Complete!';
	    } else {
		$data['error_warning'] = 'Error';
	    }
	   
	} else {
	    $link_xml = null;
	}

	$this->load->language('tool/uploadxml');

	$this->document->setTitle($this->language->get('heading_title'));

	$data['heading_title'] = $this->language->get('heading_title');
	$data['breadcrumbs'] = array();
	$data['breadcrumbs'][] = array(
	    'text' => $this->language->get('text_home'),
	    'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
	);

	$data['breadcrumbs'][] = array(
	    'text' => $this->language->get('heading_title'),
	    'href' => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], true)
	);

	
	$data['loading_product'] = $this->language->get('loading_product');
	$data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');
	$data['link_to_xml'] = $this->language->get('link_to_xml');
	$data['button_load'] = $this->language->get('button_load');
	$data['token'] = $this->session->data['token'];
	$this->response->setOutput($this->load->view('tool/uploadxml', $data));
    }

    

}
