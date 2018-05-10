<div id="global">
    <div class="container-fluid cm-container-white">
     <h2 style="margin-top:0;">Download a Music</h2>
     <p>Your Music is now ready !</p>
 </div>
 <div class="container-fluid">
    <div class="row cm-fix-height">
        <?php
        if ($notification!="-1") {
            if ($notification=="1") {
             echo '<div class="alert alert-success">
             <strong>Success!</strong> Music generated successfuly ! you can download it here : <a href="'.$link.'">HERE</a>

             </div>';  
         }else{
             echo '<div class="alert alert-danger">
             <strong>Error !</strong> Music has not been generated successfuly, please check if is not already exist OR if the server is STARTED ! 
             </div>'; 
         }
     }
     ?>
</div>