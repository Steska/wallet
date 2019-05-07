<?php

/* @var $this yii\web\View */
/**
 * @var \common\models\Currency[] $currencies
 * @var \common\models\Wallet[] | null $wallets
 */
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Test wallet!</h1>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Rates of crypts</h2>
                <?php foreach ($currencies as $currency){?>
                    <p><?=$currency->short?>: <?=$currency->rate?> <?php if (\Yii::$app->user->identity){?><a href="<?=\yii\helpers\Url::to(['currency/change-status', 'id' => $currency->id])?>"><?=$currency->blocked ? 'Unblock' : 'Block'?></a><?php } ?></p>
                <?php } ?>
                <?php if (\Yii::$app->user->identity){?>
                    <p><a class="btn btn-default" href="<?=\yii\helpers\Url::to(['/currency/update'])?>">Update rates</a></p>
                <?php } ?>

            </div>
            <?php if (\Yii::$app->user->identity){?>
            <div class="col-lg-4">
                <h2>Your wallets</h2>
                <?php foreach ($wallets as $wallet){?>
                <p><?=$wallet->name.' '.$wallet->currency->short?>. Amount <?=!empty($wallet->amount) ? $wallet->amount : 0?>
                    <a href="<?=\yii\helpers\Url::to(['wallet/update', 'id' => $wallet->id])?>">Update wallet</a> <a href="<?=\yii\helpers\Url::to(['transaction/index', 'walletId' => $wallet->id])?>">Show transactions</a></p>
                    <?php if ($wallet->amount > 0){?>
                <?php }?>
                <p>
                <?php }?>

                    <a class="btn btn-default" href="<?=\yii\helpers\Url::to(['wallet/create'])?>">Create new Wallet</a>
                    <a class="btn btn-default" href="<?=\yii\helpers\Url::to(['wallet/exchange'])?>">Exchange crypts from wallets</a>
                </p>
            </div>
            <?php }?>
        </div>

    </div>
</div>
