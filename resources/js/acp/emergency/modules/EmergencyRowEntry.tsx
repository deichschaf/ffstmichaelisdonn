import React from 'react';
import { Col, Row } from 'react-bootstrap';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { EmergencyAlarmMailMessageRowEntryProps } from '../../../props/props';
import { checkValueType } from './helper';

const EmergencyRowEntry: React.FC<
  React.PropsWithChildren<EmergencyAlarmMailMessageRowEntryProps>
> = (props: EmergencyAlarmMailMessageRowEntryProps): JSX.Element => (
  <ErrorBoundary key={`row-${props.count}`}>
    <Row>
      <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
        {props.keyname}
      </Col>
      <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={12}>
        {checkValueType(props.value, props.count)}
      </Col>
    </Row>
  </ErrorBoundary>
);
export default EmergencyRowEntry;
