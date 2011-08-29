<?php if (AuthUser::hasPermission('admin_edit')) { ?>
<p class="button"><a href="#settings"><img src="<?php echo ICONS_URI; ?>settings-32.png" align="middle" alt="page icon" /> <?php echo __('Settings'); ?></a></p>
<?php } ?>
    
<div class="box">
    <h2><?php echo __('Good to know');?></h2>
    <p><?php echo __('By default only the 10 latest entries are shown. However, all entries are loaded so if you sort or search, you do so over all entries.');?></p>
    <p><?php echo __('In other words, if you do nothing else, reversing the sort order will display the oldest 10 entries.');?></p>
    <p>
        <?php echo __('Compatible with Wolf CMS :version', array(':version' => '0.7.2+'));?>
    </p>
</div>
