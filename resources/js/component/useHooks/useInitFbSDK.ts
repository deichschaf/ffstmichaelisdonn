import React from 'react';

// Injects the Facebook SDK into the page
const injectFbSDKScript = () => {
  (function (d, s, id) {
    const js = d.createElement(s);
    const fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
      return;
    }
    js.id = id;
    // @ts-ignore
    js.src = 'https://connect.facebook.net/en_US/sdk.js';
    if (typeof fjs.parentNode !== 'undefined' && fjs.parentNode !== null) {
      fjs.parentNode.insertBefore(js, fjs);
    }
  })(document, 'script', 'facebook-jssdk');
};

export const useInitFbSDK = () => {
  const [isInitialized, setIsInitialized] = React.useState(false);

  // Initializes the SDK once the script has been loaded
  // https://developers.facebook.com/docs/javascript/quickstart/#loading
  // @ts-ignore
  window.fbAsyncInit = function () {
    // @ts-ignore
    if (typeof window.FB !== 'undefined') {
      // @ts-ignore
      window.FB.init({
        // Find your App ID on https://developers.facebook.com/apps/
        appId: process.env.REACT_APP_FACEBOOK_APP_ID,
        cookie: true,
        xfbml: true,
        version: 'v8.0',
      });

      // @ts-ignore
      window.FB.AppEvents.logPageView();
      setIsInitialized(true);
    }
  };

  injectFbSDKScript();

  return isInitialized;
};
