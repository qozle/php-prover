<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
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
    height: auto;
    width: 80%;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
}

#noise-text {
    text-align: center;
}

#loading-text {
    margin-left: auto;
    margin-right: auto;
}

h2 {
    display: block;
    margin-left: auto;
    margin-right: auto;
}

p {
    display: block;
    margin-left: auto;
    margin-right:auto;
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