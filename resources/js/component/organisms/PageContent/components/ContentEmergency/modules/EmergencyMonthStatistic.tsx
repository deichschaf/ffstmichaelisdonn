import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { EmergencyMonthStatisticProps } from '../../../../../../props/props';
import StatisticLine from '../../../../../atoms/Statistic/StatisticLine';
import ErrorBoundary from '../../../../errorboundary';

const EmergencyMonthStatistic: React.FC<React.PropsWithChildren<EmergencyMonthStatisticProps>> = (
  props: EmergencyMonthStatisticProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  const legende = [
    'Januar',
    'Februar',
    'März',
    'April',
    'Mai',
    'Juni',
    'Juli',
    'August',
    'September',
    'Oktober',
    'November',
    'Dezember',
  ];
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <StatisticLine data={props.data} legende={legende} />
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default EmergencyMonthStatistic;
