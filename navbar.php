<header class="header">
        <nav class="navbar navbar-expand-lg fixed-top py-3">
            <div class="container"><a href="#" class="navbar-brand text-uppercase font-weight-bold">Personal Chatroom</a>
                <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>

                <div id="navbarSupportedContent" class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto mb-2">
                        <li class="nav-item active"><a href="index.php" class="nav-link text-uppercase font-weight-bold">Home</a></li>
                        <li class="nav-item"><a href="account.php" class="nav-link text-uppercase font-weight-bold">Chatroom</a></li>
                        <li class="nav-item"><a href="https://hrisikeshpal.000webhostapp.com/" class="nav-link text-uppercase font-weight-bold"  target="_blank">Group Chat</a></li>
                        <li class="nav-item"><a href="faq.php" class="nav-link text-uppercase font-weight-bold">FAQ</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
    </header>
    <style>
        .navbar {
            transition: all 0.4s;
        }

        .navbar .nav-link {
            color: #fff;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            color: #fff;
            text-decoration: none;
        }

        .navbar .navbar-brand {
            color: #fff;
        }


        /* Change navbar styling on scroll */
        .navbar.active {
            background: #fff;
            box-shadow: 1px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar.active .nav-link {
            color: #555;
        }

        .navbar.active .nav-link:hover,
        .navbar.active .nav-link:focus {
            color: #555;
            text-decoration: none;
        }

        .navbar.active .navbar-brand {
            color: #555;
        }


        /* Change navbar styling on small viewports */
        @media (max-width: 991.98px) {
            .navbar {
                background: #fff;
            }

            .navbar .navbar-brand,
            .navbar .nav-link {
                color: #555;
            }
        }
    </style>
    <script>
        $(function() {
            $(window).on('scroll', function() {
                if ($(window).scrollTop() > 10) {
                    $('.navbar').addClass('active');
                } else {
                    $('.navbar').removeClass('active');
                }
            });
        });
    </script>
</head>
<div class="row">