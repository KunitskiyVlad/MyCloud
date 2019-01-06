var dropArea = document.getElementById('dropArea'),
    maxFileSize = 50000000,
    app = document.getElementById('app');
var dragOver = function(){
    document.body.className = 'hover';
   console.log('true')
    return false;
};
function DragAndDropFiles(targetZone) {
    this.ModalWindow = null;
    this.TargetZone = targetZone;
    this.File = [];
    this.addEvent();

}
DragAndDropFiles.prototype= {
    createModal:function(files){
        this.ModalWindow = document.createElement('div');
    let
        divDialog = document.createElement('div'),
        divContent = document.createElement('div'),
        divHeader = document.createElement('div'),
        Header =document.createElement('h5'),
        buttonClose =document.createElement('button'),
        spanClose = document.createElement('span'),
        ModalBody =document.createElement('div'),
        ModalFooter = document.createElement('div'),
        ButtonCancel =document.createElement('div'),
        ButtonSend =document.createElement('div');
    this.ModalWindow.className='modal';
    console.log(files)
    divDialog.className='modal-dialog';
    divContent.className='modal-content';
    divHeader.className ='modal-header';
    Header.className='modal-title';
    buttonClose.className='close';
    ModalBody.className='modla-body';
    ModalFooter.className='modal-footer';
    ButtonCancel.className='btn btn-primary';
    ButtonSend.className='btn btn-primary';
    spanClose.innerHTML='&times';
    ButtonCancel.innerText='Отмена';
    ButtonSend.innerText='Отправить';
    divHeader.appendChild(Header);
    buttonClose.appendChild(spanClose);
    divHeader.appendChild(buttonClose);
    divContent.appendChild(divHeader);
    divDialog.appendChild(divContent);
    divContent.appendChild(ModalBody);
    ModalFooter.appendChild(ButtonCancel);
    ModalFooter.appendChild(ButtonSend);
    divContent.appendChild(ModalFooter);
    this.ModalWindow .appendChild(divDialog);
    this.ModalWindow .role='dialog';
    document.body.appendChild(this.ModalWindow);
    $(this.ModalWindow ).modal();
    Header.innerText='Загружаемые файлы';
        var that = this;
    for(let i=0;i<files.length;i++){
        let p = document.createElement('span'),
            fileimage = document.createElement('span'),
            div = document.createElement('div'),
            spanClose = document.createElement('span'),
            br = document.createElement('br');
        fileimage.className='file-image';
        spanClose.innerHTML ='&times';
        spanClose.className ='close';
        spanClose.addEventListener('click', function(event){
            that.removeFile(event);
        })
        p.innerText=files[i];
        div.appendChild(fileimage);
        div.appendChild(spanClose);
        div.appendChild(p);
        div.appendChild(br);
        div.className = 'list';
        ModalBody.appendChild(div)
    }
    ButtonSend.addEventListener('click',function (){
        that.send(that.File);

    });
},
    Drop:function () {

        event.preventDefault();
        this.TargetZone.classList.remove('hover');
        //app.addClass('drop');

        var file = event.dataTransfer.files,
            ArrayFileName = [];
        for (var i = 0; i < file.length; i++) {
            this.File[i] = file.item(i);
            ArrayFileName[i] = this.File[i].name;

        }
        this.createModal(ArrayFileName);
    },
    over: function () {
        this.TargetZone.classList.remove('hover');
    },
    send:function (file) {
        let data = new FormData();
        var that =this;
        for(let i=0;i<file.length;i++) {
            data.append('file'+i, file[i]);
        }
        $.ajax({
            type: 'post',
            url: $('html').attr('lang')+'/file/',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result){
                that.removeModal();
                createWindowStatus();
            }
        });
        },
    DragOver:function(){
        this.TargetZone.className = 'hover';
        return false;
    },
    addEvent:function () {
        var that = this;
        this.TargetZone.addEventListener('dragover', function (){
            that.DragOver();
        });
        this.TargetZone.addEventListener('dragleave', function (){
            that.over()
        });
        this.TargetZone.addEventListener("dragover", function(event) {
            event.preventDefault(); // отменяем действие по умолчанию
        }, false);
        this.TargetZone.addEventListener('drop', function (event) {
            event.preventDefault();
        },false);
        this.TargetZone.addEventListener('drop', function () {
           that.Drop();
        },false);
    },
    removeModal:function () {
        $(this.ModalWindow).remove()
        document.querySelector('div.modal-backdrop').remove();
    },
    removeFile: function (e) {
        let index = $('div.list').index($(e.target).parent('div.list'));
        this.File.splice(index,1);
        $('div.list')[index].remove();
    }
}
$('#load').on('click', function () {
    $('#inputFile').trigger('click');
    $('#inputFile').on("change", function () {


        let data = new FormData();
        var file = this.files;
        console.log(file)
        for (let i = 0; i < file.length; i++) {
            data.append('file' + i, file[i]);
        }
        $.ajax({
            type: 'post',
            url: $('html').attr('lang')+'/file/',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                createWindowStatus();
            }
        });
    });
})



