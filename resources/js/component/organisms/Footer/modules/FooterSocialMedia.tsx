import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FooterSocialMediaProps } from '../../../../props/props';
import FAB from '../../../atoms/Icon/FAB';
import ErrorBoundary from '../../errorboundary';

const FooterSocialMedia: React.FC<React.PropsWithChildren<FooterSocialMediaProps>> = (
  props: FooterSocialMediaProps,
): JSX.Element => {
  if (typeof props.footer === 'undefined') {
    return <></>;
  }
  if (typeof props.footer.contact === 'undefined') {
    return <></>;
  }

  let factoryFacebook = '';
  let factoryInstagram = '';
  let hobbyFacebook = '';
  let hobbyInstagram = '';

  if (props.footer.contact.facebook_factory_url !== 'undefined') {
    if (
      props.footer.contact.facebook_factory_url !== null &&
      props.footer.contact.facebook_factory_url !== ''
    ) {
      factoryFacebook = props.footer.contact.facebook_factory_url;
    }
  }
  if (props.footer.contact.instagram_factory_url !== 'undefined') {
    if (
      props.footer.contact.instagram_factory_url !== null &&
      props.footer.contact.instagram_factory_url !== ''
    ) {
      factoryInstagram = props.footer.contact.instagram_factory_url;
    }
  }
  if (props.footer.contact.facebook_hobby_url !== 'undefined') {
    if (
      props.footer.contact.facebook_hobby_url !== null &&
      props.footer.contact.facebook_hobby_url !== ''
    ) {
      hobbyFacebook = props.footer.contact.facebook_hobby_url;
    }
  }
  if (props.footer.contact.instagram_hobby_url !== 'undefined') {
    if (
      props.footer.contact.instagram_hobby_url !== null &&
      props.footer.contact.instagram_hobby_url !== ''
    ) {
      hobbyInstagram = props.footer.contact.instagram_hobby_url;
    }
  }
  if (
    factoryInstagram === '' &&
    factoryFacebook === '' &&
    hobbyFacebook === '' &&
    hobbyInstagram === ''
  ) {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <h4 className="headline">Social Media</h4>
          <p className="text">
            Auch unterwegs immer auf dem Laufenden bleiben? Bleiben Sie mit uns in Kontakt und
            vernetzen Sie sich mit uns!
          </p>
          <ul className="list-inline socialmedia">
            {factoryFacebook !== '' ? (
              <li>
                <a
                  href={factoryFacebook}
                  target="_blank"
                  rel="noreferrer"
                  aria-label="Zu unserer Facebook-Seite"
                  className="btn btn-outline-light"
                >
                  <FAB className="facebook-f" />
                </a>
              </li>
            ) : (
              <></>
            )}
            {hobbyFacebook !== '' ? (
              <li>
                <a
                  href={hobbyFacebook}
                  target="_blank"
                  rel="noreferrer"
                  aria-label="Zu unserer Facebook-Seite"
                  className="btn btn-outline-light"
                >
                  <FAB className="facebook-f" />
                </a>
              </li>
            ) : (
              <></>
            )}
            {factoryInstagram !== '' ? (
              <li>
                <a
                  href={factoryInstagram}
                  target="_blank"
                  rel="noreferrer"
                  aria-label="Zu unserem Instagram-Account"
                  className="btn btn-outline-light"
                >
                  <FAB className="instagram" />
                </a>
              </li>
            ) : (
              <></>
            )}
            {hobbyInstagram !== '' ? (
              <li>
                <a
                  href={hobbyInstagram}
                  target="_blank"
                  rel="noreferrer"
                  aria-label="Zu unserem Instagram-Account"
                  className="btn btn-outline-light"
                >
                  <FAB className="instagram" />
                </a>
              </li>
            ) : (
              <></>
            )}
          </ul>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default FooterSocialMedia;
