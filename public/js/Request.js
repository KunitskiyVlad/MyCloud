function Request() {
}

Request.prototype= {
    sendFiles: function (FileList,url,typeRequest,callback) {
        let checkRequest =this.checkTypeRequest(typeRequest);
        if(!checkRequest){
            return
        }
        let data = new FormData();
        for(let i=0;i<FileList.length;i++) {
            data.append('file'+i, FileList[i]);
        }
        $.ajax({
            type: typeRequest,
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result){
                callback(result)

            },
            error:function (error) {
            }
        })
    },

    send: function (DataObject,url,typeRequest) {
        let checkRequest =this.checkTypeRequest(typeRequest);
        if(!checkRequest){
            return
        }
        $.ajax({
            type: typeRequest,
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $.parameters(DataObject),
            success: function (result) {
            },
            error:function (data) {
            },

        });
    },
    checkTypeRequest:function(RequestType){
        var list =['post','get','delete','put','update'];
        RequestType = RequestType.toLowerCase();
        for(let i=0;list.length;i++){
            if(list[i] === RequestType){
                return true;
            }
        }
        return false;
    }
}