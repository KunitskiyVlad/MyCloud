let dragAndDrop  = new DragAndDropFiles(document.body),
    modal        = document.getElementById('modal'),
    FilesName    = dragAndDrop.getFilesName(),
    FilesList    = dragAndDrop.getFiles(),
    sendButton   = document.getElementById('send'),
    url          = $('html').attr('lang')+'/file/',
    loadButton   = document.getElementById('load'),
    inputFile    = document.getElementById('inputFile'),
    request      = new Request('load');
function removeFileFromList(FileArray){
    let number = event.target.dataset.number,
        parent = event.target.parentNode.parentNode.parentNode;
    FileArray.splice(number,1);
    parent.removeChild(event.target.parentNode.parentNode);
    return FileArray;
}
function clearFileList(FileArray,FilesName){
    let body = document.querySelector('div.modal-body');
    FileArray.length=0;
    FilesName.length=0;
    while (body.lastChild) {
        body.removeChild(body.lastChild);
    }
}
$(loadButton).on('click', function () {
    $(inputFile).trigger('click');
    $(inputFile).on('change', function () {
        let data = new FormData(),
            file = this.files,
            size = 0;
        for (let i = 0; i < file.length; i++) {
            data.append('file' + i, file[i]);
            size = size+file[i].size;
            if(size >50000){
                alert('Size exceeded!!!');
                return
            }
        }
        request.sendFiles(file, url, 'post', createWindowStatus);
        });
    });
document.body.addEventListener('drop',function () {
    $(modal).modal('show');
    for(let i=0;i<FilesName.length;i++) {
        let div       = document.createElement('div'),
            button    = document.createElement('button'),
            spanClose = document.createElement('span'),
            spanText  = document.createElement('span');
        button.className ='close';
        spanClose.innerHTML='&times;';
        spanText.innerText=FilesName[i];
        div.appendChild(spanText);
        button.appendChild(spanClose);
        button.dataset.number=i;
        button.addEventListener('click',function () {
            removeFileFromList(FilesList);
        });
        div.appendChild(button);
        $(modal).find('div.modal-body').append(div);
    }
});
sendButton.addEventListener('click',function () {
    let size =0;
    for (let i=0;i<FilesList.length;i++){
        size = size+FilesList[i].size;
        if(size >50000){
            alert('Size exceeded!!!');
            $(modal).modal('hide');
            return
        }
    }
    request.sendFiles(FilesList,url,'post',createWindowStatus);
    $(modal).modal('hide');
});
$(modal).on('hide.bs.modal', function(){
    clearFileList(FilesList,FilesName);
});