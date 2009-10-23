<h1 class="title">Show</h1>
<p><?php echo siteLink(getController() . '/index' , 'Back to list'); ?></p>
<div class="container">
    <div class="row">
                <div class="dungeon tableHeader">
                    Title:
                </div>
                <div class="dungeon">
                    <?php echo $record['title']; ?>
                </div>
                <div class="dungeon validationError" id="titleValidation">
                    
                </div>
            </div>
    <div class="row">
                <div class="dungeon tableHeader">
                    Entry:
                </div>
                <div class="dungeon">
                    <?php echo $record['entry']; ?>
                </div>
                <div class="dungeon validationError" id="entryValidation">
                    
                </div>
            </div>
    <div class="row">
                <div class="dungeon tableHeader">
                    Date:
                </div>
                <div class="dungeon">
                    <?php echo $record['date']; ?>
                </div>
                <div class="dungeon validationError" id="dateValidation">
                    
                </div>
            </div>

    
</div>