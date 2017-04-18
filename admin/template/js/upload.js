        /* Script written by Adam Khoury @ DevelopPHP.com */ /* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg */
        function _(el) {
            return document.getElementById(el);
        }

        function uploadFile() {
			_('submitPost').disabled = "disabled";
			var post_id = _("post_id").value;
			if( post_id == "" ){
				alert( "post_id not specified ");
				return false;
			}
            var file = _("file").files[0];
            var formdata = new FormData();
            
            formdata.append("file", file);
            formdata.append("controller", 'post');
            formdata.append("action", 'upload_user_file');
            formdata.append("post_id", post_id);
            
            _("progressBar").style.display = "block";
            
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", ajaxurl);
            ajax.send(formdata);
        }

        function progressHandler(event) {
            _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBar").value = Math.round(percent);
            _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandler(event) {
			//_("progressBar").style.display = "none";
			_("status").style.display = "none";
			console.log( event.target.responseText );
            _("ajax_response").innerHTML = event.target.responseText;
            _('submitPost').disabled = "";
        }

        function errorHandler(event) {
            _("ajax_resonse").innerHTML = "Upload Failed";
        }

        function abortHandler(event) {
            _("status").innerHTML = "Upload Aborted";
        }

		function create_new_post(){
			if( _("post_id").value == "" ){
				var data = {
					controller: 'post',
					action: 'create_new_post'
				};
				$.post(ajaxurl, data, function (response) {
					console.log(response);
					var result = JSON.parse(response);
					$('input#post_id').val( result.post_id );
				});
			}
			
			return true;
		}
