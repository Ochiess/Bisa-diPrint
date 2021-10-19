
<div class="app-wrapper-footer">
    <div class="app-footer">
        <div class="app-footer__inner">
            <div class="app-footer-right">
                <span>Copyright &copy; diPrint Allright Reserved</span>
            </div>
        </div>
    </div>
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
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable();
    });

    var agen_id = '<?= $id ?>';
    countPesanan();
    function countPesanan() {
        $.ajax({
            url     : 'controller.php',
            method  : "POST",
            data    : {
                req: 'countPesanan',
                id: agen_id
            },
            success : function(data) {
                if (data.all <= 0) $('.countPesanan').attr('hidden', '').text(data.all);
                else $('.countPesanan').removeAttr('hidden').text(data.all);

                if (data.review <= 0) $('.badgeReview').attr('hidden', '').text(data.review);
                else $('.badgeReview').removeAttr('hidden').text(data.review);

                if (data.proccess <= 0) $('.badgeProccess').attr('hidden', '').text(data.proccess);
                else $('.badgeProccess').removeAttr('hidden').text('.');

                if (data.done <= 0) $('.badgeDone').attr('hidden', '').text(data.done);
                else $('.badgeDone').removeAttr('hidden').text(data.done);

                if (data.panding <= 0) $('.badgePanding').attr('hidden', '').text(data.panding);
                else $('.badgePanding').removeAttr('hidden').text(data.panding);
            }
        });
    }

    function createMessage(to, type, content=null) {
        $.ajax({
            url     : 'controller.php',
            method  : "POST",
            data    : {
                req: 'createMessage',
                send_by: 'agen',
                from_id: agen_id,
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
        database.ref('device_token/agen_token/'+agen_id).set({
            agen_id : agen_id,
            token : token
        });
    }).catch(function (err) {
        console.log("Unable to get permission to notify.", err);
    });

    function pushMessage(to, title, message) {
        database.ref('device_token/user_token/'+to).on('value', function(item) {
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