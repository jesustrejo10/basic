var shitFunction = function(){
    var moreShit = "SHIT";
    $("#shit").text("MIERDA");
    $.ajax({
        type: "GET",
        url: "http://localhost/insular/public/home/shit",
        cache: false,
        success: function(data){
            alert(data);
        },
        error: function(error){
            console.error(error);
            alert(error.toString());
        }
    });

}
