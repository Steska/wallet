<?php
use yii\helpers\Html;
use yii\widgets\ListView;
/**
 * @var \common\models\Wallet $wallet
 * @var \yii\data\ActiveDataProvider $dataProvider
 */
$this->title = 'Wallet: '.$wallet->name.' '.$wallet->currency->short;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <?= ListView::widget(
                [
                    'dataProvider' => $dataProvider,

                    'layout'       => '{items}{pager}',
                    'itemView'     => '_transaction_item',
                ]
            );?>
        </div>
    </div>
</div>
