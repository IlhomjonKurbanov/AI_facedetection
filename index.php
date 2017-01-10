<head>
    <title>Detekcja twarzy</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.facedetection.min.js"></script>


    <script src="js/scripts.js"></script>

    <link href="css/template.css" type="text/css" rel="stylesheet" />
</head>

<body>
    <nav>
        <div class="left">
            <a href="upload.php">Wrzuć zdjęcie</a>
            <a id="find_face" style="display:none">Znajdź Twarze</a>
            <a id="generate" style="display:none">Generuj</a>
            <a id="download" style="display: none">Pobierz</a>
        </div>
        <div class="right">

        </div>
        <div class="clear"></div>
    </nav>
    <section>
        <div class="left">
            <div id="photos">
                <?php
					$images = glob("img/" . "*.jpg");
					foreach($images as $image) {echo "<img class=\"img_g\" src=\"".$image.'"/>';}
                ?>
            </div>
        </div>
        <div class="right">
            <div id="imgbox">
                <div id="Canvas_container">
                    <div>
                        <canvas id="myCanvas" width="0" height="0"></canvas>
                    </div>
                </div>

                <script>
                    var FacesArray = [[],[]];
                    $('.img_g').click(function () {
                        $('.face').remove();
                        $('.info').remove();
                        $('#generate').css("display","none");
                        $('#download').css("display","none");
                        $('#find_face').css("display","block");
                        var canvas = document.getElementById('myCanvas');
                        var context = canvas.getContext('2d');
                        var imageObj = new Image();
                        context.clearRect(0, 0, canvas.width, canvas.height);
                        canvas.width = this.naturalWidth;
                        canvas.height = this.naturalHeight;
                        imageObj.src = this.src;
                        imageObj.onload = function() {
                            context.drawImage(imageObj, 0, 0);
                        };
                    });
                    $('#find_face').click(function () {
                        $('#myCanvas').faceDetection({
                            complete: function (faces) {
                                $('.face').remove();
                                $('.info').remove();
                                for (var i = 0; i < faces.length; i++) {
                                    $('<a>', {
                                        'class': 'face',
                                        'css': {
                                            'position': 'absolute',
                                            'left': faces[i].positionX * faces[i].scaleX + 'px',
                                            'top': faces[i].positionY * faces[i].scaleY + 'px',
                                            'width': faces[i].width * faces[i].scaleX + 'px',
                                            'height': faces[i].height * faces[i].scaleY + 'px',
                                        }
                                    })
                                        .insertAfter(this);
                                    FacesArray[i] = [faces[i].x, faces[i].y, faces[i].width, faces[i].height];
                                    console.log(FacesArray[i])
                                }
                                console.log(faces);
                                $( "nav .right" ).append( "<p class=\"info\">" +
                                    "Czas wykrywania: " + faces['time']/1000 + " [s]<br>" +
                                    "Ilość wykrytych twarzy: "+faces.length+
                                    " </p>" );
                                $('#generate').css("display","block");

                            }
                        });
                    });
                    $('#generate').click(function () {
                        $('#download').css("display","block");
                        $('.face').remove();
                        for(var i=0; i < FacesArray.length; i++) {
                            Blur('myCanvas', FacesArray[i][0], FacesArray[i][1], FacesArray[i][2], FacesArray[i][3]);
                        };
                    });
                    $('#download').click(function() {
                        this.href = $('#myCanvas')[0].toDataURL();
                        this.download = 'generate.jpg';
                    });

                </script>
            </div>
        </div>
        <div class="clear"></div>

    </section>
</body>


