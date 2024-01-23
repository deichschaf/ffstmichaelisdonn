import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { SpacerProps } from '../../../props/props';

const Spacer: React.FC<React.PropsWithChildren<SpacerProps>> = (
  props: SpacerProps,
): JSX.Element => {
  let paragraph = false;
  if (props.paragraph !== 'undefined') {
    if (props.paragraph === true || props.paragraph === 1 || props.paragraph === '1') {
      paragraph = true;
    }
  }
  return (
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        {paragraph ? <p>&nbsp;</p> : <>&nbsp;</>}
      </Col>
    </Row>
  );
};
export default Spacer;
