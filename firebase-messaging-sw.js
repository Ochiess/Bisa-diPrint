importScripts('https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.1.1/firebase-messaging.js');

firebase.initializeApp({
  apiKey: "AIzaSyAju5B0X0LZPoPD0GEMgHkX4cVVuuexvoA",
  authDomain: "diprint.firebaseapp.com",
  databaseURL: "https://diprint-default-rtdb.firebaseio.com",
  projectId: "diprint",
  storageBucket: "diprint.appspot.com",
  messagingSenderId: "668022140321",
  appId: "1:668022140321:web:c24e877b14162f25846fe0"
});

const messaging = firebase.messaging();

// messaging.onBackgroundMessage(function(payload) {
//   console.log('[firebase-messaging-sw.js] Received background message ', payload);
//   // Customize notification here
//   const notificationTitle = 'Background Message Title';
//   const notificationOptions = {
//     body: 'Background Message body.',
//     icon: '/firebase-logo.png'
//   };

//   self.registration.showNotification(notificationTitle,
//     notificationOptions);
// });