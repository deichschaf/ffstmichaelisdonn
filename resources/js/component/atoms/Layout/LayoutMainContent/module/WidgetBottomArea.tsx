import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { WidgetTopProps } from '../../../../../props/props';
import WidgetBottom from '../../../../organisms/Widget/Bottom';

const WidgetBottomArea: React.FC<React.PropsWithChildren<WidgetTopProps>> = (
  props: WidgetTopProps
): JSX.Element => {
  if (typeof props.pagedata === 'undefined') {
    return <></>;
  }
  if (typeof props.widget === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.data === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.data.widgets === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.data.widgets.top === 'undefined') {
    return <></>;
  }
  return (
    <>
      <Row>
        <Col xxl={9} xl={9} lg={9} md={12} sm={12} xs={12}>
          <WidgetBottom widget={props.widget} pagedata={props.pagedata} />
        </Col>
        <Col xxl={3} xl={3} lg={3} md={12} sm={12} xs={12}></Col>
      </Row>
    </>
  );
};
export default WidgetBottomArea;
