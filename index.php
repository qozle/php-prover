<!DOCTYPE html>
<html>
<head>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
<style>
#button-div {
    width: 100%;
    height: 200px;
}

#submit-button {
    display: block;
    margin-left: auto;
    margin-right: auto;
}

#noise {
    height: 400px;
    width: 80%;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    align-items: center;
}

#noise-text {
    text-align: center;
}

#loading-text {
    margin-left: auto;
    margin-right: auto;
}
</style>
</head>
<body>
<div id="noise"></div>
<div id="button-div">
<button type="submit" id="submit-button">Make nonsense</button>
</div>
<script>
$("#submit-button").click((e)=>{
    e.preventDefault();
    $("#noise").empty()
    $("#noise").append("<h1 id='loading-text'>Loading...</h1>")
    $.ajax({
        type: "GET",
        url: "makeNoise.php"
    }).done((data)=>{
        console.log("someone pressed the button and it finished.")
        $("#noise").empty()
        $("#noise").append(`<p id="noise-text">${data}</p>`)
    })

})
</script>

</body>
</html>