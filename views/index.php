<h1><?php echo __('Dashboard'); ?></h1>

<form action="<?php echo get_url('plugin/dashboard/clear'); ?>" method="post">
    <table class="dashboardTable" cellpadding="0" cellspacing="0" border="0">
        <thead>
            <tr>
                <th colspan="2"></th>
                <th><?php echo __('What'); ?></th>
                <th class="moment"><?php echo __('When'); ?> <img src="<?php echo PLUGINS_URI; ?>dashboard/img/sort.png" /></th>
            </tr>
        </thead>
        <tbody>
            <?php $entrynum = 0; ?>
            <?php foreach ($log_entries as $entry): ?> 
                <tr class="<?php print odd_even(); ?>">
                    <td class="hidden"><?php echo $entrynum;?></td>
                    <td class="priority"><img src="<?php echo PLUGINS_URI; ?>dashboard/img/<?php print $entry->priority('string') ?>.png" title="<?php print $entry->priority('string') ?>" /></td>
                    <td class="message"><?php print $entry->message ?></td>
                    <td class="date"><a title="<?php print $entry->created_on ?>"><?php print DateDifference::getString(new DateTime($entry->created_on)); ?></a></td>
                </tr>	
            <?php $entrynum = $entrynum + 1; ?>
            <?php endforeach; ?>            
        </tbody>
    </table>

    <p class="buttons">
        <input class="button" name="commit" type="submit" accesskey="c" value="<?php echo __('Clear all'); ?>" />
    </p>
    <br/>

</form>