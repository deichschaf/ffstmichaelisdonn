import React from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../component/atoms/PageHeadline';
import AlertErrorBox from '../../component/molecules/AlertBox/Error';
import { ErrorPageProps } from '../../props/props';

const ErrorPageComponent: React.FC<React.PropsWithChildren<ErrorPageProps>> = (
  props: ErrorPageProps,
): JSX.Element => (
  <div className="container">
    <div className="overview_headline">
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <PageHeadline label="Technischer Fehler aufgetreten!" />
        </Col>
      </Row>
    </div>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        <AlertErrorBox text="Leider wurde die passende Seite nicht gefunden!" />
      </Col>
    </Row>
  </div>
);

export default ErrorPageComponent;
