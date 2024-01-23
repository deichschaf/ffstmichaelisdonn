import React from 'react';
import { Col, Row, Spinner } from 'react-bootstrap';
import AlertInfoBox from '../../molecules/AlertBox/Info';
import ErrorBoundary from '../../organisms/errorboundary';

function getSpinner() {
  return (
    <Spinner animation="border" role="status">
      <span className="sr-only">Loading...</span>
    </Spinner>
  );
}

const LoadingPage: React.FC<React.PropsWithChildren<unknown>> = () => {
  const textarray = [] as any;
  textarray.push(...textarray, getSpinner());
  textarray.push(...textarray, 'Bitte warten, die Daten werden geladen...');
  return (
    <ErrorBoundary>
      <Row className="justify-content-md-center">
        <Col md="auto">
          <br />
          <br />
          <AlertInfoBox headline="Bitte warten.." textarray={textarray} />
        </Col>
      </Row>
    </ErrorBoundary>
  );
};

export default LoadingPage;
