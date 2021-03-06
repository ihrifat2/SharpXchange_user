<?php

require "dbconnect.php";
require "helpertwo.php";
require "header.php";

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sxcConBtn'])) {
    $sxcContName    = validate_input($_POST['sxcContName']);
    $sxcContMail    = validate_input($_POST['sxcContMail']);
    $sxcContSub     = validate_input($_POST['sxcContSub']);
    $sxcConTxt      = validate_input($_POST['sxcConTxt']);

    if (!empty($sxcContName) && !empty($sxcContMail) && !empty($sxcContSub) && !empty($sxcConTxt)) {
        $platform   = parse_user_agent()['platform'];
        $browser    = parse_user_agent()['browser'];
        $version    = parse_user_agent()['version'];
        $contact_name = ucfirst($sxcContName);
        $contact_mail = $sxcContMail;
        $contact_subj = ucfirst($sxcContSub);
        $contact_text = ucfirst($sxcConTxt);
        $dt         = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $time       = $dt->format('F j, Y, l g:i a');
        $ip         = get_ip_address();
        $notifyText = "New Contact Message Recieved";
        $notifyUrl  = "contactus.php";
        if (filter_var($contact_mail, FILTER_VALIDATE_EMAIL)) {
            $sqlQuery = "INSERT INTO `tbl_contact_info`(`contact_id`, `contact_name`, `contact_mail`, `contact_sub`, `contact_text`, `contact_date`, `contact_ip`, `contact_platform`, `contact_browser`, `contact_version`) VALUES (NULL, '$contact_name', '$contact_mail', '$contact_subj', '$contact_text', '$time', '$ip', '$platform', '$browser', '$version')";
            $sqlQuerynotify = "INSERT INTO `tbl_admin_notification`(`notify_id`, `notify_text`, `notify_url`, `notify_imran`, `notify_nur`, `notify_robin`) VALUES (NULL,'$notifyText','$notifyUrl','0','0','0')";
            $result         = mysqli_query($dbconnect, $sqlQuery);
            $resultnotify   = mysqli_query($dbconnect, $sqlQuerynotify);
            if ($result || $resultnotify) {
                $success       = "Contact Form Submitted.";
            } else {
                $error       = "Error while submitting form.";
            }
        } else {
            $error       = "Invalid Email.";
        }
    } else {
        $error  = "All fields are required.";
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SharpXchange">
    <meta name="author" content="Imran Hadid">
    <meta name="generator" content="Imran">
    <title>SharpXchange</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://asset.sharpxchange.com/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://asset.sharpxchange.com/assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <script src="https://asset.sharpxchange.com/assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://asset.sharpxchange.com/assets/js/sharpxchange.js"></script>
    <script src="https://asset.sharpxchange.com/assets/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <header class="sharpxchange-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-md-6 pt-1 sharpxchange-header-nav-left">
                    <a class="sharpxchange-header-logo text-dark" href="/">
                        <img src="https://asset.sharpxchange.com/assets/img/logo.png">
                    </a>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center sharpxchange-header-nav-right">
                    <a class="text-muted">
                        Work time: 10:00 - 20:00, GMT +6
                    </a>
                </div>
            </div>
        </header>

        <div class="nav-scroller py-1 mt-3 mb-3">
            <header class="masthead mb-auto">
                <div class="inner">
                    <nav class="nav nav-masthead justify-content-end">
                        <a class="nav-link" href="/">EXCHANGE</a>
                        <a class="nav-link" href="testimonials">TESTIMONIALS</a>
                        <a class="nav-link active" href="contact">CONTACT</a>
                        <a class="nav-link" href="about">ABOUT US</a>
                    </nav>
                </div>
            </header>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-sm-12 col-md-10">
                <form class="contactsection sharpxchange-main" method="post">
                    <h2 class="sharpxchange-header sharpxchange-post-title py-4 mb-4">Contact Us</h2>
                    <p id="error">
                        <?php
                            if (isset($error)) {
                                echo $error;
                            }
                        ?>
                    </p>
                    <p id="success">
                        <?php
                            if (isset($success)) {
                                echo $success;
                            }
                        ?>
                    </p>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="Name">Your name</label>
                            <input type="text" class="form-control" id="sxcContName" name="sxcContName">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="Email">Your email</label>
                            <input type="email" class="form-control" id="sxcContMail" name="sxcContMail">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="Subject">Subject</label>
                            <input type="text" class="form-control" id="sxcContSub" name="sxcContSub">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="Message">Message</label>
                            <textarea class="form-control" id="sxcConTxt" name="sxcConTxt"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-md-12">
                            <button class="btn btn-outline-sxc" id="sxcConBtn" name="sxcConBtn" type="Submit">Submit form</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="sharpxchange-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>Quick access</h3>
                    <ul>
                        <li>
                            <a href="/">Exchanger</a>
                        </li>
                        <li>
                            <a href="/testimonials">Testimonials</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Terms & Support</h3>
                    <ul>
                        <li>
                            <a href="/policy">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="/about">About Us</a>
                        </li>
                        <li>
                            <a href="/contact">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Contact Information</h3>
                    <ul>
                        <li>Email : </li>
                        <li>Facebook : </li>
                    </ul>
                </div>
            </div>
        </div>
        <p class="mt-3">Copyright © 2019. SharpXchange</p>
        <p><a href="#">Back to top</a></p>
    </footer>
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5ca249e21de11b6e3b064991/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
</body>
</html>