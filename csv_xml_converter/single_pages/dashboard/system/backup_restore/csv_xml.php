<?php	defined('C5_EXECUTE') or die("Access Denied.");?>

<?php	echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Convert to XML from CSV'), false, 'span10 offset1', false)?>

<form action="<?php echo $this->action('convert')?>" method="post" class="form-horizontal">
	
	<?php echo Loader::helper('validation/token')->output('convert')?>
	<div class="ccm-pane-body">
		<fieldset>
			<legend><?php	echo t('Select CSV file to convert XML'); ?></legend>
			<div class="control-group">
				<?php echo $form->label('fID', t('Select CSV File')); ?>
				<div class="controls">
					<?php $al = Loader::helper('concrete/asset_library'); ?>
					<?php echo $al->file('fID', 'fID', 'Select File', $f); ?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="ccm-pane-footer">
		<input type="submit" name="submit" value="<?php	echo t('Convert')?>" class="ccm-button-right primary btn" />
	</div>
	
</form>

<?php	echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false)?>
