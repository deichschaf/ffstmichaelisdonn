import React from 'react';
import { HeaderSocialMediaProps } from '../../../../props/props';
import { getCookie } from '../../../component_helper';
import ErrorBoundary from '../../../organisms/errorboundary';
import HeaderFacebook from './HeaderFacebook';
import HeaderInstagram from './HeaderInstagram';
import HeaderPhone from './HeaderPhone';

const HeaderSocialMedia: React.FC<React.PropsWithChildren<HeaderSocialMediaProps>> = (
  props: HeaderSocialMediaProps,
): JSX.Element => {
  const { social } = props;

  return (
    <ErrorBoundary>
      {getCookie('facebook') === '1' ? (
        social.facebook_factory_url !== '' ? (
          <HeaderFacebook
            name={social.facebook_factory_name}
            url={social.facebook_factory_url}
            show_icon
          />
        ) : (
          <></>
        )
      ) : (
        <></>
      )}
      {getCookie('facebook') === '1' ? (
        social.facebook_hobby_url !== '' ? (
          <HeaderFacebook
            name={social.facebook_hobby_name}
            url={social.facebook_hobby_url}
            show_icon
          />
        ) : (
          <></>
        )
      ) : (
        <></>
      )}
      {getCookie('instagram') === '1' ? (
        social.instagram_factory_url !== '' ? (
          <HeaderInstagram
            name={social.instagram_factory_name}
            url={social.instagram_factory_url}
            show_icon
          />
        ) : (
          <></>
        )
      ) : (
        <></>
      )}
      {getCookie('instagram') === '1' ? (
        social.instagram_hobby_url !== '' ? (
          <HeaderInstagram
            name={social.instagram_hobby_name}
            url={social.instagram_hobby_url}
            show_icon
          />
        ) : (
          <></>
        )
      ) : (
        <></>
      )}
      <HeaderPhone
        phonenumber={social.contact_phone}
        phonenumber_click={social.contact_phone_click}
        show_icon
      />
      <HeaderPhone
        phonenumber={social.contact_mobile}
        phonenumber_click={social.contact_mobile_click}
        show_icon
      />
    </ErrorBoundary>
  );
};
export default HeaderSocialMedia;
