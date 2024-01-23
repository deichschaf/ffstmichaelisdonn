import React, { useCallback, useEffect, useState } from 'react';
import { useInitFbSDK } from '../../component/useHooks/useInitFbSDK';
import { FacebookPostComponentProps } from '../../props/props';

const FacebookPostComponent: React.FC<React.PropsWithChildren<FacebookPostComponentProps>> = (
  props: FacebookPostComponentProps,
): JSX.Element => {
  // You can find your Page ID
  // in the "About" section of your page on Facebook.
  const PAGE_ID = process.env.REACT_APP_FACEBOOK_PAGE_ID;
  // Initializes the Facebook SDK
  const isFbSDKInitialized = useInitFbSDK();

  // App state
  const [fbUserAccessToken, setFbUserAccessToken] = useState(null);
  const [fbPageAccessToken, setFbPageAccessToken] = useState(null);
  const [postText, setPostText] = useState('');
  const [isPublishing, setIsPublishing] = useState(false);

  // Logs in a Facebook user
  const logInToFB = useCallback(() => {
    // @ts-ignore
    window.FB.login(response => {
      setFbUserAccessToken(response.authResponse.accessToken);
    });
  }, []);

  // Logs out the current Facebook user
  const logOutOfFB = useCallback(() => {
    // @ts-ignore
    window.FB.logout(() => {
      setFbUserAccessToken(null);
      setFbPageAccessToken(null);
    });
  }, []);

  // Checks if the user is logged in to Facebook
  useEffect(() => {
    if (isFbSDKInitialized) {
      // @ts-ignore
      window.FB.getLoginStatus(response => {
        setFbUserAccessToken(response.authResponse?.accessToken);
      });
    }
  }, [isFbSDKInitialized]);

  // Fetches an access token for the page
  useEffect(() => {
    if (fbUserAccessToken) {
      // @ts-ignore
      window.FB.api(
        `/${PAGE_ID}?fields=access_token&access_token=${fbUserAccessToken}`,
        ({ access_token }) => setFbPageAccessToken(access_token),
      );
    }
  }, [fbUserAccessToken]);

  // Publishes a post on the Facebook page
  const sendPostToPage = useCallback(() => {
    setIsPublishing(true);

    // @ts-ignore
    window.FB.api(
      `/${PAGE_ID}/feed`,
      'POST',
      {
        message: postText,
        access_token: fbPageAccessToken,
      },
      () => {
        setPostText('');
        setIsPublishing(false);
      },
    );
  }, [postText, fbPageAccessToken]);

  // UI with custom styling from ./styles.css`
  return (
    <div id="app">
      <header id="app-header">
        <p id="logo-text">FB Page API</p>
        {fbUserAccessToken ? (
          <button onClick={logOutOfFB} className="btn confirm-btn">
            Log out
          </button>
        ) : (
          <button onClick={logInToFB} className="btn confirm-btn">
            Login with Facebook
          </button>
        )}
      </header>
      <main id="app-main">
        {fbPageAccessToken ? (
          <section className="app-section">
            <h3>Write something to the page</h3>
            <textarea
              value={postText}
              onChange={e => setPostText(e.target.value)}
              placeholder="Message..."
              disabled={isPublishing}
            />
            <button
              onClick={sendPostToPage}
              className="btn confirm-btn"
              disabled={!postText || isPublishing}
            >
              {isPublishing ? 'Publishing...' : 'Publish'}
            </button>
          </section>
        ) : (
          <h2 className="placeholder-container">Welcome!</h2>
        )}
      </main>
    </div>
  );
};
export default FacebookPostComponent;
