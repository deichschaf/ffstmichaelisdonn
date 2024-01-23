import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentRowProps } from '../../../../../props/props';

const ContentRow: React.FC<React.PropsWithChildren<ContentRowProps>> = (
  props: ContentRowProps,
): JSX.Element => (
  <Row className={props.className}>
    <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
      {props.children}
    </Col>
  </Row>
);
export default ContentRow;
