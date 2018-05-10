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

     <div>Under construction...</div>
</div>