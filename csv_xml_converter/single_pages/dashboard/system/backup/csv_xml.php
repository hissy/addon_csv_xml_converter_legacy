<?php    defined('C5_EXECUTE') or die("Access Denied.");?>

<form action="<?php echo $view->action('convert')?>" method="post" class="form-horizontal">

    <?php echo $token->output('convert')?>
    <fieldset>
        <legend><?php    echo t('Select CSV file to convert XML'); ?></legend>
        <div class="control-group">
            <?php echo $form->label('fID', t('Select CSV File')); ?>
            <div class="controls">
                <?php $al = Core::make('helper/concrete/asset_library'); ?>
                <?php echo $al->file('fID', 'fID', 'Select File', $f); ?>
            </div>
        </div>
    </fieldset>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <input type="submit" name="submit" value="<?php    echo t('Convert')?>" class="btn btn-primary pull-right" />
        </div>
    </div>

</form>
