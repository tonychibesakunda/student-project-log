<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Project Logbook | {% block title%}{%endblock%}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
      

    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */

        .navbar {
            margin-bottom: 0;
            border-radius: 0;
            background-color: #016701;
            border: 1px solid #016701;

        }

        /* Change the Font color of the nav items to white*/

        .navbar-inverse .navbar-brand,
        .navbar-inverse .navbar-nav li a {
            color: #fff;
        }

        .navbar-inverse .navbar-nav li a:hover {
            color: #fa0;
        }

        .navbar-inverse .navbar-nav li a:active {
            color: #fa0;
            text-decoration: underline;
        }


        #labels label {
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
            font-weight: 700;
        }

        #navDrop li a {
            text-align: left;
            color: #000;
        }

        #navDrop li a:last-child:hover {
            color: #fa0;
        }

        /* Set height of the grid to 450px so .sidenav can be 100% (adjust as needed) */

        .row.content {
            height: 685px; //padding: 50px;
        }

        /* Set gray background color and 100% height */

        .sidenav {
            padding-top: 20px;
            background-color: #fff;
            height: 100%;


        }

        /* Set black background color, white text and some padding */

        footer {
            background-color: #f5f5f5;
            color: #777;
            padding: 15px;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */

        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }
            .row.content {
                height: auto;
            }
        }

        * {
            box-sizing: border-box;
        }

        /* basic stylings ------------------------------------------ */

        .container {
            font-family: 'Roboto';
            width: 600px;
            margin: 30px auto 0;
            display: block;
            background: #FFF;
            padding: 10px 50px 50px;
        }

        h2 {
            text-align: center;
            margin-bottom: 50px;
        }

        h2 small {
            font-weight: normal;
            color: #888;
            display: block;
        }

        .footer {
            text-align: center;
        }

        .footer a {
            color: #53B2C8;
        }

        /* form starting stylings ------------------------------- */

        .group {
            position: relative;
            margin-bottom: 45px;
        }

      


/*

  input {
            font-size: 18px;
            padding: 10px 10px 10px 5px;
            display: block;
            width: 100%; //300px;
            border: none;
            border-bottom: 1px solid #757575;
        }

        input:focus {
            outline: none;
        }
       

        /* LABEL ======================================= */

        .labels {
            color: #999;
            font-size: 18px;
            font-weight: normal;
            position: absolute;
            pointer-events: none;
            left: 5px;
            top: 10px;
            transition: 0.2s ease all;
            -moz-transition: 0.2s ease all;
            -webkit-transition: 0.2s ease all;
        }

        /* active state */

        input:focus~.labels,
        input:valid~.labels {
            top: -20px;
            font-size: 14px;
            color: #5264AE;
        }






        /* BOTTOM BARS ================================= */

        .bar {
            position: relative;
            display: block;
            width: 100%; //300px;
        }

        .bar:before,
        .bar:after {
            content: '';
            height: 2px;
            width: 0;
            bottom: 1px;
            position: absolute;
            background: #5264AE;
            transition: 0.2s ease all;
            -moz-transition: 0.2s ease all;
            -webkit-transition: 0.2s ease all;
        }

        .bar:before {
            left: 50%;
        }

        .bar:after {
            right: 50%;
        }

        /* active state */

        input:focus~.bar:before,
        input:focus~.bar:after {
            width: 50%;
        }

        /* HIGHLIGHTER ================================== */

        .highlight {
            position: absolute;
            height: 60%;
            width: 100px;
            top: 25%;
            left: 0;
            pointer-events: none;
            opacity: 0.5;
        }

        /* active state */

        input:focus~.highlight {
            -webkit-animation: inputHighlighter 0.3s ease;
            -moz-animation: inputHighlighter 0.3s ease;
            animation: inputHighlighter 0.3s ease;
        }

        /* ANIMATIONS ================ */

        @-webkit-keyframes inputHighlighter {
            from {
                background: #5264AE;
            }
            to {
                width: 0;
                background: transparent;
            }
        }

        @-moz-keyframes inputHighlighter {
            from {
                background: #5264AE;
            }
            to {
                width: 0;
                background: transparent;
            }
        }

        @keyframes inputHighlighter {
            from {
                background: #5264AE;
            }
            to {
                width: 0;
                background: transparent;
            }
        }

        .glyphicon {
            margin-right: 10px;
        }

        .panel-body {
            padding: 0px;
        }

        .panel-body table tr td {
            padding-left: 15px
        }

        .panel-body .table {
            margin-bottom: 0px;
        }

    </style>

</head>

<body>

{% include 'templates/partials/navbar.php' %}
{% block content %}{% endblock %}
{% include 'templates/partials/footer.php' %}



<script type="text/javascript">
    $(document).ready(function() {
    $('#myTable').DataTable();
    } );

   $(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
  
});

</script>



<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

</body>

</html>