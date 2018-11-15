<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-upload').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if (!empty($error_warning)) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if (!empty($success)) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $loading_product; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $link_to_xml; ?></label>
                <input type="text" name="link_xml" value="" placeholder="<?php echo $link_to_xml; ?>" id="input-name" class="form-control" />
              
	      </div>
		<button type="button" id="button-start" class="btn btn-primary pull-right"><?php echo $button_load; ?></button>
            </div>
            </div>
        </div>
        </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-start').on('click', function() {
	url = 'index.php?route=tool/uploadxml&token=<?php echo $token; ?>';
	
	var link_xml = $('input[name=\'link_xml\']').val();
	
	if (link_xml) {
		url += '&link_xml=' + encodeURIComponent(link_xml);
	}
		
	location = url;
});
//--></script> 
  </div>
<?php echo $footer; ?>