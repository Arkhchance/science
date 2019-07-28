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
        var type = 'plateforme';

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
}); //end document.ready()
