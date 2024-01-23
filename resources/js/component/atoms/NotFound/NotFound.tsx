import React from 'react';
import { Col, Row } from 'react-bootstrap';
import ErrorBoundary from '../../organisms/errorboundary';
import PageHeadline from '../PageHeadline';

const NotFound: React.FC<React.PropsWithChildren<unknown>> = () => (
  <ErrorBoundary>
    <Row className="justify-content-md-center">
      <Col md="auto">
        <br />
        <br />
        <PageHeadline label="404: page not found" />
      </Col>
    </Row>
  </ErrorBoundary>
);

export default NotFound;
