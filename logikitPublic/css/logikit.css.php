<?php header("Content-type: text/css"); ?>
.info, .success, .warning, .error, .validation
{
    font-size:13px;
    border: 1px solid;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
    width:80%;
}


.info
{
    color: #00529B;
    background-color: #BDE5F8;
    background-image: url('<?php echo $_GET['urlRoot']; ?>logikitPublic/images/info.png');
}
.success
{
    color: #4F8A10;
    background-color: #DFF2BF;
    background-image:url('<?php echo $_GET['urlRoot']; ?>logikitPublic/images/success.png');
}
.warning
{
    color: #9F6000;
    background-color: #FEEFB3;
    background-image: url('<?php echo $_GET['urlRoot']; ?>logikitPublic/images/warning.png');
}
.error
{
    color: #D8000C;
    background-color: #FFBABA;
    background-image: url('<?php echo $_GET['urlRoot']; ?>logikitPublic/images/error.png');
}

.onTop
{
    position:absolute;
    width:80%;
    left:10px;
    top:10px;
    z-index:99;
}

.inputboxDate
{
    width:100px;
}

.validationError
{
    font-weight:bold;
    color:#ff0000;
}

.selectedPage
{
background:yellow;
}
