<?php header("Content-type: text/css"); ?>

body {
	margin: 0;
	padding: 0;
	background: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #6D6D6D;
}

h1, h2, h3 {
	margin: 0;
	font-weight: normal;
	color: #78CC00;
}

h1 {
	letter-spacing: -1px;
	font-size: 32px;
}

h2 {
	font-size: 23px;
}

p, ul, ol {
	margin: 0 0 2em 0;
	text-align: justify;
	line-height: 26px;
}

a:link {
	color: #7AD000;
}

a:hover, a:active {
	text-decoration: none;
	color: #7AD000;
}

a:visited {
	color: #7AD000;
}

img {
	border: none;
}

img.left {
	float: left;
	margin: 7px 15px 0 0;
}

img.right {
	float: right;
	margin: 7px 0 0 15px;
}

/* Form */

form {
	margin: 0;
	padding: 0;
}

fieldset {
	margin: 0;
	padding: 0;
	border: none;
}

legend {
	display: none;
}

input, textarea, select {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #333333;
}

#wrapper {
	background: #7ACF00 url(<?php echo $_GET['urlRoot']; ?>images/headerBg.jpg);
}

/* Header */

#header {
	width: 900px;
	height: 80px;
	margin: 0 auto 20px auto;
	padding-top: 10px;
}

#logo {
	float: left;
	height: 120px;
	margin-left: 30px;
}

#logo h1 {
	font-size: 38px;
	color: #3399CC;
}

#logo h1 sup {
	vertical-align: text-top;
	font-size: 24px;
}

#logo h1 a {
	color: #FFFFFF;
}

#logo h2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
}

#logo a {
	text-decoration: none;
	color: #FFFFFF;
}

/* Menu */

#menu {
	float: right;
}

#menu ul {
	margin: 0;
	padding: 28px 0 0 0;
	list-style: none;
}

#menu li {
	display: inline;
}

#menu a {
	display: block;
	float: left;
	margin-left: 5px;
	background: #6AB000;
	padding: 7px 10px;
	text-decoration: none;
	font-size: 15px;
	color: #FFFFFF;
}

#menu a:hover {
	text-decoration: underline;
}

#menu .active a {
}

/* Page */

#page {
	width: 900px;
	margin: 0 auto;
	padding: 20px 20px;
}

/* Content */

#content {
	float: left;
	width: 590px;
	padding: 0px 30px 0px 30px;
}

/* Post */

.post {
}

.post .title {
	margin-bottom: 20px;
	padding-bottom: 5px;
	border-bottom: 10px solid #dedede;
}

.post .entry {
font-size:14px;
font-weight:bold;
}


/* Sidebar */

.sidebar {
	float: right;
	width: 230px;
}

.sidebar ul {
	margin: 0;
	padding: 10px 0 0 0;
	list-style: none;
}

.sidebar li {
	margin-bottom: 40px;
}

.sidebar li ul {
}

.sidebar li li {
	margin: 0;
	padding: 3px 0;
	border-bottom: 1px dashed #D1D1D1;
}

.sidebar li li a {
	margin: 0;
	padding-left: 25px;
	background: url(<?php echo $_GET['urlRoot']; ?>images/bullet.png) no-repeat left 50%;
}

.sidebar h2 {
	margin-bottom: 10px;
	padding-bottom: 5px;
	border-bottom: 10px solid #dedede;
	font-size: 18px;
	font-weight: normal;
}

.sidebar a {
	text-decoration: none;
	color: #6D6D6D;
}



.container
{
    display: table;
    width: 100%;
    font-size:12px;
}

.row
{
    display: table-row;
}

.dungeon
{
    vertical-align:top;
    padding:5px 5px 5px 5px;
    margin:4px 0 4px 0;
    display: table-cell;
}

.tableHeader
{
    font-weight: bold;
    font-size:14px;
}

.ok
{
background: #BDE5F8;
    color:#000000;
    font-size:14px;
}

.noPerms
{
    background: #fb4d08;
    color:#000000;
    font-size:14px;
}

#footer {
	clear: both;
	width: 900px;
	height: 30px;
	margin: 0px auto 30px auto;
	color: #FFFFFF;
	background: #6AB000;
}

#footer p {
	margin: 0px;
	padding: 10px 0px 0px 0px;
	text-align: center;
	line-height: normal;
	font-size: smaller;
}

#footer a {
	color: #FFFFFF;
}
