import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ButtonAddLineProps } from '../../../props/props';
import Addicon from '../../atoms/Icon/Admin/Addicon';
import ErrorBoundary from '../../organisms/errorboundary';
import { Link } from 'react-router-dom';

const ButtonAddLine: React.FC<React.PropsWithChildren<ButtonAddLineProps>> = (
  props: ButtonAddLineProps
): JSX.Element => {
  if (typeof props.url === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <Link to={props.url} className="btn btn-primary btn-cons">
            <Addicon /> Hinzufügen
          </Link>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default ButtonAddLine;
