<div id="global">
    <div class="container-fluid cm-container-white">
     <h2 style="margin-top:0;">Add New Music</h2>
     <p>Please fill all informations and select an MP3 file to upload it into the server.</p>
 </div>
 <div class="container-fluid">
    <div class="row cm-fix-height">
        <?php
        if ($notification!="-1") {
            if ($notification=="1") {
             echo '<div class="alert alert-success">
             <strong>Success!</strong> Music Added successfuly ! you can see it here : <a href="index.php?q=find">HERE</a>

             </div>';  
         }else{
             echo '<div class="alert alert-danger">
             <strong>Error !</strong> Music has not been Added successfuly, please check if is not already exist OR if the server is STARTED ! 
             </div>'; 
         }
     }
     ?>

     <form class="form-horizontal" method="post" enctype="multipart/form-data">
      <fieldset>
       <!-- Text input-->
       <div class="form-group">
        <label class="col-md-4 control-label" for="title">Title</label>  
        <div class="col-md-5">
         <input id="title" name="title" type="text" placeholder="Hello" class="form-control input-md" required="">
         <span class="help-block">Add your music title</span>  
     </div>
 </div>
 <!-- Text input-->
 <div class="form-group">
    <label class="col-md-4 control-label" for="artist">Artist</label>  
    <div class="col-md-5">
     <input id="artist" name="artist" type="text" placeholder="Adele" class="form-control input-md" required="">
     <span class="help-block">Add you music Artist</span>  
 </div>
</div>
<!-- Text input-->
<div class="form-group">
    <label class="col-md-4 control-label" for="album">Album</label>  
    <div class="col-md-5">
     <input id="album" name="album" type="text" placeholder="Hello" class="form-control input-md" required="">
     <span class="help-block">Add the Album of the music</span>  
 </div>
</div>
<!-- Text input-->
<div class="form-group">
    <label class="col-md-4 control-label" for="year">Year</label>  
    <div class="col-md-5">
     <input id="year" name="year" type="text" placeholder="2015" class="form-control input-md" required="">
     <span class="help-block">Year of music</span>  
 </div>
</div>
<!-- File Button --> 
<div class="form-group">
    <label class="col-md-4 control-label" for="file">Music File</label>
    <div class="col-md-4">
     <input id="file" name="file" class="input-file" type="file">
 </div>
</div>
<!-- Button -->
<div class="form-group">
    <label class="col-md-4 control-label" for="submit">Add Music</label>
    <div class="col-md-4">
     <button id="submit" name="submit" class="btn btn-primary">Submit</button>
 </div>
</div>
</fieldset>
</form>
</div>