// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here, other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.15.5/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
firebase.initializeApp({
    // apiKey: "AIzaSyBCP__OPx7xBDNeg2r84LOcqHazPY0Inhg",
    // authDomain: "kriscent-kartsupermarket.firebaseapp.com",
    // databaseURL: "https://kriscent-kartsupermarket.firebaseio.com",
    // projectId: "kriscent-kartsupermarket",
    // storageBucket: "kriscent-kartsupermarket.appspot.com",
    // messagingSenderId: "1035543561350",
    // appId: "1:1035543561350:web:9220d5e7147713758f7d07",
    // measurementId: "G-D2NGL7J02E"
    apiKey: "AIzaSyC2wtgs4lUpGNTWryU0TpaTE7CE8-pULwc",
    authDomain: "mnandiretailsolutions.firebaseapp.com",
    projectId: "mnandiretailsolutions",
    storageBucket: "mnandiretailsolutions.appspot.com",
    messagingSenderId: "249319490337",
    appId: "1:249319490337:web:21a1c40b2573f59ebab460",
    measurementId: "G-N0G62JW2R0",
    databaseURL: "https://mnandiretailsolutions-default-rtdb.europe-west1.firebasedatabase.app/",
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();