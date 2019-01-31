var inputAvatar = document.getElementById('avatar'),
    fieldForIrginalImage = document.getElementById('originalImage'),
    fieldForResizeImage = document.getElementById('ResizeImage'),
    send = document.getElementById('send'),
    avatar=null;
var validate =new Validation('email','password');
inputAvatar.addEventListener('change', function(){

    $('#crop').modal('show');
    $('#crop').modal({
        keyboard: true,
        width:800
    })
    url =URL.createObjectURL(event.target.files[0]);
    validate.CheckImage(event.target.files[0]);
    var crop = new CropAvatar({
        PlaceStartCanvas:fieldForIrginalImage,
        widthCanvas:400,
        heightCanvas:400,
        startTopPositionWindow:150,
        startLeftPositionWindow:550,
        PlaceRedrawCanvas:fieldForResizeImage,
        urlImage:url,
        modal:document.getElementById('crop'),
    });
    var SaveButton = document.getElementById('save');
    $('#crop').on('hide.bs.modal', function(){
        crop.RemoveCropElements();
    })
    SaveButton.addEventListener('click', function () {
        avatar =crop.SaveAvatar();
        $('#crop').modal('hide');

    })
})
send.addEventListener('click', function(){
    event.preventDefault();
    var password=document.getElementById('password').value,
        name =document.getElementById('name').value,
        repassword=document.getElementById('password-confirm').value,
        email =document.getElementById('email').value;
    $.ajax({
        type: 'post',
        url: '/'+location.pathname.substr(1),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {name:name,password:password,password_confirmation:repassword,email:email,avatar:avatar},
        success: function (result) {
            // window.location.href='/';

        },
        error:function (data) {

            //process validation errors here.
            //  var errors = data.responseJSON; //this will get the errors response data.
            //that.EmailStatus.innerText = errors.errors.email
            //that.EmailStatus.classList.add('alert-danger');




        },
    })
})
