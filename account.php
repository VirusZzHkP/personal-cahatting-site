<?php
include 'header.php';
include 'navbar.php';
?>

<body>
    <main>
    <div class="b-example-divider"></div>

        <div class="headings">
            
            <img src="fontend/img/icon.png" alt="icon" class="icon">
            <p style="font-family: 'Bungee', cursive;color: white;text-align: center;font-size: 2em;text-shadow: 1px 1px 2px darkblue, 0 0 25px blue, 0 0 5px white;">Personal Chatroom</p>
        </div>

        <div class="container col-xl-10 col-xxl-8 px-4 py-5">
            <div class="row g-lg-5 py-5">
                <div class="col-md-10 mx-auto col-lg-6">
                    <span id="login_error"></span>
                    <form class="p-4 p-md-5 border rounded-3 bg-light" id="login" method="POST" autocomplete="off" style="box-shadow: 0px 4px 85px 32px rgba(0,0,0,0.45) inset,25px 0px 20px -20px rgba(0,0,0,0.45),0px 25px 20px -20px rgba(0,0,0,0.45),-25px 0px 20px -20px rgba(0,0,0,0.45);">
                        <h1 class="display-6 fw-bold mb-4 text-center">Login</h1>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="user_email" placeholder="name@example.com" name="user_email" autocomplete="off" required>
                            <label for="user_email">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="user_password" placeholder="Password" name="user_password" autocomplete="off" required>
                            <label for="user_password">Password</label>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" id="login_button" type="submit">Login</button>
                    </form>
                </div>
                <div class="col-md-10 mx-auto col-lg-6">
                    <span id="register_error"></span>
                    <form class="p-4 p-md-5 border rounded-3 bg-light" id="register" method="POST" enctype="multipart/form-data" autocomplete="off" style="box-shadow: 0px 4px 85px 32px rgba(0,0,0,0.45) inset,25px 0px 20px -20px rgba(0,0,0,0.45),0px 25px 20px -20px rgba(0,0,0,0.45),-25px 0px 20px -20px rgba(0,0,0,0.45);">
                        <h1 class="display-6 fw-bold mb-4 text-center">Register</h1>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="user_first_name" placeholder="First Name" name="user_first_name" required autocomplete="off">
                                    <label for="user_first_name">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="user_last_name" placeholder="Last Name" name="user_last_name" required autocomplete="off">
                                    <label for="user_last_name">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="user_email" placeholder="name@example.com" name="user_email" autocomplete="off" required>
                            <label for="user_email">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="user_password" placeholder="Password" name="user_password" autocomplete="off" required>
                            <label for="user_password">Password</label>
                        </div>
                        <div class="mb-3">

                            <input type="file" name="user_image" id="user_image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>

                        </div>
                        <button class="w-100 btn btn-lg btn-primary" id="register_button" type="submit">Register</button>
                    </form>
                </div>
            </div>
        </div>
        <p style="font-family: 'Bungee', cursive;color: white;text-align: center;font-size: 1em;text-shadow: 1px 1px 2px darkblue, 0 0 25px blue, 0 0 5px white; ">©VirusZzWarning 2022</p>

        <div class="b-example-divider"></div>

    </main>

</body>

</html>
<?php
include 'footer.php';
?>

<script>
    function _(element) {
        return document.getElementById(element);
    }

    check_login();

    function check_login() {
        fetch('backend/check_login.php').then(function(response) {

            return response.json();

        }).then(function(responseData) {

            if (responseData.user_name && responseData.image) {
                window.location.href = 'chat.php';
            }

        });
    }

    _('register').onsubmit = function(event) {
        event.preventDefault();
    }

    _('register_button').onclick = function() {

        var form_data = new FormData(_('register'));

        _('register_button').disabled = true;

        _('register_button').innerHTML = 'Please Wait...';

        fetch('backend/register.php', {

            method: "POST",

            body: form_data

        }).then(function(response) {

            return response.json();

        }).then(function(responseData) {

            _('register_button').disabled = false;

            _('register_button').innerHTML = 'Register';

            if (responseData.error != '') {
                var error = '<div class="alert alert-danger"><ul>' + responseData.error + '</ul></div>';
                _('register_error').innerHTML = error;
            } else {
                _('register_error').innerHTML = '<div class="alert alert-success">' + responseData.success + '</div>';

                _('register').reset();
            }

            setTimeout(function() {

                _('register_error').innerHTML = '';

            }, 10000);

        });

    }

    _('login').onsubmit = function(event) {
        event.preventDefault();
    }

    _('login_button').onclick = function() {

        var form_data = new FormData(_('login'));

        _('login_button').disabled = true;

        _('login_button').innerHTML = 'Please Wait...';

        fetch('backend/login.php', {

            method: "POST",

            body: form_data

        }).then(function(response) {

            return response.json();

        }).then(function(responseData) {

            _('login_button').disabled = false;

            _('login_button').innerHTML = 'Login';

            if (responseData.error != '') {
                var error = '<div class="alert alert-danger"><ul>' + responseData.error + '</ul></div>';
                _('login_error').innerHTML = error;
            } else {
                window.location.href = 'chat.php';
            }

            setTimeout(function() {

                _('login_error').innerHTML = '';

            }, 10000);

        });

    }

    let url = window.location.href;

    let params = (new URL(url)).searchParams;

    if (params.get('msg')) {
        let param_val = params.get('msg');
        if (param_val == 'success') {
            _('login_error').innerHTML = '<div class="alert alert-success">Your Email Successfully Verified, now you can login</div>';
        } else {
            _('login_error').innerHTML = '<div class="alert alert-info">Wrong URL</div>';
        }

        setTimeout(function() {
            window.location.href = 'account.php';
        }, 5000);
    }
</script>