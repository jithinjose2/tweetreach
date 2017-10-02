<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <script
                src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
                crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <div style="height: 30px"></div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h3>TweetReach</h3>
                    <br>
                    <div>Discover twitter tweet reach</div>
                    <br>
                    <div class="input-group">
                        <input type="text" id="url" class="form-control" placeholder="Tweet URL..." aria-label="Tweet URL...">
                        <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" id="btn">Get Tweet Reach!</button>
                      </span>
                    </div>
                    <div id="message">
                        
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function () {

            var _message = $("#message");
            var url = $("#url").val();

            var checkStatus = function () {
                url = $("#url").val();
                $.ajax({url:'/reach?' + encodeURI('tweet_url=' + url)})
                .done(function (response) {
                    console.log(response);
                    if (response.tweet.status == 5) {
                        _message.html("Tweet Reach is " + response.tweet.reach);
                    } else {
                        setTimeout(checkStatus, 4000);
                    }
                }).fail(function (response) {
                    _message.html("Invalid URL");
                })
            }

            $("#btn").click(function () {
                $(this).attr("disabled", "disabled");
                $(this).parent().find("input").attr("disabled", "disabled");
                _message.html("Please wait");
                checkStatus();
            })
        })
    </script>
</html>