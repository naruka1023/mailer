<?php
use DebugBar\StandardDebugBar;

$debugbar = new StandardDebugBar();
$debugbarRenderer = $debugbar->getJavascriptRenderer();

$debugbar["messages"]->addMessage("hello world!");
?><!DOCTYPE html>
<html lang="en">
<head>
  <title>Automated Mailer</title>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
</style>
</head>
<body>
    <div class="container">
        <div class='jumbotron' style='text-align:center; margin-top:3em'>
            <div>
                <h1>Automated Mailer</h1>
                <form id='mailForm'>
                    <p>
                        <div style='margin:auto; padding:30px 0px 10px 0px; display:inline-flex'>
                            <label style='padding-right:1em'>Template: </label><input type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                    </p>
                    <button type="button" id='submitButton' onclick='sendMail()' class="btn btn-primary">SEND MAIL</button>
                    <div id='waitMail' style='text-align:center; margin-top:3em; display:none'>
                        <i class="fa fa-circle-o-notch fa-spin" style="font-size:48px;color:blue"></i>
                    </div>
                </form>
            </div>
            <div style='margin-top:3em; text-align:center; display:block' id='mailProgress'></div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
<script>
       window.Echo.channel('test-event')
    .listen('EmailSentEvent', (e) => {
        let text = e.index + ' mails out of ' + e.totalMail + ' sent';
        $('#mailProgress').text(text);
    });
    function sendMail(fileToUpload){
        $('#waitMail').css('display', 'unset');
        $('#submitButton').css('display', 'none');
        let file = $('#fileToUpload').prop('files')[0];
        if(file != null){
            if(file.name.indexOf('.txt') != -1){
                var reader = new FileReader();
                reader.onload = function(event) {
                    let result = event.target.result;
                    $.post("api/mail",
                    {
                        file: result,
                    },
                    function(data, status){
                        $('#submitButton').css('display', 'unset');
                        $('#waitMail').css('display', 'none');
                        $('#mailProgress').text('');
                        alert('all ' + data.success +' emails sent!');
                    });  
                };
                reader.readAsText(file);
            }else{
                $('#submitButton').css('display', 'unset');
                $('#waitMail').css('display', 'none');
                alert('wrong file type! please choose a .txt file!');
            }
        }else{
            $('#submitButton').css('display', 'unset');
            $('#waitMail').css('display', 'none');
            alert('no file is chosen!');
        }
    }
</script>
</body>
</html>
