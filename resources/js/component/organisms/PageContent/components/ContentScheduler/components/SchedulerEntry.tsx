import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { SchedulerEntryProps } from '../../../../../../props/props';
import ErrorBoundary from '../../../../errorboundary';

const SchedulerEntry: React.FC<React.PropsWithChildren<SchedulerEntryProps>> = (
  props: SchedulerEntryProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  const { data } = props;
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={2} xl={2} lg={2} md={2} sm={6} xs={12}>
          {data.date} -{data.time}
        </Col>
        <Col xxl={3} xl={3} lg={3} md={3} sm={6} xs={12}>
          {data.title}
        </Col>
        <Col xxl={3} xl={3} lg={3} md={3} sm={6} xs={12}>
          {data.place}
        </Col>
        <Col xxl={2} xl={2} lg={2} md={2} sm={6} xs={12}>
          {data.description}
        </Col>
        <Col xxl={2} xl={2} lg={2} md={2} sm={6} xs={12}>
          {data.wear}
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default SchedulerEntry;
