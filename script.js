const APP_SERVER_KEY = "";
function subscribe(){
    if ("serviceWorker" in navigator) {
        if ("Notification" in window) {
            if (Notification.permission === "granted") {
                navigator.serviceWorker.register(
                    '/webpush-notification/service-worker.js', 
                    {
                        scope: '/webpush-notification/'
                    }
                ).then(
                    function(serviceWorkerRegistration) {
                        var serviceWorker;
                        if (serviceWorkerRegistration.installing) {
                            serviceWorker = serviceWorkerRegistration.installing;
                            console.log('Service worker installing');
                        } else if (serviceWorkerRegistration.waiting) {
                            serviceWorker = serviceWorkerRegistration.waiting;
                            console.log('Service worker installed & waiting');
                        } else if (serviceWorkerRegistration.active) {
                            serviceWorker = serviceWorkerRegistration.active;
                            console.log('Service worker active');
                        }
                        if (serviceWorker) {
                            console.log("sw current state", serviceWorker.state);
                            if (serviceWorker.state == "activated") {
                                console.log("sw already activated - Do watever needed here");
                            }
                            serviceWorker.addEventListener("statechange", function(e) {
                                console.log("sw statechange : ", e.target.state);
                                if (e.target.state == "activated") {
                                    console.log("Just now activated. now we can subscribe for push notification")
                                    const options = {
                                        userVisibleOnly: true,
                                        applicationServerKey: APP_SERVER_KEY
                                    }
                                    serviceWorkerRegistration.pushManager.subscribe(options).then(
                                        function(pushSubscription) {
                                            console.log(pushSubscription.endpoint);
                                            document.getElementById('endpoint').innerHTML = "Endpoint:" + pushSubscription.endpoint;
                                        }, function(error) {
                                            console.log(error);
                                        }
                                    );
                                }
                            });
                        }
                    }
                );
            } else {
                Notification.requestPermission()
            }
        }
    }
}

Notification.requestPermission();

const buttonSubscribe = document.querySelector("button.subscribe")

buttonSubscribe.onclick = () => { subscribe() }
