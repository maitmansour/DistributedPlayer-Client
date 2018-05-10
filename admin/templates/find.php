<div id="global">
	<div class="container-fluid cm-container-white">
		<h2 style="margin-top:0;">Show All Files on server</h2>
		<p>Please click on music to edit it !</p>
	</div>
	<div class="container-fluid">
		<div class="row cm-fix-height">
        <?php
        if ($notification!="-1") {
            if ($notification=="1") {
             echo '<div class="alert alert-success">
             <strong>Success!</strong> Music deleted successfuly !

             </div>';  
         }else{
             echo '<div class="alert alert-danger">
             <strong>Error !</strong> Music has not been deleted successfuly, please check if is not already exist OR if the server is STARTED ! 
             </div>'; 
         }
     }
     ?>
			<section class="content">
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">

							<div class="table-container">
								<?php
								if (isset($music_list)&&$music_list!="0") {
									?>
									<table class="table table-filter">
										<tbody>
											<?php
											foreach ($music_list as $music_key => $music_value) {
												?>
												<tr data-status="pagado">
													<td>
														<div class="media">
															<a  class="pull-left">
																<img style="width:  80px; height: 80px;" src="<?=$music_value['image']?>" class="media-photo">
															</a>
															<div class="media-body">
																<span class="media-meta pull-right">Filename : <?=substr($music_value['filename'],0,5)."..."?></span>
																<h4 class="title">
																	<?=$music_value['title']?>
																</h4>
																<p class="summary">Artist : <?=$music_value['artist']?> - Album : <?=$music_value['album']?> - Year : <?=$music_value['year']?></p>
															</div>
														</div>
													</td>
													<td>
														<a href="index.php?q=find&file=<?=$music_value['filename']?>" class="btn btn-danger">Delete</a>

													</td>													<td>
														<a href="index.php?q=download&file=<?=$music_value['filename']?>" class="btn btn-success">Download</a>

													</td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>
									<?php
								}else{
									echo 'Empty List Or Server error ! please add music <a href="index.php?q=add">HERE</a> ';
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>