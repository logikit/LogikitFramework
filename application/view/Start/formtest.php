<?php echo formOpenMultipart('form1' , siteUri('Controlpanel/processForm') , 'POST', 'onsubmit="return false;"'); ?>
    <div class="container">
        <div class="row">
            <div class="dungeon">
            Name:
            </div>
            <div class="dungeon">
            <?php echo $formItems['name']; ?>
            </div>
            <div id="nameValidation" class="dungeon validationError" name="nameValidation">
                
            </div>
        </div>
        
        <div class="row">
            <div class="dungeon">
            Age:
            </div>
            <div class="dungeon">
            <?php echo $formItems['age']; ?>
            </div>
            <div id="ageValidation" class="dungeon validationError" name="ageValidation">
                
            </div>
        </div>
        
        <div class="row">
            <div class="dungeon">
            Notes:
            </div>
            <div class="dungeon">
            <?php echo $formItems['notes']; ?>
            </div>
            <div id="notesValidation" class="dungeon validationError" name="notesValidation">
                
            </div>
        </div>
        
        <div class="row">
            <div class="dungeon">
            Gender:
            </div>
            <div class="dungeon">
            <?php echo $formItems['gender']; ?>
            </div>
            <div id="genderValidation" class="dungeon validationError" name="genderValidation">
                
            </div>
        </div>
        
        <div class="row">
            <div class="dungeon">
            File:
            </div>
            <div class="dungeon">
            <?php echo $formItems['file1']; ?>
            </div>
            <div id="file1Validation" class="dungeon validationError" name="file1Validation">
                
            </div>
        </div>
        
        <div class="row">
            <div class="dungeon">
            Like to dance?
            </div>
            <div class="dungeon">
            <?php echo $formItems['likeToDance']; ?>
            </div>
            <div id="likeToDanceValidation" class="dungeon validationError" name="likeToDanceValidation">
                
            </div>
        </div>
        
        <div class="row">
            <div class="dungeon">
            a button
            </div>
            <div class="dungeon">
            <?php echo $formItems['button1']; ?>
            </div>
        </div>
        
        <div class="row">
            <div class="dungeon">
            a date picker
            </div>
            <div class="dungeon">
            <?php echo $formItems['datePicker1']; ?>
            </div>
            <div id="datePicker1Validation" class="dungeon validationError" name="datePicker1Validation">
                
            </div>
        </div>
        
        <div class="row">
            <div class="dungeon">
            <?php echo $formItems['submit1']; ?>
            </div>
        </div>
    </div>
<?php formClose();