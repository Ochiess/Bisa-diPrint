import { initializeApp } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-app.js";
import { getDatabase, ref, set, onValue } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-database.js";
import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-messaging.js";
import { onBackgroundMessage } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-messaging-sw.js";

const firebaseConfig = {
    apiKey: "AIzaSyAju5B0X0LZPoPD0GEMgHkX4cVVuuexvoA",
    authDomain: "diprint.firebaseapp.com",
    databaseURL: "https://diprint-default-rtdb.firebaseio.com",
    projectId: "diprint",
    storageBucket: "diprint.appspot.com",
    messagingSenderId: "668022140321",
    appId: "1:668022140321:web:c24e877b14162f25846fe0"
};

const firebase = initializeApp(firebaseConfig)
const messaging = getMessaging(firebase);
const database = getDatabase();

export function onMessage() {
}

getToken(messaging, { vapidKey: 'BKXnqssa06sDtFZfEjVOfvPMP0z5V6HFdi5RWXI07KDirBoBYdbOUNrKLHmBub2-xD0SlgPf24wgQG-7mglaNjE' }).then((currentToken) => {
    if (currentToken) {
        set(ref(database, 'device_token/user_token/'+user_id), {
            user_id : user_id,
            token : currentToken
        });
    } else {
        console.log('No registration token available. Request permission to generate one.');    
    }
}).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);  
});

export function pushMessage(to, title, message) {
    onValue(ref(database, 'device_token/agen_token/'+to), (snapshot) => {
        if (snapshot.val()) {
            var token = snapshot.val().token;
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