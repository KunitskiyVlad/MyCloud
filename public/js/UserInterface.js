function showHide(parentClass,targetClass,hideLastElem) {
    let target = event.target;
    if (hideLastElem === true) {
        $('.' + targetClass).each(function () {
            $(this).hide(250);
        })
    }
    if($(target).parents('.' + parentClass).find('div.' + targetClass).is(':visible')){
        $(target).parents('.' + parentClass).find('div.' + targetClass).hide(250);
    }else {
        $(target).parents('.' + parentClass).find('div.' + targetClass).show(250);
    }
}
$('.show-info-button').on('click',function (){
    showHide('content-file','info');
});
$('.fa-comment-alt').on('click',function (){
    showHide('content-file','comment',true);
});
$('.fa-download').on('click',function (){
    download(event.target.dataset.filename);
});
function download(FileName){
    console.log(FileName)
    $.ajax({
        type: 'post',
        url: 'file/download',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {FileName : FileName },
        success: function(result){
            let a = document.createElement('a')
            a.href = result.href;
            a.download = result.oldName;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            // window.location.href = result.href
        }
    });
}
function createWindowStatus() {
    let div = document.createElement('div'),
        span = document.createElement('span'),
        check = document.createElement('div');
    div.classList.add('success-window');
    check.classList.add('check');
    div.appendChild(check);
    var success =GetTranslate('successLoad');
    span.innerText=success;
    div.appendChild(span);
    document.body.appendChild(div);
    $(div).animate({opacity:0.9},1000);
    setTimeout(function (){
        $(div).animate({opacity:0},2000,function() {
            document.body.removeChild(this);
        })
    },5000);






}
function GetTranslate(StringName) {
    var Translate =StringName,
        NewTranslate=null,
        uri='';
        if (location.pathname.substr(1).indexOf('/') === -1){
            uri=location.pathname.substr(1)+'/';
        }
    $.ajax({
        type: 'post',
        async: false,
        url: uri+'translate',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {translate:Translate},
        success: function (result) {
            save(result);
        },
        error:function (data) {

        },
    });
    function save(result){
        NewTranslate = result.translate;
    }

    return NewTranslate;
}
function AddComment() {
    var parentForm =this.form,
        input =parentForm.content.value,
        fileId = this.form.dataset.fileid,
        commentreply = parentForm.querySelector('div[data-commentreply]').dataset.commentreply;
    $.ajax({
        type: 'post',
        async: false,
        url: '/'+location.pathname.substr(1)+'/'+fileId+'/comment',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {content:input,commentreplyId:commentreply},
        success: function (result) {
          let div = document.createElement('div'),
              spanName = document.createElement('span'),
              Content =document.createElement('p');
          spanName.innerText = result.name;
          Content.innerText = result.content;
          div.className +='col-10 text-left d-inline-block';
          div.appendChild(spanName);
          div.appendChild(Content);
          let textareaDiv = parentForm.querySelector('div textarea').parentNode;
          parentForm.insertBefore(div,textareaDiv);
        },
        error:function (data) {

        },
    });

}
function ReplyComment(){
    let ParentDiv = this.closest('div'),
        Content = ParentDiv.querySelector('p').innerText,
        CommentId = ParentDiv.dataset.commentid,
        parentForm = this.closest('form'),
        textareaDiv = parentForm.querySelector('div textarea').parentNode,
        divReply = parentForm.querySelector('div[data-commentreply]');
    divReply.innerHTML='<i>'+Content+'</i>';
    divReply.dataset.commentreply=CommentId;

}
$('.send').on('click',AddComment);
$('.fa-reply').on('click',ReplyComment);