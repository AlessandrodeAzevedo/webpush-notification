self.addEventListener('push', (event) => { 
    self.registration.showNotification("Titulo", { body: "corpo" });
});