import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { useLocation } from 'react-router-dom';
import { ILocationProps } from '../../../props/props';
import NotFound from '../../atoms/NotFound/NotFound';
import H3 from '../../atoms/Typography/H3';
import ErrorBoundary from '../../organisms/errorboundary';

const NoMatch: React.FC<React.PropsWithChildren<ILocationProps>> = (
  props: ILocationProps,
): JSX.Element => {
  // @ts-ignore
  const { location } = useLocation();
  return (
    <ErrorBoundary>
      <Row className="justify-content-md-center">
        <Col md="auto">
          <NotFound />
          <br />
          <br />
          <H3 label="No match for" />
          <code>{location.pathname}</code>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};

export default NoMatch;
