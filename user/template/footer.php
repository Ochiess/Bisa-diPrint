<!--footer-->
<footer>
    <div class="app-wrapper-footer">
        <div class="app-footer">
            <div class="app-footer__inner">
                <div class="app-footer-left">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; diPrint Allright Reserved</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

</div>
</div>

<link href="./../assets/css/chat.css" rel="stylesheet">

<div class="chat-content" tabindex="-1" role="menu" aria-hidden="true" x-placement="bottom-end">
    <div class="card card-bordered border border-light shadow">
        <div class="card-header">
            <div class="w-100">
                <img class="avatar mr-1" src="assets/images/avatars/4.jpg">
                <b style="text-transform: capitalize; margin-right: -10px;;">Kamisama Peint</b>
            </div>
            <a class="text-secondary" id="close-chat" href="#" data-abc="true"><i class="fa fa-times-circle fa-lg"></i></a>
        </div>
        <div class="scroll-area-lg">
            <div class="scrollbar-container" id="chat-content">
                <div class="media media-chat media-chat-in pb-0">
                    <div class="media-body">
                        <p>
                            <span style="color: black;">Sorry I don't have. i changed my phone. but i save your number phone</span>
                            <small class="meta pull-right mt-2">&nbsp;<time>00:12</time></small>
                        </p>
                        <p>
                            <span style="color: black;">Okay then see you on sunday!!</span>
                            <small class="meta pull-right mt-2">&nbsp;<time>00:20</time></small>
                        </p>
                        <p>
                            <span style="color: black;">Okay..</span>
                            <small class="meta pull-right mt-2">&nbsp;<time>00:20</time></small>
                        </p>
                    </div>
                </div>
                <div class="media media-chat media-chat-reverse pt-1">
                    <div class="media-body">
                        <p>
                            <span>Do you have pictures of Matley Marriage? Okay then see you on sunday!!</span>
                            <small class="meta pull-right mt-2">&nbsp;<time>00:30</time></small>
                        </p>
                        <p>
                            <span>Okay..</span>
                            <small class="meta pull-right mt-2">&nbsp;<time>00:20</time></small>
                        </p>
                    </div>
                </div>
                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                    <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                </div>
                <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                    <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
                </div>
            </div>
        </div>
        <div class="publisher bt-1 border-light">
            <?php if ($photo) { ?>
                <img class="avatar avatar-xs" src="../user/img/<?php echo $photo ?>" alt="">
            <?php } else { ?>
                <img class="avatar avatar-xs" src="../user/img/default.png" alt="">
            <?php } ?>
            <input class="publisher-input" type="text" placeholder="Silahkan tulis pesan...">
            <a class="publisher-btn text-info" href="#" data-abc="true"><i class="fa fa-paper-plane"></i></a>
        </div>
    </div>
</div>

<script src="./../layout/vendor/jquery/jquery.min.js"></script>
<script src="./assets/scripts/main.js"></script>
<script src="./assets/sweetalert2/sweetalert2.min.js"></script>
<script src="./../assets/izitoast/js/iziToast.min.js"></script>
<script src="./../layout/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="./../layout/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-messaging.js"></script>
<script type="text/javascript">
    var user_id = '<?= $id ?>';

    $('#dataTable').DataTable();
    $('.chat-content').hide();

    $(document).find('#messsageContent').on('click', '.show-chat', function(event) {
        event.preventDefault();
        $('.chat-content').show('slow/400/fast');
        $('.dropdown-menu').removeClass('show');
    });

    $(document).on('click', '.show-chat', function(event) {
        event.preventDefault();
        $('.chat-content').show('slow/400/fast');
        $('.dropdown-menu').removeClass('show');
    });

    $('.search-button').click(function(e) {
        e.preventDefault();

        var keyword = $('.search-input').val();
        if (keyword != '') {
            location.href = 'marchent.php?key=' + keyword;
        }
    });

    $('#close-chat').click(function(event) {
        event.preventDefault();
        $('.chat-content').hide('slow/400/fast');
    });

    $(document).find('#notifContent').on('click', '.updateNotif', function(event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        var href = $(this).attr('data-href');
        $.ajax({
            url: 'controller.php',
            method: "POST",
            data: {
                req: 'updateNotif',
                id: id
            },
            success: function(data) {
                window.location.href = href
            }
        });
    });

    countPesanan();

    function countPesanan() {
        $.ajax({
            url: 'controller.php',
            method: "POST",
            data: {
                req: 'countPesanan',
                id: user_id
            },
            success: function(data) {
                if (data.pesanan <= 0) $('#countPesanan').attr('hidden', '').text(data.pesanan);
                else $('#countPesanan').removeAttr('hidden').text(data.pesanan);

                if (data.notif <= 0) {
                    $('.countNotif, .new-notif').attr('hidden', '').text(data.notif);
                } else {
                    $('.countNotif').removeAttr('hidden').text(data.notif);
                    $('.new-notif').removeAttr('hidden').text('New ' + data.notif);
                }

                if (data.pesan <= 0) {
                    $('.countMessage, .new-message').attr('hidden', '').text(data.pesan);
                } else {
                    $('.countMessage').removeAttr('hidden').text(data.pesan);
                    $('.new-message').removeAttr('hidden').text('New ' + data.pesan);
                }
            }
        });
    }

    getNotifPesan();

    function getNotifPesan() {
        $.ajax({
            url: 'controller.php',
            method: "POST",
            data: {
                req: 'getNotifPesan',
                id: user_id
            },
            success: function(data) {
                $(document).find('#notifContent').html(data.notif);
                $(document).find('#messsageContent').html(data.pesan);
            }
        });
    }

    function createMessage(to, type, content = null) {
        $.ajax({
            url: 'controller.php',
            method: "POST",
            data: {
                req: 'createMessage',
                send_by: 'user',
                from_id: user_id,
                to_id: to,
                type: type,
                content: content,
            },
            success: function(data) {
                pushMessage(to, data.title, data.message);
            }
        });
    }

    // Firebase Config
    const firebaseConfig = {
        apiKey: "AIzaSyAju5B0X0LZPoPD0GEMgHkX4cVVuuexvoA",
        authDomain: "diprint.firebaseapp.com",
        databaseURL: "https://diprint-default-rtdb.firebaseio.com",
        projectId: "diprint",
        storageBucket: "diprint.appspot.com",
        messagingSenderId: "668022140321",
        appId: "1:668022140321:web:c24e877b14162f25846fe0"
    };

    firebase.initializeApp(firebaseConfig)
    const messaging = firebase.messaging();
    const database = firebase.database();

    messaging.requestPermission().then(function() {
        return messaging.getToken()
    }).then(function(token) {
        database.ref('device_token/user_token/' + user_id).set({
            user_id: user_id,
            token: token
        });
    }).catch(function(err) {
        console.log("Unable to get permission to notify.", err);
    });

    function pushMessage(to, title, message) {
        database.ref('device_token/agen_token/' + to).on('value', function(item) {
            if (item.val()) {
                var token = item.val().token;
                $.ajax({
                    url: 'https://fcm.googleapis.com/fcm/send',
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "key=AAAAm4k47aE:APA91bG5NZXK7QtR7wddVbiyRSgA-drKMVtUcUOPzP_qxdJMbfs_3kAU23Nfir93NcPlU7BBRCqPWT1yYcMXK8HO0ryPZ2DD61a9mDCWYslqFH9bzWbI8G1Kd1c4_6R96uU30BNHETru",
                    },
                    data: JSON.stringify({
                        "registration_ids": [token],
                        "notification": {
                            "title": title,
                            "body": message,
                        },
                        "webpush": {
                            "headers": {
                                "Urgency": "high"
                            }
                        },
                        "webpush": 10
                    })
                });
            }
        });
    }

    messaging.onMessage((payload) => {
        countPesanan();
        getNotifPesan();
        console.log("ok");
    });
</script>
</body>

</html>