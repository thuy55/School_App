importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');
var firebaseConfig = {
    apiKey: "AIzaSyDhWYmMTaQvB17zMlDlebMrci3nCwzHnzI",
    authDomain: "eclo-b31e2.firebaseapp.com",
    projectId: "eclo-b31e2",
    storageBucket: "eclo-b31e2.appspot.com",
    messagingSenderId: "644021674157",
    appId: "1:644021674157:web:d8c1757c978a692c51e624",
    measurementId: "G-LTYMWY4Z38"
};
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();


messaging.onBackgroundMessage(function(payload) {
  // console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: payload.notification.icon,
    click_action: payload.notification.click_action
  };
  self.registration.showNotification(notificationTitle,
    notificationOptions);
});
// messaging.onMessage((payload) => {
//   console.log('Message received. ', payload);
//   // ...
// });