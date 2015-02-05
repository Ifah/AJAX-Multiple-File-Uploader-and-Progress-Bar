<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Multiple File Uploader</title>
	<link rel="stylesheet" href="css/global.css">
</head>
<body>
	<form action="upload.php" method="post" enctype="multipart/form-data" id="upload" class="upload">
		<fieldset>
			<legend>Upload files</legend>
			<input type="file" id="file" name="file[]" required multiple>
			<input type="submit" id="submit" name="submit" value="Upload">
		</fieldset>
		<div class="bar">
			<span class="bar-fill" id="pb"><span class="bar-fill-text" id="pt"></span></span>
		</div>
		<div id="uploads" class="uploads">
			Uploaded file links will appear here.
		</div>

		<script src="js/upload.js"></script>
		<script>

		document.getElementById('submit').addEventListener('click', function(e){
			e.preventDefault();

			var f = document.getElementById('file'),
				pb = document.getElementById('pb'),
				pt = document.getElementById('pt');

			app.uploader({
				files: f,
				progressBar: pb,
				progressText: pt,
				processor: 'upload.php',

				finished: function(data){
					var uploads = document.getElementById('uploads'),
						succeeded = document.createElement('div'),
						failed = document.createElement('div'),

						anchor,
						span,
						x;

					if(data.failed.length){
						failed.innerHTML = '<p>Unfortunately, the following files failed to upload:</p>'
					}

					uploads.innerText = '';

					for(x = 0; x < data.succeeded.length; x = x + 1){
						anchor = document.createElement('a');
						anchor.href = 'uploads/' + data.succeeded[x].file;
						anchor.innerText = data.succeeded[x].name;
						anchor.target = '_blank';

						succeeded.appendChild(anchor);
					}

					for(x = 0; x < data.failed.length; x = x + 1){
						span = document.createElement('span');
						span.innerText = data.failed[x].name;

						failed.appendChild(span);
					}

					uploads.appendChild(succeeded);
					uploads.appendChild(failed);
				},

				error: function(){
					console.log('Not working.');
				}
			});			
		});
		
		</script>
	</form>
</body>
</html>