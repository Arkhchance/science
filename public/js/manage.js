$(document).ready(function () {

    var errormodal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'button', 'escape'],
    closeLabel: "Close"
    });
    errormodal.addFooterBtn('Okay', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function(){
        errormodal.close();
        location.reload(true);
    });

    $("#delete").click(function(event) {

        var id = $("#iselect").val();
        var type = event.target.attributes.mode.value;

        var modalvalid = new tingle.modal({
            footer: true,
            stickyFooter: false,
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: "Close",
            beforeClose: function() {
                return true; // close the modal
            }
        });
        modalvalid.setContent('Are you sure you want to delete these ?');
        modalvalid.addFooterBtn('Cancel', 'tingle-btn tingle-btn--primary tingle-btn--pull-left', function(){
            modalvalid.close();
            return;
        });
        modalvalid.addFooterBtn('DELETE', 'tingle-btn tingle-btn--danger tingle-btn--pull-right', function(){
            $.ajax({
               type: 'POST',
               url: '/manage/del',
               data: { id: id, type:type } ,
               dataType: 'json',
               success: function (data) {
                    if(data.SUCCES == "OK") {
                        location.reload(true);
                    } else if(data.SUCCES == "PARTIAL"){
                        errormodal.setContent("Some are in use and can't be deleted");
                        errormodal.open();
                    } else {
                        errormodal.setContent("Error (if this persist, contact an admin)");
                        errormodal.open();
                    }
               }
           });
            modalvalid.close();
        });
        modalvalid.open();
    });

    $(".Pdelete").click(function(event) {

        var id = event.target.attributes.dval.value;
        var type = event.target.attributes.dtype.value;

        var modalvalid = new tingle.modal({
            footer: true,
            stickyFooter: false,
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: "Close",
            beforeClose: function() {
                return true; // close the modal
            }
        });
        modalvalid.setContent('Are you sure you want to delete ?');
        modalvalid.addFooterBtn('Cancel', 'tingle-btn tingle-btn--primary tingle-btn--pull-left', function(){
            modalvalid.close();
            return;
        });
        modalvalid.addFooterBtn('DELETE', 'tingle-btn tingle-btn--danger tingle-btn--pull-right', function(){
            $.ajax({
               type: 'POST',
               url: '/manage/del',
               data: { id: id, type:type } ,
               dataType: 'json',
               success: function (data) {
                    if(data.SUCCES == "OK") {
                        location.reload(true);
                    } else if(data.SUCCES == "PARTIAL"){
                        errormodal.setContent("Some are in use and can't be deleted");
                        errormodal.open();
                    } else {
                        errormodal.setContent("Error (if this persist, contact an admin)");
                        errormodal.open();
                    }
               }
           });
            modalvalid.close();
        });
        modalvalid.open();
    });
    $(".Ldelete").click(function(event) {

        var pfId = event.target.attributes.pfid.value;
        var vulgaId = event.target.attributes.vulgaid.value;
        var type = 'pfvulga';

        var modalvalid = new tingle.modal({
            footer: true,
            stickyFooter: false,
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: "Close",
            beforeClose: function() {
                return true; // close the modal
            }
        });
        modalvalid.setContent('Are you sure you want to delete ?');
        modalvalid.addFooterBtn('Cancel', 'tingle-btn tingle-btn--primary tingle-btn--pull-left', function(){
            modalvalid.close();
            return;
        });
        modalvalid.addFooterBtn('DELETE', 'tingle-btn tingle-btn--danger tingle-btn--pull-right', function(){
            $.ajax({
               type: 'POST',
               url: '/manage/del',
               data: {id:4, pfid: pfId,vulgaid:vulgaId, type:type } ,
               dataType: 'json',
               success: function (data) {
                    if(data.SUCCES == "OK") {
                        location.reload(true);
                    } else if(data.SUCCES == "PARTIAL"){
                        errormodal.setContent("Some are in use and can't be deleted");
                        errormodal.open();
                    } else {
                        errormodal.setContent("Error (if this persist, contact an admin)");
                        errormodal.open();
                    }
               }
           });
            modalvalid.close();
        });
        modalvalid.open();
    });

    function changeState(lid,state) {
        $.ajax({
           type: 'POST',
           url: '/manage/vulgastate',
           data: { lid:lid , state:state,} ,
           dataType: 'json',
           success: function (data) {
                if(data.SUCCES != "OK"){
                    //failed return to previous version
                    if(state == 'priv') {
                        $("#p"+lid).prop( "checked", true );
                    } else {
                        $("#u"+lid).prop( "checked", true );
                    }
                }
           }
       });
    }

    //fire if value is ON
    $(".private").change(function(event){
        var id = event.target.id;
        id = id.substring(1);
        changeState(id,'priv');
    });

    $(".public").change(function(event){
        var id = event.target.id;
        id = id.substring(1);
        changeState(id,'pub');
    });
    $(".Lselect").click(function(event) {
        var vulgaId = event.target.attributes.vulgaid.value;
        $("#vulga").val(vulgaId);
        $("#vulga").selectpicker('render');
    });
}); //end document.ready()
