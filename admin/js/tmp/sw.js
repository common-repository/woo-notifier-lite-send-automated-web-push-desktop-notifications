// [START initialize_firebase_in_sw]
// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here, other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/3.5.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.5.2/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
  'messagingSenderId': '700183753796'
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
// [END initialize_firebase_in_sw]

self.addEventListener('push', function(event) {
  if (_webPushConfig.debug) console.log('Received a new push message', event);

  event.waitUntil(self.registration.pushManager.getSubscription().then(function(subscription) {
   if (_webPushConfig.debug) console.log('Push sub data', subscription);
      return fetch('SUB_PATH'+ encodeURIComponent(subscription.endpoint)).then(function(response) {  
          return response.json().then(function(json) {
          	if (_webPushConfig.debug) console.log('Push data received', json);
                  var promises = [];
                   for (var i = 0; i < json.notifications.length; i++) {
                    var single_notification = json.notifications[i];

                    if(!single_notification.title)
                        single_notification.title = 'New Notification!';

                    if(!single_notification.body)
                        single_notification.body = '';

                    if (_webPushConfig.debug) console.log("Showing notification: " + single_notification.body);
                    getDb().pushData.put({ tag: single_notification.tag, url: single_notification.url});
                    promises.push(showNotification(single_notification.title, single_notification.body, single_notification.icon, single_notification.tag));
                }
              return Promise.all(promises);
          });
      });
  }));

});

// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// [START background_handler]
messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  return response.json().then(function(json) {
  if(!single_notification.title)
  for (var i = 0; i < json.notifications.length; i++) {
  single_notification.title = 'New Notification!';
         
  const notificationTitle = single_notification.title;
  const notificationOptions = {
    body: single_notification.body,
    icon: 'firebase-logo.png'
  };
  }
  return self.registration.showNotification(notificationTitle,
      notificationOptions);
  }   
      
});
// [END background_handler]
