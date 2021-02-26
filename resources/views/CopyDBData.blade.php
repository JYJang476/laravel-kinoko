<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>

<body>
<script>
    window.onload = () => {
        let aaa = document.getElementById("aaa");
        let rs = document.getElementById("result");
        document.cookie = encodeURIComponent("token") + "=" + encodeURIComponent("grehe4heh4WW");
        aaa.onclick = () => {
            let req = new XMLHttpRequest();
            // $.ajax({
            //     type: "get",
            //     url: "http://54.210.105.132/api/machine/test",
            //     crossDomain: true,
            //     xhrFields : {
            //         withCredentials: true
            //     }
            // });
            axios.default.withCredentials = true;
            axios({
                method: 'get',
                url: 'http://54.210.105.132/api/machine/test',
                withCredentials: true,
            });
            //$.cookie('token', 'ponderoo');

            // req.open("get", "http://54.210.105.132/api/myfarm/id");
            // req.withCredentials = true;
            // //req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            // //req.setRequestHeader("Cookie", "token=1231");
            // req.send();
            // req.onreadystatechange = (state) => {
            //     if (req.readyState == 2) {
            //         if (req.status == 200) {
            //             rs.innerHTML = req.responseText;
            //         }
            //     }
            // }
        }

    }

</script>
<button id="aaa">몰라</button>
<form method="get" action="http://54.210.105.132/api/machine/test" enctype="multipart/form-data">
    <input name="compost" type="file">
    <input name="machineid" type="hidden" value="27" >
    <input type="submit">
</form>
</body>

</html>
