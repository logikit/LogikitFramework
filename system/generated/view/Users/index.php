<h1 class="title">Users</h1>
<p><?php echo siteLink(getController() . '/edit' , 'New');?>
</p>
<div class="container">
    <div class="row">
        <div class="dungeon tableHeader">
                    Username
                </div>
        <div class="dungeon tableHeader">
                    Password
                </div>

    </div>
<?php foreach($recordSet as $record): ?>
    <div class="row">
        <div class="dungeon">
                    <?php echo $record['username']; ?>
                </div>
        <div class="dungeon">
                    <?php echo $record['password']; ?>
                </div>

        <div class="dungeon">
            <?php echo siteLink(getController() . '/display/id/' . $record['id'] , 'Display'); ?> |
            <?php echo siteLink(getController() . '/edit/id/' . $record['id'] , 'Edit'); ?> |
            <?php echo siteLink(getController() . '/delete/id/' . $record['id'] , 'Delete'); ?>
        </div>
    </div>

<?php endforeach; ?>
</div>