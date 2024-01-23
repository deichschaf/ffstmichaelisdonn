import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ButtonLineProps } from '../../../props/props';
import FAS from '../../atoms/Icon/FAS';
import ErrorBoundary from '../../organisms/errorboundary';
import { Link } from 'react-router-dom';

const ButtonLine: React.FC<React.PropsWithChildren<ButtonLineProps>> = (
  props: ButtonLineProps
): JSX.Element => {
  if (typeof props.url === 'undefined') {
    return <></>;
  }
  if (typeof props.title === 'undefined') {
    return <></>;
  }
  if (typeof props.icon === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <Link to={props.url} className="btn btn-primary btn-cons">
            <FAS className={props.icon} title="" /> {props.title}
          </Link>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default ButtonLine;
