<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
 <!-- $file = "/hris/backend/web/file/file/; -->
<br/>
<?php 
if($extension == "jpeg" || $extension == "jpg" || $extension == "png")
{
	echo Html::img(Url::base()."/uploads/file_attached/".$file, ['alt'=>'images','class'=>'img-responsive']);
}
else
{
?>
	<iframe src="<?= Url::base()."/uploads/file_attached/".$file ?>" style="width: 100%; height: 650px;"></iframe>
<?php 
}
?>


