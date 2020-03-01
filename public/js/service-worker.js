self.addEventListener('push', function(e) {
  if (!(self.Notification && self.Notification.permission === 'granted')) {
      return;
  }
  if (e.data) {
      var msg = e.data.json();
      e.waitUntil(
          self.registration.showNotification(msg.title, {
              body: msg.body,
              icon: msg.icon,
              image: msg.icon
          })
      );
  }
});