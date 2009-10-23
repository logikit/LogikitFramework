<?php echo formOpenMultipart('form1' , siteUri(getController() . '/processForm') , 'POST', 'onsubmit=""'); ?>
<h1 class="title">Edit</h1>
<p><?php echo siteLink(getController() . '/index' , 'Back to list'); ?></p>

<div class="container">
    <div class="row">
                <div class="dungeon tableHeader">
                    Username:
                </div>
                <div class="dungeon">
                    <?php echo $formItems['username'];?>
                </div>
                <div class="dungeon validationError" id="usernameValidation">
                
                 </div>    
            </div>
    <div class="row">
                <div class="dungeon tableHeader">
                    Password:
                </div>
                <div class="dungeon">
                    <?php echo $formItems['password'];?>
                </div>
                <div class="dungeon validationError" id="passwordValidation">
                
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