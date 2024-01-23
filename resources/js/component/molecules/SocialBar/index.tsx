import React from 'react';
import { SocialBarProps } from '../../../props/props';
import FAB from '../../atoms/Icon/FAB';
import ErrorBoundary from '../../organisms/errorboundary';

const SocialBar: React.FC<React.PropsWithChildren<SocialBarProps>> = (
  props: SocialBarProps
): JSX.Element => {
  function buildLinkIcon(favicon, title, url, className) {
    return (
      <a href={url} className={`social_item${className}`} target="_blank">
        <FAB className={favicon} />
        <span>{title}</span>
      </a>
    );
  }

  function showLink(socialplatform, data) {
    if (typeof data === 'undefined') {
      return <></>;
    }
    if (socialplatform === 'facebook') {
      if (data.showfacebook === 1) {
        return buildLinkIcon('fa-facebook', 'Facebook', 'https:\\www.facebook.de', 'fb');
      }
      return <></>;
    }
    if (socialplatform === 'twitter') {
      if (data.showtwitter === 1) {
        return buildLinkIcon('fa-twitter', 'Facebook', 'https:\\www.twitter.com', 'tw');
      }
      return <></>;
    }
    if (socialplatform === 'linkedin') {
      if (data.showlinkedin === 1) {
        return buildLinkIcon('fa-linkedin', 'Linkedin', 'https:\\www.Linkedin.com', 'ld');
      }
      return <></>;
    }
    if (socialplatform === 'instagram') {
      if (data.showinstagram === 1) {
        return buildLinkIcon('fa-instagram', 'Instagram', 'https:\\www.instagram.com', 'in');
      }
      return <></>;
    }
    if (socialplatform === 'youtube') {
      if (data.showyoutube === 1) {
        return buildLinkIcon('fa-youtube', 'Youtube', 'https:\\www.youtube.com', 'you');
      }
      return <></>;
    }
    if (socialplatform === 'pinterest') {
      if (data.showpinterest === 1) {
        return buildLinkIcon('fa-pinterest', 'Pinterest', 'https:\\www.pinterest.com', 'pt');
      }
      return <></>;
    }
    return <></>;
  }

  return (
    <div className="social_bar_section">
      <div className="container">
        <div className="row">
          <div className="col-md-12">
            <div className="socail_bar_section_area">
              <ErrorBoundary>{showLink('facebook', props.data)}</ErrorBoundary>
              <ErrorBoundary>{showLink('twitter', props.data)}</ErrorBoundary>
              <ErrorBoundary>{showLink('linkedin', props.data)}</ErrorBoundary>
              <ErrorBoundary>{showLink('instagram', props.data)}</ErrorBoundary>
              <ErrorBoundary>{showLink('youtube', props.data)}</ErrorBoundary>
              <ErrorBoundary>{showLink('pinterest', props.data)}</ErrorBoundary>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
export default SocialBar;
