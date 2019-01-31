function CropAvatar(ObjectStartParam){
    this.StartCanvas =null;
    this.StartCanvasContext=null;
    this.WidthStartCanvas=null;
    this.HeighthStartCanvas=null;
    this.WindowCoordinates ={x:0,y:0};
    this.StartWindowCoordinates ={};
    this.Window = null;
    this.PreviousCanvas=null;
    this.PreviousCanvasContext=null;
    this.leftHighCornerWindow=null;
    this.RightHighCornerWindow=null;
    this.leftBottomCornerWindow=null;
    this.RightBottomCornerWindow=null;
    this.ArrayCorner =[];
    this.CornerCoordinates=null;
    this.OriginalImage=null;
    this.CopyImage=null;
    this.Init(ObjectStartParam);
    this.Modal=null;
}

CropAvatar.prototype ={
    DrawOriginalImage: function () {
        var image = new Image(),
            that =this;
        image.onload = function () {
            that.StartCanvas.width=that.WidthStartCanvas;
            that.StartCanvas.height=that.HeighthStartCanvas;
            that.StartCanvasContext.drawImage(image,0,0,this.naturalWidth,this.naturalHeight);
            that.DrawCopyImage();
        }

        image.src=this.OriginalImage;
    },

    DrawCopyImage: function () {
        this.CopyImage = this.StartCanvas.toDataURL('image/png',1);
        var  image = new Image(),
            that =this;
        image.onload = function () {
            that.PreviousCanvas.width=50;
            that.PreviousCanvas.height=50;
            let hRatio = that.PreviousCanvas.width  / that.Window.offsetWidth,
                vRatio = that.PreviousCanvas.height / that.Window.offsetHeight,
                ratio  = Math.min ( hRatio, vRatio ),
                centerShift_x = ( that.PreviousCanvas.width - that.Window.offsetWidth*ratio ) / 2,
                centerShift_y = ( that.PreviousCanvas.height - that.Window.offsetHeight*ratio ) / 2;
            //ctx.clearRect(0,0,canvas.width, canvas.height);
            // previousCtx.scale(0.01,0.01);
            var box = that.getCoords(that.StartCanvas);
            that.PreviousCanvasContext.drawImage(image, that.WindowCoordinates.x-box.left,that.WindowCoordinates.y-box.top,that.Window.offsetWidth,that.Window.offsetHeight,
                centerShift_x,centerShift_y,that.Window.offsetWidth*hRatio,that.Window.offsetHeight*vRatio);
            //centerShift_x,centerShift_y,img.width*ratio, img.height*ratio);
        }
        image.src = this.CopyImage;
    },

    MoveWindow:function () {
        var that =this;
        document.body.onmousemove = function () {

            that.WindowCoordinates.x =event.pageX ;
            that.WindowCoordinates.y= event.pageY;
           // that.FixPositionWindow();
            that.Window.style.left =that.WindowCoordinates.x+'px';
            that.Window.style.top =that.WindowCoordinates.y+'px';
            that.MovePoint();
            that.DrawCopyImage();
        }
        document.body.onmouseup = function () {
            document.body.onmousemove = null;
            that.Window.onmousedown = null;
           // that.FixPositionWindow();
            that.Window.style.left = that.WindowCoordinates.x+'px';
            that.Window.style.top =that.WindowCoordinates.y+'px';
            that.MovePoint();
            that.DrawCopyImage();
        }
    },
    GetCoordinatesResize: function () {
        var that = this;
        this.leftHighCornerWindow    = document.createElement('span');
        this.RightHighCornerWindow   = document.createElement('span');
        this.leftBottomCornerWindow  = document.createElement('span');
        this.RightBottomCornerWindow = document.createElement('span');
        this.leftHighCornerWindow.className ='resize';
        this.RightHighCornerWindow.className ='resize';
        this.leftBottomCornerWindow.className ='resize';
        this.RightBottomCornerWindow.className ='resize';
        this.RightHighCornerWindow.style.top = this.leftHighCornerWindow.style.top = this.Window.offsetTop-10+'px';
        this.RightHighCornerWindow.style.left = this.RightBottomCornerWindow.style.left = this.Window.offsetLeft-10+this.Window.offsetWidth+'px';
        this.leftHighCornerWindow.style.left =this.leftBottomCornerWindow.style.left =this.Window.offsetLeft-10+'px';
        this.RightBottomCornerWindow.style.top = this.leftBottomCornerWindow.style.top =this.Window.offsetTop+this.Window.offsetHeight-10+'px';
        this.leftHighCornerWindow.addEventListener('mousedown',function(){that.MoveResizePoint()});
        this.RightHighCornerWindow.addEventListener('mousedown',function(){that.MoveResizePoint()});
        this.RightBottomCornerWindow.addEventListener('mousedown',function(){that.MoveResizePoint()});
        this.leftBottomCornerWindow.addEventListener('mousedown',function(){that.MoveResizePoint()});
        document.body.appendChild(this.leftHighCornerWindow);
        document.body.appendChild(this.RightHighCornerWindow);
        document.body.appendChild(this.leftBottomCornerWindow);
        document.body.appendChild(this.RightBottomCornerWindow);
        this. ArrayCorner.push(this.leftHighCornerWindow);
        this.  ArrayCorner.push(this.RightHighCornerWindow);
        this. ArrayCorner.push(this.leftBottomCornerWindow);
        this.  ArrayCorner.push(this.RightBottomCornerWindow);
    },

    MovePoint: function () {
        this.RightHighCornerWindow.style.top = this.leftHighCornerWindow.style.top = this.Window.offsetTop+'px';
        this.RightHighCornerWindow.style.left = this.RightBottomCornerWindow.style.left = this.Window.offsetLeft+this.Window.offsetWidth+'px';
        this.leftHighCornerWindow.style.left =this.leftBottomCornerWindow.style.left =this.Window.offsetLeft+'px';
        this.RightBottomCornerWindow.style.top = this.leftBottomCornerWindow.style.top =this.Window.offsetTop+this.Window.offsetHeight+'px';
    },

    FindNeighbors: function (target) {
        let ObjectCoord ={};
        for(let i=0;i<this.ArrayCorner.length;i++){
            if((this.ArrayCorner[i].offsetTop === target.offsetTop)){
                ObjectCoord.NeigborY = this.ArrayCorner[i];

            }else if(this.ArrayCorner[i].offsetLeft === target.offsetLeft){
                ObjectCoord.NeigborX = this.ArrayCorner[i];
            }
            else {
                ObjectCoord.opposite = this.ArrayCorner[i];
            }
        }
        ObjectCoord.target = target;
        return ObjectCoord;
    },

    Resize :function (ObjectCoord) {
        this.Window.style.width=Math.abs(ObjectCoord.opposite.offsetLeft-ObjectCoord.target.offsetLeft)+'px';
        this.Window.style.height=Math.abs(ObjectCoord.opposite.offsetTop-ObjectCoord.target.offsetTop)+'px';
        this.Window.style.top =this.leftHighCornerWindow.offsetTop+'px';
        this.Window.style.left =this.leftHighCornerWindow.offsetLeft+'px';
    },

    MoveResizePoint: function () {
        var ResizeX, ResizeY,
            that = this;
        for(let i=0;i<this.ArrayCorner.length;i++){
            if((this.ArrayCorner[i].offsetTop === event.target.offsetTop) &&(this.ArrayCorner[i].offsetLeft === event.target.offsetLeft)){
                this.ArrayCorner.splice(i,1);
                break;
            }
        }
        var ObjectCoord = this.FindNeighbors(event.target);
        document.onmousemove = function () {

            ObjectCoord.target.style.top = ResizeY=event.pageY+'px';
            ObjectCoord.target.style.left = ResizeX=event.pageX+'px';
            that.Resize(ObjectCoord);
            that._ChangePostionResizePoint(ObjectCoord);
            that.DrawCopyImage();
        }
        ObjectCoord.target.onmouseup = function () {
            document.onmousemove = null;
            ObjectCoord.target.onmousedown = null;
            ObjectCoord.target.style.top = ResizeY;
            ObjectCoord.target.style.left = ResizeX;
            that.Resize(ObjectCoord);
            that._ChangePostionResizePoint(ObjectCoord);
            ObjectCoord ={};
            that.ArrayCorner=[];
            that.ArrayCorner.push(that.leftHighCornerWindow);
            that.ArrayCorner.push(that.RightHighCornerWindow);
            that.ArrayCorner.push(that.leftBottomCornerWindow);
            that.ArrayCorner.push(that.RightBottomCornerWindow);
        }
    },

    _ChangePostionResizePoint: function (ObjectCoord) {
        ObjectCoord.NeigborY.style.top =ObjectCoord.target.offsetTop+'px';
        ObjectCoord.NeigborY.style.left =ObjectCoord.opposite.offsetLeft+'px';
        ObjectCoord.NeigborX.style.left =ObjectCoord.target.offsetLeft+'px';
        ObjectCoord.NeigborX.style.top =ObjectCoord.opposite.offsetTop+'px';
    },

    Init: function (ObjectStartParam) {
        var that =this;
        this.StartCanvas = document.createElement('canvas');
        this.StartCanvasContext = this.StartCanvas.getContext('2d');
        ObjectStartParam.PlaceStartCanvas.appendChild(this.StartCanvas);
        this.WidthStartCanvas = ObjectStartParam.widthCanvas;
        this.HeighthStartCanvas = ObjectStartParam.heightCanvas;
        this.PreviousCanvas = document.createElement('canvas');
        this.PreviousCanvasContext = this.PreviousCanvas.getContext('2d');
        ObjectStartParam.PlaceRedrawCanvas.appendChild(this.PreviousCanvas);
        this.OriginalImage = ObjectStartParam.urlImage;
        this.Window = document.createElement('div');
        this.Window.className = 'circle';
        document.body.appendChild(this.Window);
        this.PositionWindowCrop();
        this.Window.addEventListener('mousedown', function () {
            that.MoveWindow();
        })
        this.Modal = ObjectStartParam.modal;
        this.DrawOriginalImage();
        this.DrawCopyImage();
        this.GetCoordinatesResize();
    },
    getCoords:function(elem) {

        var box = elem.getBoundingClientRect();

        var body = document.body;
        var docEl = document.documentElement;


        var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
        var scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;


        var clientTop = docEl.clientTop || body.clientTop || 0;
        var clientLeft = docEl.clientLeft || body.clientLeft || 0;

        var top = box.top + scrollTop - clientTop;
        var left = box.left + scrollLeft - clientLeft;

        return {
            top: top,
            left: left
        }
    },
    SaveAvatar: function () {
        return this.PreviousCanvas.toDataURL('image/png');
    },
    RemoveCropElements: function () {
            document.body.removeChild(this.Window);
            document.body.removeChild(this.leftHighCornerWindow);
            document.body.removeChild(this.RightHighCornerWindow);
            document.body.removeChild(this.leftBottomCornerWindow);
            document.body.removeChild(this.RightBottomCornerWindow);
    },

    PositionWindowCrop : function () {
        this.Window.style.top = this.getCoords(this.StartCanvas).top+this.StartCanvas.offsetHeight/4+'px';
        this.Window.style.left = this.getCoords(this.StartCanvas).left+this.StartCanvas.offsetWidth/4+'px';

    },
    
    FixPositionWindow: function () {
        var positionCanvas = this.getCoords(this.StartCanvas);
        this.Window.hidden = true;
        if (document.elementFromPoint(this.WindowCoordinates.x,this.WindowCoordinates.y) !== this.StartCanvas){
            this.WindowCoordinates.x = positionCanvas.left;
            this.WindowCoordinates.y = positionCanvas.top

        }
        this.Window.hidden = false;
    },
}