$(document).ready(function () {
    
    

    $(document).on('click','#user-direct',function(){
        swal.fire({
            title: 'Select',
            html: "Redirect me to:" +
                '<br>'  +
                '<button type="button" role="button" tabindex="0" class="redirectOwner swal2-styled swal2-default-outline" style="display: inline-block; background-color: rgb(48, 133, 214);">' + 'Owner' + '</button>' +
                '<button type="button" role="button" tabindex="0" class="redirectClient swal2-styled swal2-default-outline" style="display: inline-block; background-color: rgb(48, 133, 214);">' + 'Client' + '</button>',
            showCancelButton: false,
            showConfirmButton: false
        });
    });

    $(document).on('click','.redirectOwner',function(){
        $(window).attr('location','/administrator/owner')
    });
    $(document).on('click','.redirectClient',function(){
        $(window).attr('location','/administrator/user/client')
    });
    
  
    $(".emoji-area").emojioneArea({
  	
		pickerPosition: "right",
    tonesStyle: "bullet",
		events: {
         	keyup: function (editor, event) {d
           		console.log(editor.html());
           		console.log(this.getText());
        	}
    	}
	});
});


function showPreview(event) {
    if (event.target.files.length > 0) {
        var src = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("file-dp-1-preview");
        preview.src = src;
        //preview.style.display = "block";
    }
}

var Toast = Swal.mixin({
    target: '#custom-target',
    customClass: {
      container: 'position-absolute'
    },
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
  });



