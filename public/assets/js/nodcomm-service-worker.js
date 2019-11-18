self.addEventListener('push', function(event) {
  if (event.data) {
    console.log('This push event has data: ', event.data);

    var pushData = event.data.json();

    const promiseChain  = self.registration.showNotification(pushData.title, {
        body: pushData.message, icon: pushData.icon
      });

    // const promiseChain  = self.registration.showNotification('Title', {
    //     body: 'Message'
    //   });

    event.waitUntil(promiseChain);
  } else {
    console.log('This push event has no data.');
  }
});