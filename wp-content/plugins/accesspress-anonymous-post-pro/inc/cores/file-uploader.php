<?php 
if( ! wp_verify_nonce( $_GET['file_uploader_nonce'],'ap-file-uploader-nonce')) die ('No script kiddies please!');
$allowedExtensions = $_GET['allowedExtensions'];//array('jpg', 'jpeg', 'png', 'gif');
$sizeLimit = $_GET['sizeLimit'];
$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$upload_dir = wp_upload_dir();
$result = $uploader->handleUpload($upload_dir['path'].'/', $replaceOldFile = false,$upload_dir['url']);
echo json_encode($result);