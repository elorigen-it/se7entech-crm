<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<div class="upload-div">
    <!-- File upload form -->
    <form id="uploadForm" enctype="multipart/form-data">
        <label>Choose Images</label>
        <input type="file" name="images[]" id="fileInput" multiple >
        <input type="submit" name="submit" value="UPLOAD"/>
    </form>
	
    <!-- Display upload status -->
    <div id="uploadStatus"></div>
</div>
<div class="gallery"></div>
<script>
$(document).ready(function(){
    // File upload via Ajax
    $("#uploadForm").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'upload.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#uploadStatus').html('<img src="uploading.gif"/>');
            },
            error:function(){
                $('#uploadStatus').html('<span style="color:#EA4335;">Images upload failed, please try again.<span>');
            },
            success: function(data){
                $('#uploadForm')[0].reset();
                $('#uploadStatus').html('<span style="color:#28A74B;">Images uploaded successfully.<span>');
                $('.gallery').html(data);
            }
        });
    });
    
    // File type validation
    $("#fileInput").change(function(){
        var fileLength = this.files.length;
        var match= ["image/jpeg","image/png","video/mp4","image/jpg","image/gif"];
        var i;
        for(i = 0; i < fileLength; i++){ 
            var file = this.files[i];
            var imagefile = file.type;
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3]))){
                alert('Please select a valid image file (JPEG/JPG/PNG/GIF/MP4).');
                $("#fileInput").val('');
                return false;
            }
        }
    });
});
</script>
