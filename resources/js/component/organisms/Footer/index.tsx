import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FooterProps } from '../../../props/props';
import FAS from '../../atoms/Icon/FAS';
import ErrorBoundary from '../errorboundary';
import FooterContact from './modules/FooterContact';
import FooterContent from './modules/FooterContent';
import FooterEmergency from './modules/FooterEmergency';
import FooterService from './modules/FooterService';
import FooterSocialMedia from './modules/FooterSocialMedia';

const Footer: React.FC<React.PropsWithChildren<FooterProps>> = (
  props: FooterProps,
): JSX.Element => (
  <ErrorBoundary>
    <footer className="site-footer">
      <div className="container">
        <div className="mobile-footer">
          {props.footer !== undefined ? (
            <Row>
              <Col xxl={3} xl={3} lg={3} md={6} sm={12} xs={12} className="fbox">
                <FooterSocialMedia footer={props.footer} />
              </Col>
              <Col xxl={3} xl={3} lg={3} md={6} sm={12} xs={12} className="fbox">
                <FooterService footer={props.footer} />
              </Col>
              <Col xxl={3} xl={3} lg={3} md={6} sm={12} xs={12} className="fbox">
                <FooterEmergency data={props.data.data} />
              </Col>
              <Col xxl={3} xl={3} lg={3} md={6} sm={12} xs={12} className="fbox">
                <FooterContact footer={props.footer} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
        </div>
      </div>
      <div id="copyright">
        <div className="container">
          <div className="mobile-footer">
            {props.footer !== undefined ? (
              <Row>
                <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                  <p className="pull-left">
                    {typeof props.footer !== 'undefined' &&
                    typeof props.footer.homepageCopyright !== 'undefined' ? (
                      <>
                        {props.footer.homepageTitle} <FAS className="copyright" />{' '}
                        {props.footer.homepageCopyright}
                      </>
                    ) : (
                      <></>
                    )}
                  </p>
                </Col>
                <Col xxl={8} xl={8} lg={8} md={8} sm={0} xs={0} />
              </Row>
            ) : (
              <></>
            )}
          </div>
        </div>
      </div>
    </footer>
  </ErrorBoundary>
);
export default Footer;
