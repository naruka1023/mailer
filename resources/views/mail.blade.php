<?php
?><!DOCTYPE html>
<html lang="en">
<head>
  <title>Automated Mailer</title>
  <meta charset="utf-8">
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
                    <p>Send emails every 
                        <select id='basis' form="carform">
                            <option value="day">day</option>
                            <option value="day">week</option>
                            <option value="month">month</option>
                            <option value="year">year</option>
                        </select>
                        <div style='margin:auto; padding:30px 0px 10px 0px; display:inline-flex'>
                            <label style='padding-right:1em'>Template: </label><input type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                    </p>
                    <button type="button" id='submitButton' onclick='sendMail(fileToUpload)' class="btn btn-primary">SEND MAIL</button>
                    <div id='waitMail' style='text-align:center; margin-top:3em; display:none'>
                        <i class="fa fa-circle-o-notch fa-spin" style="font-size:48px;color:blue"></i>
                    </div>
                </form>
                <div id='noProcess' style='margin-top:3em; display:none'>
                    NO PROCESSES AVAILABLE
                </div>
                <div id='Process' style='margin-top:3em; display:none'>
                    <table id="processTable">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Template</th>
                                <th>Basis</th>
                                <th>Remove</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id='wait' style='text-align:center; margin-top:3em'>
                    <i class="fa fa-circle-o-notch fa-spin" style="font-size:48px;color:blue"></i>
                </div>
            </div>
        </div>
    </div>
<script>
    $.get("api/process",function(data, status){
        $('#wait').css('display', 'none');
        if(data.length != 0){
            $('#Process').css('display', 'block');
            let color = 'success'
            populateTable(data, false);
        }else{
            $('#noProcess').css('display', 'block');
        }
    });

    function populateTable(data, emptyFlag){
        var rows = $.map(data, function(value, index) {
            let color = (value.status == 'INACTIVE')? 'danger' : 'success';
            let statusParameter = value.pID;
            let result = '<tr><td>' + value.pID + '</td>' +
                    '<td><button id="status' + value.pID + '" type="button" onclick="updateStatus('+ statusParameter + ')" class="btn btn-' + color + '">'+ value.status +'</button></td>' +
                    '<td>' + value.fileName + '</td>' +
                    '<td>' + value.basis + '</td>' +
                    '<td><button onclick="deleteProcess('+ statusParameter + ')"><i style="font-size:2em; color:red" class="fa fa-window-close" aria-hidden="true"></i></button></td>' +
                    '</tr>';
            return result;
        });
        if(emptyFlag){
            $('#processTable >tbody').empty();
        }
        $('#processTable > tbody').append(rows.join(''));
    }
    function deleteProcess(pID){
        $('#waitMail').css('display', 'block');
        $.ajax({
            url: "api/process/" + pID,
            type: 'DELETE',
            success: function(response) {
                $('#waitMail').css('display', 'none');
                populateTable(response, true);
            }
        });
    }
    function updateStatus(pID){
        $('#waitMail').css('display', 'block');
        $.ajax({
            url: "api/process/" + pID,
            type: 'PUT',
            success: function(response) {
                $('#waitMail').css('display', 'none');
                let color = (response.status == 'INACTIVE')? 'danger' : 'success';
                $('#status' + response.pID).removeClass();
                $('#status' + response.pID).addClass("btn btn-" + color + "");
                $('#status' + response.pID).html(response.status);
            }
        });
    }
    function sendMail(fileToUpload){
        $('#waitMail').css('display', 'unset');
        $('#submitButton').css('display', 'none');
        let file = fileToUpload.value.split("\\");
        let url = 'http://127.0.0.1:8000';
        let basis = $('#basis').val();
        file = file[file.length-1];
        $.post("api/process",
        {
            file: file,
            basis: basis
        },
        function(data, status){
            let color = (data.status == 'INACTIVE')? 'danger' : 'primary';
            $('#submitButton').css('display', 'unset');
            $('#waitMail').css('display', 'none');
            // let newRow = '<tr><td>' + data.pID + '</td>' +
            //              '<td><button type="button" class="btn btn-' + color + '">'+ data.status +'</button></td>' +
            //              '<td>' + data.fileName + '</td>' +
            //              '<td>' + data.basis + '</td>' +
            //              '</tr>';
            // $('#processTable > tbody').append(newRow);
            alert('New Automated Mailer process has been added!');
            location.reload()
        });  
    }
</script>
</body>
</html>
