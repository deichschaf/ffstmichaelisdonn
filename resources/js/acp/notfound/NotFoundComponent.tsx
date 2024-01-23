import React from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../component/atoms/PageHeadline';
import AlertNotFoundBox from '../../component/molecules/AlertBox/NotFound';
import { NotFoundProps } from '../../props/props';

const NotFoundComponent: React.FC<React.PropsWithChildren<NotFoundProps>> = (
  props: NotFoundProps,
): JSX.Element => (
  <div className="container">
    <div className="overview_headline">
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <PageHeadline label="404 Seite nicht gefunden!" />
        </Col>
      </Row>
    </div>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        <AlertNotFoundBox text="Leider wurde die passende Seite nicht gefunden!" />
      </Col>
    </Row>
  </div>
);

export default NotFoundComponent;
