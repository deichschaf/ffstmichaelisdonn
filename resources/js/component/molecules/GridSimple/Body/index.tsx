import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { GridSimpleProps } from '../../../../props/props';

const GridBody: React.FC<React.PropsWithChildren<GridSimpleProps>> = (
  props: GridSimpleProps,
): JSX.Element => (
  <div className="grid-body no-border">
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        {props.children}
      </Col>
    </Row>
  </div>
);
export default GridBody;
