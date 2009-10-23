<?php echo formOpenMultipart('form1' , siteUri(getController() . '/processForm') , 'POST', 'onsubmit=""'); ?>
<h1 class="title">Edit</h1>
<p><?php echo siteLink(getController() . '/index' , 'Back to list'); ?></p>

<div class="container">
    <div class="row">
                <div class="dungeon tableHeader">
                    Title:
                </div>
                <div class="dungeon">
                    <?php echo $formItems['title'];?>
                </div>
                <div class="dungeon validationError" id="titleValidation">
                
                 </div>    
            </div>
    <div class="row">
                <div class="dungeon tableHeader">
                    Entry:
                </div>
                <div class="dungeon">
                    <?php echo $formItems['entry'];?>
                </div>
                <div class="dungeon validationError" id="entryValidation">
                
                 </div>    
            </div>
    <div class="row">
                <div class="dungeon tableHeader">
                    Date:
                </div>
                <div class="dungeon">
                    <?php echo $formItems['date'];?>
                </div>
                <div class="dungeon validationError" id="dateValidation">
                
                 </div>    
            </div>

    
    <div class="row">   
        <div class="dungeon tableHeader">
            <?php echo $formItems['submit1']; ?>
        </div>
    </div>
    
</div>
<?php echo $formItems['id']; ?>
<?php formClose();