(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	// Initialize Firebase
//  Initialize Firebase
//  var config = {
//    apiKey: "AIzaSyCczbuWTW4Z-jONSZyZIpVCw1kxJsyFH-c",
//    authDomain: "woonotifier-ed7b4.firebaseapp.com",
//    databaseURL: "https://woonotifier-ed7b4.firebaseio.com",
//    storageBucket: "woonotifier-ed7b4.appspot.com",
//    messagingSenderId: "236619994145"
//  };
//  firebase.initializeApp(config);


	  // [START get_messaging_object]
	  // Retrieve Firebase Messaging object.
	  const messaging = firebase.messaging();
	  // [END get_messaging_object]
	
	  // IDs of divs that display Instance ID token UI or request permission UI.
	  const tokenDivId = 'token_div';
	  const permissionDivId = 'permission_div';
	
	  // [START refresh_token]
	  // Callback fired if Instance ID token is updated.
	  messaging.onTokenRefresh(function() {
	    messaging.getToken()
	    .then(function(refreshedToken) {
	      console.log('Token refreshed.');
	      // Indicate that the new Instance ID token has not yet been sent to the
	      // app server.
	      setTokenSentToServer(false);
	      // Send Instance ID token to app server.
	      sendTokenToServer(refreshedToken);
	      // [START_EXCLUDE]
	      // Display new Instance ID token and clear UI of all previous messages.
	      // [END_EXCLUDE]
	    })
	    .catch(function(err) {
	      console.log('Unable to retrieve refreshed token ', err);	      
	    });
	  });
	  // [END refresh_token]
	
	  // [START receive_message]
	  // Handle incoming messages. Called when:
	  // - a message is received while the app has focus
	  // - the user clicks on an app notification created by a sevice worker
	  //   `messaging.setBackgroundMessageHandler` handler.
	  messaging.onMessage(function(payload) {
	    console.log("Message received. ", payload);
	    // [START_EXCLUDE]
	    // Update the UI to include the received message.
	    // [END_EXCLUDE]
	  });
	  // [END receive_message]
	
	  function resetUI() {
	    // [START get_token]
	    // Get Instance ID token. Initially this makes a network call, once retrieved
	    // subsequent calls to getToken will return from cache.
	    messaging.getToken()
	    .then(function(currentToken) {
	      if (currentToken) {
	        sendTokenToServer(currentToken);
	        var data = {
				'action': 'wpn_register_device',
				'regId': currentToken
			};
			
			jQuery.post(pn_vars.ajaxurl, data, function(response) {
			console.log(response);
			});
	      } else {
	        // Show permission request.
	        console.log('No Instance ID token available. Request permission to generate one.');
	        setTokenSentToServer(false);
	      }
	    })
	    .catch(function(err) {
	      console.log('An error occurred while retrieving token. ', err);
	      setTokenSentToServer(false);
	    });
	  }
	  // [END get_token]
	
	  // Send the Instance ID token your application server, so that it can:
	  // - send messages back to this app
	  // - subscribe/unsubscribe the token from topics
	  function sendTokenToServer(currentToken) {
	    if (!isTokenSentToServer()) {
	      console.log('Sending token to server...');
	      // TODO(developer): Send the current token to your server.
	      setTokenSentToServer(true);
	    } else {
	      console.log('Token already sent to server so won\'t send it again ' +
	          'unless it changes');
	    }
	
	  }
	
	  function isTokenSentToServer() {
	    if (window.localStorage.getItem('sentToServer') == 1) {
	          return true;
	    }
	    return false;
	  }
	
	  function setTokenSentToServer(sent) {
	    if (sent) {
	      window.localStorage.setItem('sentToServer', 1);
	    } else {
	      window.localStorage.setItem('sentToServer', 0);
	    }
	  }
	
	  function showHideDiv(divId, show) {
	    const div = document.querySelector('#' + divId);
	    if (show) {
	      div.style = "display: visible";
	    } else {
	      div.style = "display: none";
	    }
	  }
	
	  function requestPermission() {
	    console.log('Requesting permission...');
	    // [START request_permission]
	    messaging.requestPermission()
	    .then(function() {
	      console.log('Notification permission granted.');
	      // TODO(developer): Retrieve an Instance ID token for use with FCM.
	      // [START_EXCLUDE]
	      // In many cases once an app has been granted notification permission, it
	      // should update its UI reflecting this.
	      // [END_EXCLUDE]
	    })
	    .catch(function(err) {
	      console.log('Unable to get permission to notify.', err);
	    });
	    // [END request_permission]
	  }
	
	  function deleteToken() {
	    // Delete Instance ID token.
	    // [START delete_token]
	    messaging.getToken()
	    .then(function(currentToken) {
	      messaging.deleteToken(currentToken)
	      .then(function() {
	        console.log('Token deleted.');
	        setTokenSentToServer(false);
	        // [START_EXCLUDE]
	        // Once token is deleted update UI.
	        // [END_EXCLUDE]
	      })
	      .catch(function(err) {
	        console.log('Unable to delete token. ', err);
	      });
	      // [END delete_token]
	    })
	    .catch(function(err) {
	      console.log('Error retrieving Instance ID token. ', err);
	    });
	
	  }
	  requestPermission();
	  resetUI();
})( jQuery );