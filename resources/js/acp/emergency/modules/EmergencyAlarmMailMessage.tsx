import React, { useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import GridSimple from '../../../component/molecules/GridSimple';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { EmergencyAlarmMailMessageProps } from '../../../props/props';
import EmergencyRowEntry from './EmergencyRowEntry';
import { checkValueType } from './helper';

const EmergencyAlarmMailMessage: React.FC<
  React.PropsWithChildren<EmergencyAlarmMailMessageProps>
> = (props: EmergencyAlarmMailMessageProps): JSX.Element => {
  if (props.getAlarmEmailId === 0) {
    return <></>;
  }

  const keys = [];
  const values = [];
  Object.keys(props.getAlarmMailResponse).map((key, idx) => keys.push(key as never));
  Object.values(props.getAlarmMailResponse).map((value, idx) =>
    values.push(checkValueType(value, idx) as never),
  );

  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <GridSimple>
            {values.map((item, idx) => (
              <EmergencyRowEntry key={idx} keyname={keys[idx]} value={item} count={idx} />
            ))}
          </GridSimple>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default EmergencyAlarmMailMessage;
