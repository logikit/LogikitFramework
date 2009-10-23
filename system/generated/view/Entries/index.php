<h1 class="title">Entries</h1>
<p><?php echo siteLink(getController() . '/edit' , 'New');?>
</p>
<div class="container">
    <div class="row">
        <div class="dungeon tableHeader">
                    Title
                </div>
        <div class="dungeon tableHeader">
                    Entry
                </div>
        <div class="dungeon tableHeader">
                    Date
                </div>

    </div>
<?php foreach($recordSet as $record): ?>
    <div class="row">
        <div class="dungeon">
                    <?php echo $record['title']; ?>
                </div>
        <div class="dungeon">
                    <?php echo $record['entry']; ?>
                </div>
        <div class="dungeon">
                    <?php echo $record['date']; ?>
                </div>

        <div class="dungeon">
            <?php echo siteLink(getController() . '/display/id/' . $record['id'] , 'Display'); ?> |
            <?php echo siteLink(getController() . '/edit/id/' . $record['id'] , 'Edit'); ?> |
            <?php echo siteLink(getController() . '/delete/id/' . $record['id'] , 'Delete'); ?>
        </div>
    </div>

<?php endforeach; ?>
</div>