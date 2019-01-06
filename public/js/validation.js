function Validation(idEmail,idPass){
    this.EmailStatus=this.CreateStatusCheck(idEmail);
    this.PasswordStatus=this.CreateStatusCheck(idPass);
    this.ConfirmPasswordStatus=null;
    this.Email =document.getElementById(idEmail);
    this.Password =document.getElementById(idPass);
    this.TranslateArray =[];
    this.CreateTranslateArray();
    this.addEvent();
}
Validation.prototype={
    PasswordStrengthCheck: function () {
        var PasswordValue = this.Password.value,
            basepoint = PasswordValue.length * 10,
            Number =PasswordValue.match(/[0-9]/g),
            UperCase =PasswordValue.match(/[A-Z]/g),
            LowerCase=PasswordValue.match(/[a-z]/g);
        if (Number !=null && (Number.length >= 2) && ((UperCase !=null && (UperCase.length >= 2)) && (LowerCase !=null && (LowerCase.length >= 2)) ) ){
            basepoint = basepoint * 5;
        }

        if(basepoint <= 240) {
            $(this.PasswordStatus).removeClass();
            this.PasswordStatus.classList.add('text-danger');
            this.PasswordStatus.innerText=this.TranslateArray[0];
        }else if(basepoint <= 550 && basepoint > 240) {
            $(this.PasswordStatus).removeClass();
            this.PasswordStatus.classList.add('text-warning');
            this.PasswordStatus.innerText=this.TranslateArray[1];
        }else if (basepoint >550){
            $(this.PasswordStatus).removeClass();
            this.PasswordStatus.classList.add('text-success');
            this.PasswordStatus.innerText=this.TranslateArray[2];
        }
    },
    CreateStatusCheck:function (id) {
        let  span = document.createElement('span'),
            div =document.createElement('div'),
            parent = $('#'+id).parent('div').parent('div')[0];
        div.classList.add('col-sm-4');
        div.appendChild(span);
        parent.appendChild(div)
        return  span;
    },
    CheckUniqueEmail:function () {
        var email = this.Email.value,
            that = this;
        $.ajax({
            type: 'post',
            url: 'CheckEmail',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {email:email},
            success: function (result) {

                if(result.success === false) {
                    that.EmailStatus.innerText = result.errors.email;
                    $(that.EmailStatus).removeClass();
                    that.EmailStatus.classList.add('text-danger');
                }
                else {
                    that.EmailStatus.innerHTML ='&#10004';
                    $(that.EmailStatus).removeClass();
                    that.EmailStatus.classList.add('text-success');
                }
            },
            error:function (data) {

                //process validation errors here.
                var errors = data.responseJSON; //this will get the errors response data.
                that.EmailStatus.innerText = errors.errors.email
                that.EmailStatus.classList.add('alert-danger');




            },

        });
    },
    addEvent:function () {
        var that =this;
        this.Email.addEventListener('blur', function () {
            that.CheckUniqueEmail();
        })
        this.Password.addEventListener('keyup', function () {
            that.PasswordStrengthCheck();
        })
    },
    CreateTranslateArray:function () {
        this.TranslateArray[0] = GetTranslate('badPassword');
        this.TranslateArray[1] = GetTranslate('goodPassword');
        this.TranslateArray[2] = GetTranslate('strongPassword');
    }

}