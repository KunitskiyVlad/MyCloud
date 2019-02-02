;function DragAndDropFiles(targetZone) {
    this.TargetZone = targetZone;
    this.File = [];
    this.addEvent();
    this.FilesName=[];
}
DragAndDropFiles.prototype= {
    Drop:function () {
        event.preventDefault();
        this.TargetZone.classList.remove('hover');
        var file = event.dataTransfer.files;
        for (var i = 0; i < file.length; i++) {
            this.File[i] = file.item(i);
            this.FilesName[i] = this.File[i].name;
        }
    },
    over: function () {
        this.TargetZone.classList.remove('hover');
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
            event.preventDefault();
        }, false);
        this.TargetZone.addEventListener('drop', function (event) {
            event.preventDefault();
        },false);
        this.TargetZone.addEventListener('drop', function () {
           that.Drop();
        },false);
    },
    getFilesName:function(){
        return this.FilesName;
    },
    getFiles:function () {
        return this.File;
    }
};
