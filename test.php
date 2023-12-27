<?PHP


?>

<html>

<head>
    <script type="text/javascript">

        const strFile = "./resources/joel.lustgarten@yahoo.com/ppt/CV Joel Lustgarten English.pptx";

        function startPowerPoint() {
            var myApp = new ActiveXObject("PowerPoint.Application");
            if (myApp != null) {
                myApp.Visible = true;
                myApp.Presentations.Open(strFile);
            }
        }
    </script>
</head>

<body>
    <button type="button" onclick="startPowerPoint()">open the presentetion</button>
    <a href="#" onClick="startPowerPoint();">Open my PPS</a>
</body>

</html>