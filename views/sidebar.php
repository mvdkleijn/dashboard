<?php if (AuthUser::hasPermission('admin_edit')) { ?>
<p class="button"><a href="#settings"><img src="<?php echo ICONS_URI; ?>settings-32.png" align="middle" alt="page icon" /> <?php echo __('Settings'); ?></a></p>
<?php } ?>
    
<div class="box">
    <h2>Notes</h2>
    <p>
        By default only the latest 10 entries are shown. If you sort or search however,
        you do so over all entries that exist.
    </p>
    <p>
        In other words, if you do nothing else, reversing the sort order will display the
        oldest 10 entries.
    </p>
    <p>
        Compatible with Wolf CMS 0.7.2+
    </p>
</div>
