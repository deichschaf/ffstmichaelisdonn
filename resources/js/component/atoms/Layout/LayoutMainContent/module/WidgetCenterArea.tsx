import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { WidgetCenterProps } from '../../../../../props/props';
import WidgetCenter from '../../../../organisms/Widget/Center';

const WidgetCenterArea: React.FC<React.PropsWithChildren<WidgetCenterProps>> = (
  props: WidgetCenterProps
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
  if (typeof props.pagedata.data.widgets.center === 'undefined') {
    return <></>;
  }
  return (
    <>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <WidgetCenter widget={props.widget} pagedata={props.pagedata} />
        </Col>
      </Row>
    </>
  );
};
export default WidgetCenterArea;
