<?php
use yii\helpers\Html;
?>
<li class="<?= $liClass ?>">
	<?= Html::a($tabTitle." &nbsp;<span class='glyphicon glyphicon-send'></span>", [$url,'ruc' => $ruc, 'onstep' => $onstep,'tocreate' => $tocreate], ['class' => $linkClass." btn btn-success"]) ?>
</li>