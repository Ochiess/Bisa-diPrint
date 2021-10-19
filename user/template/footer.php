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
            <h4 class="card-title"><strong>Chat</strong></h4> <a class="text-secondary" id="close-chat" href="#" data-abc="true"><i class="fa fa-times-circle fa-lg"></i></a>
        </div>
        <div class="scroll-area-lg">
            <div class="scrollbar-container" id="chat-content">
                <div class="media media-chat"> <img class="avatar" src="assets/images/avatars/4.jpg" alt="...">
                    <div class="media-body">
                        <p>Hi</p>
                        <p>How are you ...???</p>
                        <p>What are you doing tomorrow?<br> Can we come up a bar?</p>
                        <p class="meta"><time datetime="2018">23:58</time></p>
                    </div>
                </div>
                <div class="media media-meta-day">Today</div>
                <div class="media media-chat media-chat-reverse">
                    <div class="media-body">
                        <p>Hiii, I'm good.</p>
                        <p>How are you doing?</p>
                        <p>Long time no see! Tomorrow office. will be free on sunday.</p>
                        <p class="meta"><time datetime="2018">00:06</time></p>
                    </div>
                </div>
                <div class="media media-chat"> <img class="avatar" src="assets/images/avatars/4.jpg" alt="...">
                    <div class="media-body">
                        <p>Okay</p>
                        <p>We will go on sunday? </p>
                        <p class="meta"><time datetime="2018">00:07</time></p>
                    </div>
                </div>
                <div class="media media-chat media-chat-reverse">
                    <div class="media-body">
                        <p>That's awesome!</p>
                        <p>I will meet you Sandon Square sharp at 10 AM</p>
                        <p>Is that okay?</p>
                        <p class="meta"><time datetime="2018">00:09</time></p>
                    </div>
                </div>
                <div class="media media-chat"> <img class="avatar" src="assets/images/avatars/4.jpg" alt="...">
                    <div class="media-body">
                        <p>Okay i will meet you on Sandon Square </p>
                        <p class="meta"><time datetime="2018">00:10</time></p>
                    </div>
                </div>
                <div class="media media-chat media-chat-reverse">
                    <div class="media-body">
                        <p>Do you have pictures of Matley Marriage?</p>
                        <p class="meta"><time datetime="2018">00:10</time></p>
                    </div>
                </div>
                <div class="media media-chat"> <img class="avatar" src="assets/images/avatars/4.jpg" alt="...">
                    <div class="media-body">
                        <p>Sorry I don't have. i changed my phone.</p>
                        <p class="meta"><time datetime="2018">00:12</time></p>
                    </div>
                </div>
                <div class="media media-chat media-chat-reverse">
                    <div class="media-body">
                        <p>Okay then see you on sunday!!</p>
                        <p class="meta"><time datetime="2018">00:12</time></p>
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
            <a class="publisher-btn text-info" href="#" data-abc="true"><i class="fa fa-paper-plane"></i></a> </div>
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
    <script>
        var user_id = '<?= $id ?>';

        $(document).ready(function() {
            $('#dataTable').DataTable();
            $('.chat-content').hide();  

            $(document).find('.show-chat').click(function(event) {
                event.preventDefault();
                $('.chat-content').show('slow/400/fast');
                $('.dropdown-menu').removeClass('show');
            });

            $('#close-chat').click(function(event) {
                event.preventDefault();
                $('.chat-content').hide('slow/400/fast'); 
            });

            $('.app-container').click(function(event) {

            });
        });
        
        countPesanan();
        function countPesanan() {
            $.ajax({
                url     : 'controller.php',
                method  : "POST",
                data    : {
                    req: 'countPesanan',
                    id: user_id
                },
                success : function(data) {
                    if (data.pesanan <= 0) $('#countPesanan').attr('hidden', '').text(data.pesanan);
                    else $('#countPesanan').removeAttr('hidden').text(data.pesanan);

                    if (data.notif <= 0) {
                        $('.countNotif, .new-notif').attr('hidden', '').text(data.notif);
                    }
                    else {
                        $('.countNotif').removeAttr('hidden').text(data.notif);
                        $('.new-notif').removeAttr('hidden').text('New '+data.notif);
                    }

                    if (data.notif <= 0) {
                        $('.countMessage, .new-message').attr('hidden', '').text(data.pesan);
                    }
                    else {
                        $('.countMessage').removeAttr('hidden').text(data.pesan);
                        $('.new-message').removeAttr('hidden').text('New '+data.pesan);
                    }
                }
            });
        }

        function createMessage(to, type, content=null) {
            $.ajax({
                url     : 'controller.php',
                method  : "POST",
                data    : {
                    req: 'createMessage',
                    send_by: 'user',
                    from_id: user_id,
                    to_id: to,
                    type: type,
                    content: content,
                },
                success : function(data) {
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

        messaging.requestPermission().then(function () {
            return messaging.getToken()
        }).then(function(token) {
            database.ref('device_token/user_token/'+user_id).set({
                user_id : user_id,
                token : token
            });
        }).catch(function (err) {
            console.log("Unable to get permission to notify.", err);
        });

        function pushMessage(to, title, message) {
            database.ref('device_token/agen_token/'+to).on('value', function(item) {
                if (item.val()) {
                    var token = item.val().token;
                    $.ajax({
                        url     : 'https://fcm.googleapis.com/fcm/send',
                        method  : "POST",
                        headers  : {
                            "Content-Type"  : "application/json",
                            "Authorization" : "key=AAAAm4k47aE:APA91bG5NZXK7QtR7wddVbiyRSgA-drKMVtUcUOPzP_qxdJMbfs_3kAU23Nfir93NcPlU7BBRCqPWT1yYcMXK8HO0ryPZ2DD61a9mDCWYslqFH9bzWbI8G1Kd1c4_6R96uU30BNHETru",
                        },
                        data    : JSON.stringify({
                            "registration_ids" : [token],
                            "notification" : {
                                "title": title,
                                "body": message, 
                            },
                            "webpush" : {
                                "headers" : {
                                    "Urgency" : "high"
                                }
                            },
                            "webpush" : 10
                        })
                    });
                }
            });
        }

        messaging.onMessage((payload) => {
            countPesanan();
            console.log("ok");
        });

    </script>
</body>
</html>