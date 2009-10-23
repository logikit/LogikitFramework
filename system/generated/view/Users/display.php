<h1 class="title">Show</h1>
<p><?php echo siteLink(getController() . '/index' , 'Back to list'); ?></p>
<div class="container">
    <div class="row">
                <div class="dungeon tableHeader">
                    Username:
                </div>
                <div class="dungeon">
                    <?php echo $record['username']; ?>
                </div>
                <div class="dungeon validationError" id="usernameValidation">
                    
                </div>
            </div>
    <div class="row">
                <div class="dungeon tableHeader">
                    Password:
                </div>
                <div class="dungeon">
                    <?php echo $record['password']; ?>
                </div>
                <div class="dungeon validationError" id="passwordValidation">
                    
                </div>
            </div>

    
</div>