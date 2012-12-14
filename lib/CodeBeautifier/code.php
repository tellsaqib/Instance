<?php 
include 'lib/dbtable.class.php'; include 'lib/controllers/controller.forum.php';include 'lib/models/model.forum.php';$recordList = ForumController::getList(); ?>
<html>
<head>
<title >Forum List</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jscript/jquery.js" > </script>
<script type="text/javascript" src="jscript/rater.js" > </script>
<script type="text/javascript" >
$().ready(function(){
<?php foreach($recordList as $record){ ?>
$('#avgRating<?php echo $record->forumID; ?>').rater({value: 3 , enabled: false });
$('#yourRating<?php echo $record->forumID; ?>').rater({url:'listforum.php' ,mediapath:'../images/'});

<?php }?>
});</script>
</head>
<body>
<div class="container" ><?php include 'includes/navigation.php'; ?><h3 >This is ForumList</h3>
<a class="blockLink last" href="saveforum.php" >Add Forum</a><?php foreach($recordList as $record){
?>
<hr class="space" /><div class="span-15 prepend-1 colborder">
<?php
echo '<h3>' . $record->title . '</h3>';echo $record->author . '<br />';echo '</div><div class="span-7 last">';echo '<b>Averate Rating<b><br /><div id="avgRating' . $record->forumID . '"></div>';echo '<b>Your Rating<b><br /><div id="yourRating' . $record->forumID . '"></div>';echo '</div><br /> ';echo '<a class="blockLink distance" href="saveforum.php?id=' . $record->forumID . '" >Save</a>';echo '<a class="blockLink distance" href="listforum.php?action=delete&id=' . $record->forumID . '" >Delete</a>';echo '<hr class="space" />';} ?>
</div></body>
</html>
