<?php
include 'header.php';
?>
<style>
    .dpl{
        background-image: url(https://wallpaperaccess.com/full/2112.jpg);
    background-size: 100vh 100vw;
    }
</style>
<body>

    <div class="container-fluid">
        <div class="row">
            <div id="pcsz" class="col-sm-4 col-md-3 vh-100 border-end">
                <div class="mt-4 mb-4 text-center">
                    <span id="login_user_image"></span><br />
                    <div class="mt-3 mb-3" id="login_user_name"></div>
                    <div class="text-center mt-3 mb-3">
                        <button type="button" class="btn btn-info btn-sm" id="setting_button">Settings</button>
                        <button type="button" class="btn btn-danger btn-sm" id="logout_button">Logout</button>
                    </div>
                </div>
                <hr class="bg-secondary border-2 border-top border-secondary">
                <div class="mt-4 mb-4 overflow-auto">
                    <h6 class="border-bottom pb-2 mb-0">Connected People</h6>
                    <div id="connected_people_area" class="noo"></div>
                </div>
            </div>
            <div class="col-sm-4 col-md-6 vh-100">
                <div id="chat_area">

                </div>
            </div>
            <div id="pcsz" class="col-sm-4 col-md-3 vh-100  border-start">
                <div class="pt-4 pb-4 h-50 overflow-auto">
                    <h6 class="border-bottom pb-2 mb-3">Search People</h6>
                    <input type="text" name="search_people" id="search_people" class="form-control" placeholder="Write Name..." autocomplete="off" />
                    <div id="search_people_area" class="mt-3"></div>
                </div>
                <div class="pt-4 pb-4 h-50 overflow-auto">
                    <h6 class="border-bottom pb-2 mb-3">Notification</h6>
                    <div id="notification_area" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script>
    function $(selector) {
        return document.querySelector(selector);
    }

    check_login();

    reset_chat_area();

    var interval;

    function check_login() {
        fetch('backend/check_login.php').then(function(response) {

            return response.json();

        }).then(function(responseData) {

            if (responseData.user_name && responseData.image) {
                _('login_user_name').innerHTML = '<h3>' + responseData.user_name + '</h3>';
                _('login_user_image').innerHTML = '<img src="' + responseData.image + '" width="150" class="bi me-2 rounded-circle img-fluid user_uploaded_image" />';

                load_chat_request();
            } else {
                window.location.href = 'account.php';
            }
        });
    }

    $('#logout_button').onclick = function() {
        var form_data = new FormData();

        form_data.append('action', 'logout');

        fetch('backend/logout.php', {

            method: "POST",

            body: form_data

        }).then(function(response) {

            return response.json();

        }).then(function(responseData) {

            window.location.href = 'account.php';

        });
    }

    $('#search_people').onkeyup = function() {
        var query = _('search_people').value;

        if (query.length > 2) {
            var form_data = new FormData();

            form_data.append('query', query);

            fetch('backend/search_user.php', {

                method: "POST",

                body: form_data

            }).then(function(response) {

                return response.json();

            }).then(function(responseData) {

                var html = '<div class="d-flex text-muted pt-3">';
                if (responseData.length > 0) {
                    for (var i = 0; i < responseData.length; i++) {
                        html += '<img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="images/' + responseData[i].ui + '" />';
                        html += '<div class="pb-4 mb-0 small lh-sm border-bottom w-100">';
                        html += '<div class="d-flex justify-content-between">';
                        html += '<strong class="text-white">' + responseData[i].un + '</strong>';
                        html += '<button type="button" name="chat_connect" class="btn btn-primary btn-sm chat_connect" id="' + responseData[i].uc + '">Connect</button>'
                        html += '</div>';
                        html += '</div>';
                    }
                } else {
                    html += '<strong class="text-danger">No People Found</strong>';
                }
                html += '</div>';

                _('search_people_area').innerHTML = html;

                if (responseData.length > 0) {
                    $('.chat_connect').onclick = function() {

                        let uc = this.getAttribute('id');

                        send_request(uc);
                    };
                }
            });
        }
    };

    function send_request(uc) {
        $('#' + uc + '').disabled = true;

        var form_data = new FormData();

        form_data.append('uc', uc);

        form_data.append('action', 'send_request');

        fetch('backend/chat_request.php', {

            method: "POST",

            body: form_data

        }).then(function(response) {

            return response.json();

        }).then(function(responseData) {

            $('#' + uc + '').disabled = true;

            $('#' + uc + '').classList.add('btn-success');

            $('#' + uc + '').classList.remove('btn-primary');

            $('#' + uc + '').innerHTML = 'Request Send';

        });
    }

    load_chat_request();

    function load_chat_request() {
        var form_data = new FormData();

        form_data.append('action', 'load_request');

        fetch('backend/chat_request.php', {

            method: "POST",

            body: form_data

        }).then(function(response) {

            return response.json();

        }).then(function(responseData) {

            var html = '<div class="d-flex text-muted pt-3">';
            if (responseData.length > 0) {
                for (var i = 0; i < responseData.length; i++) {
                    html += '<img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="images/' + responseData[i].ui + '" />';
                    html += '<div class="pb-4 mb-0 small lh-sm border-bottom w-100">';
                    html += '<div class="d-flex justify-content-between">';
                    html += '<strong class="text-info">' + responseData[i].un + '</strong>';
                    html += '<button type="button" name="accept_request" class="btn btn-primary btn-sm accept_request" id="' + responseData[i].rc + '">Accept</button>';
                    html += '</div>';
                    html += '</div>';
                }
            } else {
                html += '<strong class="text-gray-dark">No Notification Found</strong>';
            }
            $('#notification_area').innerHTML = html;

            load_chat_connected_people();

            if (responseData.length > 0) {


                $('.accept_request').onclick = function() {

                    let rc = this.getAttribute('id');

                    accept_request(rc);

                };
            }

        });
    }

    function accept_request(rc) {
        $('#' + rc + '').disabled = true;

        var form_data = new FormData();

        form_data.append('rc', rc);

        form_data.append('action', 'accept_request');

        fetch('backend/chat_request.php', {

            method: "POST",

            body: form_data

        }).then(function(response) {

            return response.json();

        }).then(function(responseData) {

            $('#' + rc + '').classList.add('btn-success');

            $('#' + rc + '').classList.remove('btn-primary');

            $('#' + rc + '').innerHTML = 'Accepted';

            load_chat_connected_people();

        });
    }

    load_chat_connected_people();

    function load_chat_connected_people() {
        var form_data = new FormData();

        form_data.append('action', 'load_connected_people');

        fetch('backend/chat_request.php', {

            method: "POST",

            body: form_data

        }).then(function(response) {

            return response.json();

        }).then(function(responseData) {

            var html = '';
            if (responseData.length > 0) {
                for (var i = 0; i < responseData.length; i++) {
                    html += '<div class="d-flex text-muted pt-3">';
                    html += '<img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="images/' + responseData[i].ui + '" />';
                    html += '<div class="pb-4 mb-0 small lh-sm border-bottom w-100">';
                    html += '<div class="d-flex justify-content-between">';
                    html += '<strong class="text-info">' + responseData[i].un + '</strong>';
                    html += '<button type="button" name="start_request" class="btn btn-warning btn-sm start_request" id="' + responseData[i].uc + '">Start Chat</button>';
                    html += '</div>';
                    html += '</div></div>';
                }
            } else {
                html += '<strong class="text-gray-dark">No People Found</strong>';
            }
            $('#connected_people_area').innerHTML = html;

            if (responseData.length > 0) {
                var elements = document.getElementsByClassName("start_request");

                //console.log(elements);

                for (var i = 0; i < elements.length; i++) {


                    elements[i].onclick = function() {

                        let uc = this.getAttribute('id');

                        start_chat(uc);

                    };
                }
            }
        });
    }

    function reset_chat_area() {
        var html = '<div id="pcsz" class="row vh-100 align-items-center justify-content-center text-muted fw-bold">Select People for chat</div>';
        $('#chat_area').innerHTML = html;
        clearInterval(interval);
    }

    function start_chat(uc) {
        reset_chat_area();
        var html = '<div id="chat_msg_area" class="pt-2 pb-2" style="height: 80vh;">';
        html += '<div class="card h-100">';
        html += '<div class="card-header"><div class="row"><div class="col" id="chat_user_data"></div><div class="col"><button type="button" class="btn btn-danger btn-sm float-end" id="close_chat">Close</button></div></div></div>';
        html += '<div class="card-body overflow-auto" id="chat_conversion"></div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="row align-items-end" style="height: 10vh;">';
        html += '<div class="col mb-1">';
        html += '<div class="input-group">';
        html += '<textarea rows="4" name="type_chat_message" id="type_chat_message" class="form-control" placeholder="Type your message here..." aria-label="Type your message here..." aria-describedby="button-addon2"></textarea>';
        html += '<button class="btn btn-success" type="button" id="button-addon2">Send</button>';
        html += '<input type="hidden" name="hidden_receiver_id" id="hidden_receiver_id" value="' + uc + '" /><input type="hidden" id="hidden_last_chat_datetime" />';
        html += '</div></div></div>';
        $('#chat_area').innerHTML = html;

        fetch_chat_data(uc);

        $('#close_chat').onclick = function() {
            $('#chat_area').innerHTML = '';
            reset_chat_area();
        };

        $('#button-addon2').onclick = function() {

            $('#button-addon2').disabled = true;

            var form_data = new FormData();

            form_data.append('action', 'send_chat');

            form_data.append('receiver_user_id', $('#hidden_receiver_id').value);

            form_data.append('msg', $('#type_chat_message').value);

            fetch('backend/chat_request.php', {

                method: "POST",

                body: form_data

            }).then(function(response) {

                return response.json();

            }).then(function(responseData) {

                $('#button-addon2').disabled = false;

                if (responseData.error != '') {
                    alert(responseData.error);
                } else {
                    $('#type_chat_message').value = '';

                    //$('#chat_conversion').innerHTML += responseData.lc;

                    //scroll_top();
                }

            });
        };

        interval = setInterval(function() {

            fetch_chat_data(uc, $('#hidden_last_chat_datetime').value);

        }, 1000);
    }

    function fetch_chat_data(receiver_user_id, last_chat_datetime) {
        var form_data = new FormData();

        form_data.append('action', 'load_chat');

        form_data.append('receiver_user_id', receiver_user_id);

        form_data.append('last_chat_datetime', last_chat_datetime);

        fetch('backend/chat_request.php', {

            method: "POST",

            body: form_data,

            cache: "no-cache"

        }).then(function(response) {

            return response.json();

        }).then(function(responseData) {

            if (responseData.receiver_image && responseData.receiver_name) {
                $('#chat_user_data').innerHTML = '<div class="d-flex text-muted"><img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="images/' + responseData.receiver_image + '" /><div class="mb-0 small lh-sm w-100 align-middle"><div class="d-flex justify-content-between"><strong class="text-dark">' + responseData.receiver_name + '</strong></div></div></div>';
            }

            var chat_html = '';

            if (responseData.cm) {
                for (var i = 0; i < responseData.cm.length; i++) {
                    if (responseData.cm[i].action == 'Send') {
                        chat_html += '<div class="card text-white bg-info mb-3 w-75 float-end">';
                        chat_html += '<div class="card-body">';
                        chat_html += responseData.cm[i].msg;
                        chat_html += '</div>';
                        chat_html += '<div class="card-footer text-white text-end"><small><img src="images/' + responseData.sender_image + '" width="25" class="rounded-circle me-2" /><b>' + responseData.sender_name + '</b> on ' + responseData.cm[i].dt + '</small></div>';
                        chat_html += '</div>';
                    } else {
                        chat_html += '<div class="card text-dark bg-warning mb-3 w-75">';
                        chat_html += '<div class="card-body">';
                        chat_html += responseData.cm[i].msg;
                        chat_html += '</div>';
                        chat_html += '<div class="card-footer text-muted text-end"><small><img src="images/' + responseData.receiver_image + '" width="25" class="rounded-circle me-2" /><b>' + responseData.receiver_name + '</b> on ' + responseData.cm[i].dt + '</small></div>';
                        chat_html += '</div>';
                    }

                }

                $('#hidden_last_chat_datetime').value = responseData.last_chat_datetime;

                if (last_chat_datetime == '') {
                    $('#chat_conversion').innerHTML = chat_html;
                } else {
                    $('#chat_conversion').innerHTML += chat_html;
                }

                scroll_top();
            }


        });
    }



    function scroll_top() {
        $('#chat_conversion').scrollTop = $('#chat_conversion').scrollHeight;
    }

    function setting_page() {
        var user_data = '';
        fetch('backend/fetch_user_data.php').then(function(response) {

            return response.json();

        }).then(function(responseData) {

            var html = '<div class="dpl"><div class="row vh-100 align-items-center justify-content-center"><div class="col col-sm-8 align-self-center"><span id="register_error"></span>';
            html += '<form class="p-4 p-md-3 border rounded-3 bg-light" id="setting" method="POST" enctype="multipart/form-data" autocomplete="off"><button type="button" class="btn-close float-end" id="close_setting_page" aria-label="Close"></button>';
            html += '<h1 class="display-6 fw-bold mb-4 text-center">Settings</h1>';
            html += '<div class="row">';
            html += '<div class="col-md-6">';
            html += '<div class="form-floating mb-3">';
            html += '<input type="text" class="form-control" id="user_first_name" placeholder="First Name" name="user_first_name" required autocomplete="off" value="' + responseData.ufn + '">';
            html += '<label for="user_first_name">First Name</label>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-6">';
            html += '<div class="form-floating mb-3">';
            html += '<input type="text" class="form-control" id="user_last_name" placeholder="Last Name" name="user_last_name" required autocomplete="off" value="' + responseData.uln + '">';
            html += '<label for="user_last_name">Last Name</label>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-floating mb-3">';
            html += '<input type="email" class="form-control" id="user_email" placeholder="name@example.com" name="user_email" autocomplete="off" required value="' + responseData.ue + '">';
            html += '<label for="user_email">Email address</label>';
            html += '</div>';
            html += '<div class="form-floating mb-3">';
            html += '<input type="password" class="form-control" id="user_password" placeholder="Password" name="user_password" autocomplete="off" required value="' + responseData.up + '">';
            html += '<label for="user_password">Password</label>';
            html += '</div>';
            html += '<div class="mb-3">';
            html += '<input type="file" name="user_image" id="user_image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required><input type="hidden" name="hidden_user_image" id="hidden_user_image" value="' + responseData.ui + '" /><br />';
            html += '<img src="images/' + responseData.ui + '" id="user_uploaded_image" style="height:200px;width="200px;" class="img-fluid rounded mt-2 mb-1" />';
            html += '</div>';
            html += '<button class="w-100 btn btn-lg btn-primary" id="save_button" type="submit">Save</button>';
            html += '</form></div></div></div>';

            $('#chat_area').innerHTML = html;

            $('#close_setting_page').onclick = function() {
                reset_chat_area();
            }

            $('#save_button').onclick = function() {

                var form_data = new FormData($('#setting'));

                $('#save_button').disabled = true;

                $('#save_button').innerHTML = 'Please Wait...';

                fetch('backend/setting.php', {

                    method: "POST",

                    body: form_data

                }).then(function(response) {

                    return response.json();

                }).then(function(responseData) {

                    $('#save_button').disabled = false;

                    $('#save_button').innerHTML = 'Save';

                    if (responseData.error != '') {
                        var error = '<div class="alert alert-danger"><ul>' + responseData.error + '</ul></div>';
                        $('#register_error').innerHTML = error;
                    } else {
                        $('#register_error').innerHTML = '<div class="alert alert-success">' + responseData.success + '</div>';

                        $('#user_image').value = '';

                        check_login();

                        $('#user_uploaded_image').src = 'images/' + responseData.ui + '';

                        $('#hidden_user_image').value = responseData.ui;

                    }

                    setTimeout(function() {

                        _('register_error').innerHTML = '';

                    }, 10000);

                });
            }

        });


    }

    $('#setting_button').onclick = function() {

        reset_chat_area();

        setting_page();
    };



    function _(element) {
        return document.getElementById(element);
    }
</script>