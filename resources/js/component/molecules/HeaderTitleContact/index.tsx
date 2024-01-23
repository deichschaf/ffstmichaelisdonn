import React from 'react';
import { Col, Row } from 'react-bootstrap';
import Globalvars from '../../../globalvars';
import { HeaderTitleContactProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import HeaderSocialMedia from './module/HeaderSocialMedia';

const HeaderTitleContact: React.FC<React.PropsWithChildren<HeaderTitleContactProps>> = (
  props: HeaderTitleContactProps,
): JSX.Element => {
  if (typeof props.header === 'undefined') {
    return <></>;
  }
  if (typeof props.header.contact === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <div className="container">
        <Row>
          <Col>
            <p>{Globalvars.getHomepageTitle()}</p>
          </Col>
        </Row>
        <Row>
          <Col>
            <ul className="list-inline pull-right">
              <HeaderSocialMedia social={props.header.contact} />
            </ul>
          </Col>
        </Row>
      </div>
    </ErrorBoundary>
  );
};
export default HeaderTitleContact;
