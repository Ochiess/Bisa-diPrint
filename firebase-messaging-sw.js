const firebaseConfig = {
  apiKey: "AIzaSyAju5B0X0LZPoPD0GEMgHkX4cVVuuexvoA",
  authDomain: "diprint.firebaseapp.com",
  databaseURL: "https://diprint-default-rtdb.firebaseio.com",
  projectId: "diprint",
  storageBucket: "diprint.appspot.com",
  messagingSenderId: "668022140321",
  appId: "1:668022140321:web:c24e877b14162f25846fe0"
};

// firebase.initializeApp(firebaseConfig);

import { initializeApp } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-app.js";
import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-messaging.js";
import { onBackgroundMessage } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-messaging-sw.js";

const firebase = initializeApp(firebaseConfig)
const messaging = getMessaging();

onBackgroundMessage(messaging, (payload) => {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: '/firebase-logo.png'
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});