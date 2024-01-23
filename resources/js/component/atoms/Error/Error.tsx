import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ErrorPageProps } from '../../../props/props';
import AlertBugBox from '../../molecules/AlertBox/Bug';
import AlertNotFoundBox from '../../molecules/AlertBox/NotFound';
import ErrorBoundary from '../../organisms/errorboundary';
import FAS from '../Icon/FAS';

const ErrorPage: React.FC<React.PropsWithChildren<ErrorPageProps>> = (
  props: ErrorPageProps,
): JSX.Element => (
  <ErrorBoundary>
    <Row className="justify-content-md-center">
      <Col md="auto">
        <br />
        <br />
        {props.status === 404 ? (
          <AlertNotFoundBox text={props.text} />
        ) : (
          <AlertBugBox text={props.text} showButton="false" headline={`CODE: ${props.headline}`} />
        )}
        <br />
        <br />
      </Col>
    </Row>
  </ErrorBoundary>
);

export default ErrorPage;
