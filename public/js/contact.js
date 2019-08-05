$(document).ready(function () {

    $('#domaine').val("-1");
    $('#domaine').selectpicker('refresh');

    function fillData(data) {
        var text = "La chaine "+ $("#vulga option:selected").text();
        text += " est dans les catégories suivante : ";
        text +="<ul>";
        if(data.SUCCES != "Ok") {
            $("#data").text("Erreur");
        } else {
            $('#domaine').selectpicker('deselectAll');
            $("#sexe").val(data.sexe);
            $("#pays").val(data.pays);
            $("#langue").val(data.langue);
            for(i in data.domaine.id) {
                $("#domaine option[value='" + data.domaine.id[i] + "']").prop("selected", true);
                text += "<li>"+data.domaine.name[i] +"</li>";
            }
        }
        text += "</ul>";
        $("#data").html(text);
        $(".selectpicker").each(function(){
            $(this).selectpicker('refresh');
        });
    }

    $("#vulga").change(function(){
        var val = $("#vulga").val();
        $.ajax({
           type: 'POST',
           url: '/divers/erreur',
           data: { id: val} ,
           dataType: 'json',
           success: function (data) {
                fillData(data);
           }
       });
    });

});
/*


*/
