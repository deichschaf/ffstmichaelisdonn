import React from 'react';
import { Col, Row, Spinner } from 'react-bootstrap';
import { AlertBoxInfoProps } from '../../../props/props';
import Button from '../../atoms/Buttons/Button';
import FAS from '../../atoms/Icon/FAS';
import H5 from '../../atoms/Typography/H5';
import P from '../../atoms/Typography/P';
import ErrorBoundary from '../../organisms/errorboundary';

const LoadingAlertBox: React.FC<React.PropsWithChildren<AlertBoxInfoProps>> = (
  props: AlertBoxInfoProps,
): JSX.Element => (
  <ErrorBoundary>
    <Row className="justify-content-md-center">
      <Col md="auto">
        <br />
        <br />
        <div className="alert alert-block alert-info fade in show">
          <h4 className="alert-heading">
            <FAS className="exclamation-circle" /> Info!
          </h4>
          <H5 className="alert-heading" label="Bitte warten.." />
          <Spinner animation="border" role="status">
            <span className="sr-only">Loading...</span>
          </Spinner>
          <P className="" label="Bitte warten, die Daten werden geladen.." />
        </div>
      </Col>
    </Row>
  </ErrorBoundary>
);

export default LoadingAlertBox;
