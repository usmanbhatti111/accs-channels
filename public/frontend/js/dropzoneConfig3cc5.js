var myDropzone = null;

$(document).ready(function(){
    $("#myDropzone").dropzone({
        url: "/upload/screens",
        params: {
            group_num: $("#group_num").val(),
            _token: csrf
        },
        thumbnailWidth: 50,
        addRemoveLinks: true,
        dictRemoveFile: 'Remove',
        removedfile: function(file) {
            var el = $(file.previewElement);
            deletePhoto(el);
        },
        init: function() {
            myDropzone = this;
            this.on("addedfile", function() {
                adjustDropzoneHeight(false, $(".group-page").length);
            });
        },
        success: function(file, response){
            $(this.element).find(".dz-preview:not([data-src])").first().attr('data-src', '/'+ response[0]).attr('data-id', response[1]);
        },
        error: function (file, response) {
            setNoty(response.message, 'error')
        }
    });

    if(!$("#group_num").length){
        $('.edit-group').on('click', function(){
            var groupNum = $(this).attr('data-group-num'),
                screens  = JSON.parse($(this).attr('data-screens'));

            myDropzone.options.params = {
                group_num: groupNum,
                _token: csrf
            };

            $(".dz-preview").remove();

            $.each(screens, function(){
                var mockFile = {name: "image"+ (Math.floor(Math.random() * (999 - 1 + 1)) + 1) +".jpg"};
                myDropzone.emit("addedfile", mockFile);
                myDropzone.emit("thumbnail", mockFile, this.path);
                myDropzone.emit("complete", mockFile);
                $(myDropzone.element).find(".dz-preview:not([data-src])").first().attr('data-src', this.path);
                $(myDropzone.element).find('.dz-preview:not([data-id])').attr('data-id', this.id);
            });
        });
    }
});

function adjustDropzoneHeight(remove, modal){
    if (!remove) remove = false;

    var dropzone = $(".dropzone"),
        count    = dropzone.find('.dz-preview').length;

    var x = (count - (remove ? 0 : 1)) / 4;

    dropzone.find(".dz-message").hide();

    if(!count){
        dropzone.css('height', '90px');
        dropzone.find(".dz-message").show();
    }else if (count == 1){
        dropzone.css('height', modal ? '162px' : '176px');
    }else if (x % 1 === 0)
    {
        var pixels = (modal ? 162 : 176) + (remove ? x - 1 : x) * (modal ? 161 : 175);
        dropzone.css('height', pixels +'px');
    }
}

function deletePhoto(el){
    $.ajax({
        type: 'POST',
        url: '/delete/screen',
        data: {
            id: el.attr('data-id'),
            _token: csrf
        }
    })
    .done(function(data){
        if(data[0] == 'success'){
            el.remove();
            adjustDropzoneHeight(true, $(".group-page").length);
        }else{
            setNoty('An unknown error has occurred. Please contact the administrator.', 'error');
        }
    })
    .fail(function(){
        setNoty('An unknown error has occurred. Please contact the administrator.', 'error');
    });
}