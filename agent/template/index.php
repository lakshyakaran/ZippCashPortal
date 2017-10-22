<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ZippCash | Bank Panel</title>

    <!-- Bootstrap core CSS -->

    <link href="<?php echo $apl->template_url; ?>/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo $apl->template_url; ?>/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $apl->template_url; ?>/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="<?php echo $apl->template_url; ?>/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $apl->template_url; ?>/css/maps/jquery-jvectormap-2.0.1.css" />
    <link href="<?php echo $apl->template_url; ?>/css/icheck/flat/green.css" rel="stylesheet" />
    <link href="<?php echo $apl->template_url; ?>/css/floatexamples.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $apl->template_url; ?>/css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">

    <script src="<?php echo $apl->template_url; ?>/js/jquery.min.js"></script>
    <script src="<?php echo $apl->template_url; ?>/js/jquery.countdown.js"></script>
    <script src="<?php echo $apl->template_url; ?>/js/nprogress.js"></script>
    <script src="<?php echo $apl->template_url; ?>/js/ajax.js"></script>
    <script src="<?php echo $apl->template_url; ?>/js/upload.js"></script>
    <script>
        NProgress.start();
    </script>

    <!--[if lt IE 9]>
        <script src="<?php echo $apl->template_url; ?>/../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $apl->template_url; ?>/https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="<?php echo $apl->template_url; ?>/https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>
<body style="background:#F7F7F7;">

    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
									<div>
											<img src="<?php echo $apl->template_url; ?>/images/logo.png" alt="..." class="img-circle" style = "width: 70px;margin-top: 10px;">
									</div>
                    <form>
                        <h1>Agent Login</h1>
												<div id = "error" style = "display: none;" class="alert alert-danger alert-dismissible fade in" role="alert">

												</div>
                        <div>
                            <input type="text" id = "login_id" class="form-control" placeholder="Login ID" required="" />
                        </div>
                        <div>
                            <input type="password" id = "password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <button class="btn btn-default submit" id = "sign_in">Log in</button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">
                            <div class="clearfix"></div>
                            <br />
                        </div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        </div>
    </div>

</body>

</html>
