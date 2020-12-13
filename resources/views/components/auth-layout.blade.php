<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/admin/images/favicon.ico">

    <!-- App css -->
    <link href="/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin/css/app.min.css" rel="stylesheet" type="text/css" />
    <style>
        body.authentication-bg {
            background-image: none;
        }

    </style>
</head>


<body class="authentication-bg">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            {{ $slot }}
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->


    <!-- Vendor js -->
    <script src="/admin/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="/admin/js/app.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".alertMessage").delay(2000).slideUp(500);
        });

    </script>
</body>

</html>
