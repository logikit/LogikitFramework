<?php echo formOpenMultipart('form1' , siteUri(getController() . '/processForm') , 'POST', 'onsubmit=""'); ?>
<h1 class="title">Edit</h1>
<p><?php echo siteLink(getController() . '/index' , 'Back to list'); ?></p>

<div class="container">
__ITEMS__
    
    <div class="row">   
        <div class="dungeon tableHeader">
            <?php echo $formItems['submit1']; ?>
        </div>
    </div>
    
</div>
<?php echo $formItems['id']; ?>
<?php formClose();